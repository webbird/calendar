<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait CommonUtilsTrait
{
    /**
     * create a guid; used by the backend, but can also be used by modules
     *
     * @access public
     * @return string
     **/
    public function createGUID() : string
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', random_int(0, 65535), random_int(0, 65535), random_int(0, 65535), random_int(16384, 20479), random_int(32768, 49151), random_int(0, 65535), random_int(0, 65535), random_int(0, 65535));
    }   // end function createGUID()
    /**
     *
     * @access public
     * @return
     **/
    public function days()
    {
        return $this->startdate->diffInDays($this->enddate);
    }   // end function days()

    /**
     *
     * @access public
     * @return
     **/
    public function hours()
    {
        return $this->startdate->diffInHours($this->enddate);
    }   // end function hours()
}
