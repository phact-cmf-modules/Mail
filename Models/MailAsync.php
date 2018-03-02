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

use Phact\Orm\Model;

class MailAsync extends Model
{
    public static function getFields() 
    {
        return [
        
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->name;
    }
} 