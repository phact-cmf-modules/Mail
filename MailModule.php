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
 * @date 04/08/16 10:42
 */

namespace Modules\Mail;

use Modules\Mail\Forms\SettingsForm;
use Modules\Mail\Models\Settings;
use Phact\Module\Module;

class MailModule extends Module
{
    public function getVerboseName()
    {
        return $this->t('Mail.main', 'Mail');
    }

    public function getSettingsForm()
    {
        return new SettingsForm();
    }

    public function getSettingsModel()
    {
        return new Settings();
    }
}