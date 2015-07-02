<?php
namespace kubacode\telstraSMS;

use Illuminate\Support\Facades\Facade;

class SMSFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SMS';
    }
}