<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait CalendarDataValidateTrait
{

    /**
     * check if the given string is a timestamp
     *
     * @access  public
     * @param   int|string $timestamp
     * @return  bool
     **/
    public function isTimestamp(int|string $timestamp) : bool
    {
        return (ctype_digit($timestamp) && strtotime(date('Y-m-d H:i:s',(int)$timestamp)) === (int)$timestamp);
    }   // end function isTimestamp()

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
     * validates given $date
     * returns current date and time if $date is not valid
     *
     * @access public
     * @param  int|string|\DateTime $date
     * @return
     **/
    public function validateTimestamp(int|string|\DateTime $date) : \DateTime
    {
        if($date instanceof \DateTime) {
            return $date;
        } else {
            if($this->isTimestamp($date)) {
                $dt = new \DateTime();
                $dt->setTimestamp((int)$date);
                return $dt;
            }
        }
        return new \DateTime();
    }   // end function validateTimestamp()

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

    /**
     *
     * @access public
     * @return
     **/
    public function validateRGB(string $rgb) : string
    {
        if(preg_match('^(\#[\da-f]{3}|\#[\da-f]{6}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$', $rgb)) {
            return $rgb;
        }
        return '#ccc';
    }   // end function validateRGB()
    
}
