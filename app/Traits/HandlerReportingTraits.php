<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait HandlerReportingTraits {

    /**
     * Logs a simple message to log file
     * @param String $message
     */
    public static function simpleLog(string $message)
    {
        Log::info($message);
    }

    /**
     * Log the information of an exception to log file
     * @param Throwable $exception
     */
    public static function logAnException(Throwable $exception)
    {

        $exceptionFormat = "\n" . config('app.name') . "-EXCEPTION \nMESSAGE:: %s \nFILE:: %s \nLINE::%s \n\n";

        Log::info(sprintf($exceptionFormat,
            !empty(trim($exception->getMessage())) ? $exception->getMessage() : get_class($exception),
            $exception->getFile(),
            $exception->getLine()
        ));
    }

    public static function errorNotification()
    {

    }
}
