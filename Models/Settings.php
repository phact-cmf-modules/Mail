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

class Settings extends Model
{
    public static function getFields() 
    {
        return [
            'receivers' => [
                'class' => CharField::class,
                'label' => "Получатели писем (по-умолчанию)",
                'hint' => "Разделитель - запятая",
                'null' => true
            ],
            'hidden_receivers' => [
                'class' => CharField::class,
                'label' => "Скрытые получатели писем (по-умолчанию)",
                'hint' => "Разделитель - запятая",
                'null' => true
            ]
        ];
    }
    
    public function __toString() 
    {
        return $this->receivers;
    }
} 