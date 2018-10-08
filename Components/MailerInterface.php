<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 08/10/2018 13:34
 */

namespace Modules\Mail\Components;


interface MailerInterface
{
    /**
     * Send raw-data mail (to, body)
     * @param $to
     * @param $subject
     * @param $body
     * @param array $additional
     * @param array $attachments
     * @return mixed
     */
    public function raw($to, $subject, $body, array $additional = [], array $attachments = []);

    /**
     * Send mail with template to default e-mail addresses
     * @param $subject
     * @param $template
     * @param array $data
     * @param array $additional
     * @param array $attachments
     * @return mixed
     */
    public function send($subject, $template, array $data = [], array $additional = [], array $attachments = []);

    /**
     * Send mail with template to given e-mail address
     * @param $to
     * @param $subject
     * @param $template
     * @param array $data
     * @param array $additional
     * @param array $attachments
     * @return mixed
     */
    public function template($to, $subject, $template, array $data = [], array $additional = [], array $attachments = []);
}