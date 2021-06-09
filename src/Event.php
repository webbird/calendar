<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class Event
{
    use PropertyGeneratorTrait;

    /** @var string $id - unique id (GUID) */
    protected string $id;
    /** @var string $title - event title */
    protected string $title;
    /** @var \DateTime $startdate - event start date and time */
    protected \DateTime $startdate;
    /** @var \DateTime $enddate - event end date and time */
    protected \DateTime $enddate;

    /**
     * constructor
     *
     * @access public
     * @param  string  $title
     * @param  int|string|\DateTime $startdate
     * @param  int|string|\DateTime $enddate
     * @param  mixed $other  - any number of other properties (ex: description)
     * @return
     **/
    public function __construct(
        string $title,
        int|string|\DateTime $startdate,
        int|string|\DateTime $enddate,
        mixed ...$optional
    ) {
        $this->title = $title;
        $this->startdate = new Carbon($this->validateTimestamp($startdate));
        $this->enddate = new Carbon($this->validateTimestamp($enddate));
        if(is_array($optional)) {
            foreach($optional as $key => $value) {
                $this->{$key} = $value;
            }
        }
        $this->id = $this->createGUID();
    }   // end function __construct()

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
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }   // end function createGUID()
    
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
}