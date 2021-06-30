<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class Booking extends Event
{
    /**
     *
     * @access public
     * @return
     **/
    public function specialKeys() : array
    {
        return array(
            'status' => '\webbird\Calendar\BookingStatus'
        );
    }   // end function specialKeys()

    /**
     *
     * @access public
     * @return
     **/
    public function setStatus(\webbird\Calendar\BookingStatus $status) : object
    {
        $this->status = $status;
        return $this;
    }   // end function addStatus()

    /**
     *
     * @access public
     * @return
     **/
    public function getStatus() : BookingStatus
    {
        if(empty($this->status)) {
            return new BookingStatus(
                name: 'nostatus',
                cssclass: 'noclass'
            );
        } else {
            return $this->status;
        }
    }   // end function getStatus()
}