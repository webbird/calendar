<?php

declare(strict_types=1);

namespace webbird\Calendar;

class OverlappingDatesException extends \ErrorException
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}