<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company HashStudio
 * @site http://hashstudio.ru
 * @date 12/08/16 10:40
 */

namespace Modules\Mail\Components;

use Exception;
use Phact\Main\Phact;
use Phact\Template\Renderer;
use PHPMailer;

class Mailer
{
    use Renderer;

    const MODE_SMTP = 'smtp';

    const MODE_MAIL = 'mail';

    public $mode = self::MODE_MAIL;

    public $config = [];

    public $defaultFrom;

    /**
     * Example: "http://example.com", "https://10.12.231.43:8000"
     * @var string
     */
    public $hostInfo;

    protected function getMailer()
    {
        $mailer = new PHPMailer();
        $mailer->CharSet = 'UTF-8';
        if ($this->mode == self::MODE_SMTP) {
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

    public function raw($to, $subject, $body, $additional = [], $attachments = [])
    {
        $message = $this->getMailer();
        if (!is_array($to)) {
            $to = [$to];
        }
        foreach ($to as $email) {
            $message->addAddress($email);
        }
        $message->isHTML(true);
        $message->Subject = $subject;
        $message->Body = $body;

        if (isset($additional['from'])) {
            $message->setFrom($additional['from']);
        } elseif ($this->defaultFrom) {
            $message->setFrom($this->defaultFrom);
        }
        $sent = $message->send();
        if (!$sent) {
            echo $message->ErrorInfo;
        }
        return $sent;
    }

    public function template($to, $subject, $template, $data = [], $additional = [], $attachments = [])
    {
        $data = array_merge($data, [
            'hostInfo' => $this->getHostInfo()
        ]);
        $body = self::renderTemplate($template, $data);
        return $this->raw($to, $subject, $body, $additional, $attachments);
    }
    
    public function getHostInfo()
    {
        if (!$this->hostInfo) {
            $this->hostInfo = Phact::app()->request->getHostInfo();
        }
        return $this->hostInfo;
    }
}