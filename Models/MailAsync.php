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
 * @date 02/03/18 20:16
 */
namespace Modules\Mail\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\DateTimeField;
use Phact\Orm\Fields\IntField;
use Phact\Orm\Fields\JsonField;
use Phact\Orm\Fields\TextField;
use Phact\Orm\Model;

class MailAsync extends Model
{
    const STATUS_WAIT = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;

    public static function getFields() 
    {
        return [
            'to' => [
                'class' => CharField::class,
            ],
            'subject' => [
                'class' => CharField::class,
                'null' => true
            ],
            'body' => [
                'class' => TextField::class,
                'null' => true
            ],
            'additional' => [
                'class' => JsonField::class,
                'null' => true
            ],
            'status' => [
                'class' => IntField::class,
                'default' => self::STATUS_WAIT,
                'choices' => [
                    self::STATUS_WAIT => 'wait',
                    self::STATUS_SUCCESS => 'success',
                    self::STATUS_ERROR => 'error'
                ]
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
                'null' => true
            ],
        ];
    }

    public function __toString() 
    {
        return (string) $this->to;
    }
} 