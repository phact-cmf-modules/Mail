<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company OrderTarget
 * @site http://ordertarget.ru
 * @date 02/03/18 20:22
 */

namespace Modules\Mail\Commands;


use Modules\Mail\Components\Mailer;
use Modules\Mail\Models\MailAsync;
use Phact\Commands\Command;

/**
 * Send deferred emails
 * Class SendAsyncCommand
 * @package Modules\Mail\Commands
 */
class SendAsyncCommand extends Command
{
    /** @var Mailer */
    protected $_mailer;

    public function __construct(Mailer $mailer)
    {
        $this->_mailer = $mailer;
    }

    public function handle($arguments = [])
    {
        $mailer = $this->getMail();
        $by = isset($arguments[0]) && is_int($arguments[0]) ? $arguments[0] : $mailer->asyncSendBy;
        $statuses = [MailAsync::STATUS_WAIT];
        if ($mailer->asyncErrorRetry) {
            $statuses[] = MailAsync::STATUS_ERROR;
        }
        /** @var MailAsync[] $models */
        $models = MailAsync::objects()->filter(['status__in' => $statuses])->limit($by)->order(['status', 'created_at'])->all();
        foreach ($models as $model) {
            $this->send($model);
        }
    }

    /**
     * @param $model MailAsync
     */
    public function send(MailAsync $model)
    {
        $mail = $this->getMail();

        $to = $model->to;
        $subject = $model->subject ?: '';
        $body = $model->body ?: '';
        $additional = $model->additional ?: [];

        $sent = false;
        if ($to) {
            $sent = $mail->low($to, $subject, $body, $additional);
        }
        if ($sent) {
            if ($mail->asyncAutoClean) {
                $model->delete();
            } else {
                $model->status = MailAsync::STATUS_SUCCESS;
                $model->save();
            }
        } else {
            $model->status = MailAsync::STATUS_ERROR;
            $model->save();
        }
    }

    /**
     * @return Mailer
     */
    public function getMail()
    {
        return $this->_mailer;
    }

    public function getDescription()
    {
        return 'Send deferred emails. Example (by 100): Mail SendAsync Handle 100';
    }
}