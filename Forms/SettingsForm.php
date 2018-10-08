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
use Phact\Translate\Translator;

class SettingsForm extends ModelForm
{
    use Translator;

    public function getFields()
    {
        $validator = function($value) {
            if ($value) {
                $emails = explode(',', $value);
                foreach ($emails as $email) {
                    $item = trim($email);
                    if ($item && !filter_var($item, FILTER_VALIDATE_EMAIL)) {
                        return self::t('Mail.main', 'Please provide a list of valid e-mail addresses');
                    }
                }
            }
            return true;
        };

        return [
            'receivers' => [
                'class' => CharField::class,
                'label' => self::t('Mail.main', 'Please provide a list of valid e-mail addresses'),
                'hint' => self::t('Mail.main', 'Comma-separated'),
                'required' => true,
                'validators' => [
                    $validator
                ]
            ],
            'hidden_receivers' => [
                'class' => CharField::class,
                'label' => self::t('Mail.main', 'Hidden e-mail receivers (default)'),
                'hint' => self::t('Mail.main', 'Comma-separated'),
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