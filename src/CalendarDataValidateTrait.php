<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait CalendarDataValidateTrait
{
    /**
     *
     * @access public
     * @return
     **/
    public function validateDay()
    {
        if (!$this->day || !is_int($this->day)) {
            if(isset($_REQUEST['day']) && in_array($_REQUEST['day'], range(1,31))) {
                $this->day = intval($_REQUEST['day']);
            } else {
                $this->day = date('j');
            }
        }
    }   // end function validateDay()

    /**
     *
     * @access public
     * @return
     **/
    public function validateMonth()
    {
        if (!$this->month || !is_int($this->month)) {
            if(isset($_REQUEST['month']) && in_array($_REQUEST['month'], range(1,12))) {
                $this->month = intval($_REQUEST['month']);
            } else {
                $this->month = date('n');
            }
        }
    }   // end function validateMonth()

    /**
     *
     * @access public
     * @return
     **/
    public function validateYear()
    {
        if (!$this->year || !is_int($this->year)) {
            if(isset($_REQUEST['year']) && in_array($_REQUEST['year'], range(1970,(date('Y')+200)))) {
                $this->year = intval($_REQUEST['year']);
            } else {
                $this->year = date('Y');
            }
        }
    }   // end function validateYear()
    
    
}
