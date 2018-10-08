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
 * @date 03/04/17 15:58
 */
namespace Modules\Mail\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Model;
use Phact\Translate\Translator;

class Settings extends Model
{
    use Translator;

    public static function getFields() 
    {
        return [
            'receivers' => [
                'class' => CharField::class,
                'label' => self::t('Mail.main', 'E-mail receivers (default)'),
                'hint' => self::t('Mail.main', 'Comma-separated'),
                'null' => true
            ],
            'hidden_receivers' => [
                'class' => CharField::class,
                'label' => self::t('Mail.main', 'Hidden e-mail receivers (default)'),
                'hint' => self::t('Mail.main', 'Comma-separated'),
                'null' => true
            ]
        ];
    }
    
    public function __toString() 
    {
        return (string) $this->receivers;
    }
} 