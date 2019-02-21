<?php

namespace Modules\Core\NotificationChannels\TextLocalSMS\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Descriptive error message.");
    }
}
