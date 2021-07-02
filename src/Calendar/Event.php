<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class Event
{
    use \webbird\common\PropertyGeneratorTrait;
    use CommonUtilsTrait;
    use CalendarDataValidateTrait;

    /** @var string $title - event title */
    protected string $title;
    /** @var \DateTime $startdate - event start date and time */
    protected \DateTime $startdate;
    /** @var \DateTime $enddate - event end date and time */
    protected \DateTime $enddate;
    /** @var Season $season - for events that belong to a season */
    protected Season $season;

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
        $this->getParameters($optional);
    }   // end function __construct()

    /**
     *
     * @access public
     * @return
     **/
    public function isFirstDay(\DateTime $date) : bool
    {
        return $date == $this->startdate;
    }   // end function isFirstDay()

    /**
     *
     * @access public
     * @return
     **/
    public function isLastDay(\DateTime $date) : bool
    {
        return $date == $this->enddate;
    }   // end function isLastDay()
    
}