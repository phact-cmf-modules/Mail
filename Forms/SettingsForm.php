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
 * @date 03/04/17 16:02
 */
namespace Modules\Mail\Forms;

use Phact\Form\Fields\CharField;
use Phact\Form\ModelForm;
use Modules\Mail\Models\Settings;

class SettingsForm extends ModelForm
{
    public function getFields()
    {
        $validator = function($value) {
            if ($value) {
                $emails = explode(',', $value);
                foreach ($emails as $email) {
                    $item = trim($email);
                    if ($item && !filter_var($item, FILTER_VALIDATE_EMAIL)) {
                        return "Пожалуйста, укажите список корректных e-mail адресов";
                    }
                }
            }
            return true;
        };

        return [
            'receivers' => [
                'class' => CharField::class,
                'label' => "Получатели писем (по-умолчанию)",
                'hint' => "Разделитель - запятая",
                'required' => true,
                'validators' => [
                    $validator
                ]
            ],
            'hidden_receivers' => [
                'class' => CharField::class,
                'label' => "Скрытые получатели писем (по-умолчанию)",
                'hint' => "Разделитель - запятая",
                'required' => false,
                'validators' => [
                    $validator
                ]
            ]
        ];
    }

    public function getModel()
    {
        return new Settings;
    }
}