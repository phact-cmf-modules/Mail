<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 12/08/16 10:40
 */

namespace Modules\Mail\Components;

use Exception;
use Modules\Mail\Models\MailAsync;
use Phact\Components\Settings;
use Phact\Request\HttpRequestInterface;
use Phact\Template\RendererInterface;
use PHPMailer;

class Mailer implements MailerInterface
{
    const MODE_SMTP = 'smtp';

    const MODE_MAIL = 'mail';

    public $mode = self::MODE_MAIL;

    public $config = [];

    public $debug = false;

    public $defaultFrom;

    public $defaultFromName = '';

    /**
     * Save emails to MailAsync and send it by SendAsync command
     * @var bool
     */
    public $async = false;

    /**
     * Send mails from MailAsync for 1 start
     *
     * @var int
     */
    public $asyncSendBy = 15;

    /**
     * Retry send, if got error with previous send
     * @var bool
     */
    public $asyncErrorRetry = false;

    /**
     * Remove successfully sent emails from MailAsync
     * @var bool
     */
    public $asyncAutoClean = true;

    /**
     * Example: "http://example.com", "https://10.12.231.43:8000"
     * @var string
     */
    public $hostInfo;

    /**
     * @var HttpRequestInterface
     */
    protected $_request;

    /**
     * @var Settings
     */
    protected $_settings;

    /**
     * @var RendererInterface
     */
    protected $_renderer;

    public function __construct(RendererInterface $renderer, Settings $settings, HttpRequestInterface $_request = null)
    {
        $this->_request = $_request;
        $this->_settings = $settings;
        $this->_renderer = $renderer;
    }

    protected function getMailer()
    {
        $mailer = new PHPMailer();
        $mailer->CharSet = 'UTF-8';
        if ($this->mode === self::MODE_SMTP) {
            $mailer->isSMTP();
            $mailer->Host = $this->getConfigOption('host');
            $mailer->SMTPAuth = $this->getConfigOption('auth', true, false);
            $mailer->Username = $this->getConfigOption('username');
            $mailer->Password = $this->getConfigOption('password');
            $mailer->SMTPSecure = $this->getConfigOption('secure', 'ssl', false);
            $mailer->Port = $this->getConfigOption('port', 465, false);
        }
        return $mailer;
    }

    protected function getConfigOption($name, $default = null, $exception = true)
    {
        if (isset($this->config[$name])) {
            return $this->config[$name];
        }
        if ($exception) {
            throw new Exception("Please, describe option '{$name}' for Mail component");
        }
        return $default;
    }

    public function raw($to, $subject, $body, array $additional = [], array $attachments = [])
    {
        if ($this->async) {
            return $this->createAsyncModel($to, $subject, $body, $additional, $attachments);
        } else {
            return $this->low($to, $subject, $body, $additional, $attachments);
        }
    }

    public function createAsyncModel($to, $subject, $body, $additional, $attachments)
    {
        $model = new MailAsync();
        $model->to = $to;
        $model->subject = $subject;
        $model->body = $body;
        $model->additional = $additional;
        $model->status = MailAsync::STATUS_WAIT;
        $model->save();
        return true;
    }

    public function low($to, $subject, $body, array $additional = [], array $attachments = [])
    {
        $message = $this->getMailer();
        foreach ($this->arrayEmails($to) as $email) {
            $message->addAddress($email);
        }
        $message->isHTML(true);
        $message->Subject = $subject;
        $message->Body = $body;

        if (isset($additional['from'])) {
            $message->setFrom($additional['from'], isset($additional['fromName']) ? $additional['fromName'] : '');
        } elseif ($this->defaultFrom) {
            $message->setFrom($this->defaultFrom, $this->defaultFromName);
        }

        if (isset($additional['bcc'])) {
            foreach ($this->arrayEmails($additional['bcc']) as $email) {
                $message->addBCC($email);
            }
        }

        $sent = $message->send();
        if (!$sent) {
            if ($this->debug) {
                echo $message->ErrorInfo;
            }
        }
        return $sent;
    }

    public function arrayEmails($emails)
    {
        if (!is_array($emails)) {
            $raw = explode(',', $emails);
            $emails = [];
            foreach ($raw as $email) {
                if ($item = trim($email)) {
                    $emails[] = $item;
                }
            }
        }
        return $emails;
    }

    public function template($to, $subject, $template, array $data = [], array $additional = [], array $attachments = [])
    {
        $data = array_merge($data, [
            'hostInfo' => $this->getHostInfo()
        ]);
        $body = $this->_renderer->render($template, $data);
        return $this->raw($to, $subject, $body, $additional, $attachments);
    }

    public function send($subject, $template, array $data = [], array $additional = [], array $attachments = [])
    {
        $bcc = $this->_settings->get('Mail.hidden_receivers');
        if ($bcc) {
            $additional['bcc'] = $bcc;
        }
        return $this->template($this->_settings->get('Mail.receivers'), $subject, $template, $data, $additional, $attachments);
    }
    
    public function getHostInfo()
    {
        if (!$this->hostInfo && $this->_request) {
            $this->hostInfo = $this->_request->getHostInfo();
        }
        return $this->hostInfo;
    }
}
