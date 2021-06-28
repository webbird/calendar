<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;
use \Carbon\CarbonPeriod as CarbonPeriod;

class Property
{
    use PropertyGeneratorTrait;
    use CommonUtilsTrait;

    /** @var string $name - season name / title */
    protected string $name;
    /** @var array $bookings */
    protected array $bookings;
    /** @var string $overlapbase */
    protected string $overlapbase = 'day';

    /**
     * constructor
     *
     * @access public
     * @param  string  $name
     * @param  mixed $other  - any number of other properties (ex: description)
     * @return
     **/
    public function __construct(
        string $name,
        mixed ...$optional
    ) {
        $this->name = $name;
        $this->getParameters($optional);
    }   // end function __construct()

    /**
     *
     * @access public
     * @return
     **/
    public function addBooking(Booking $booking) : object
    {
        if($this->overlapbase == 'day') {
            if($this->hasBookingsForPeriod($booking->startdate, $booking->enddate)) {
                throw new OverlappingDatesException(sprintf(
                    'The given period overlaps another booking for this property (base: %s)',
                    $this->overlapbase
                ));
            }
        }
        $this->bookings[] = $booking;
        return $this;
    }   // end function addBooking()

    /**
     *
     * @access public
     * @return
     **/
    public function getBookings()
    {
    
    }   // end function getBookings()

    /**
     *
     * @access public
     * @return
     **/
    public function getBookingsForDay(\DateTime $date) : array
    {
        $dt = Carbon::createMidnightDate($date->year,$date->month,$date->day);
        $result = array();
        if(is_array($this->bookings) && !empty($this->bookings)) {
            foreach($this->bookings as $e) {
                $d1 = Carbon::createMidnightDate($e->startdate->year,$e->startdate->month,$e->startdate->day);
                $d2 = Carbon::createMidnightDate($e->enddate->year,$e->enddate->month,$e->enddate->day);
                if($dt->between($d1, $d2, true)) {
                    $result[] = $e;
                }
            }
            return $result;
        }
        return array();
    }   // end function getBookingsForDay()
    
    /**
     *
     * @access public
     * @return
     **/
    public function getBookingsForPeriod(\DateTime $startdate, \DateTime $enddate) : array
    {
        if(empty($this->bookings)) {
            return array();
        }
        $result = array();
        $period = CarbonPeriod::create($startdate, $enddate);
        foreach($this->bookings as $b) {
            if($period->overlaps($b->startdate,$b->enddate)) {
                $result[] = $b;
            }
        }
        return $result;
    }   // end function getBookingsForPeriod()

    /**
     *
     * @access public
     * @return
     **/
    public function hasBookingForDay(\DateTime $date) : bool
    {
        return count($this->getBookingsForDay($date)) > 0;
    }   // end function hasBookingForDay()
    
    /**
     *
     * @access public
     * @return
     **/
    public function hasBookingsForPeriod(\DateTime $begin, \DateTime $end) : bool
    {
        return count($this->getBookingsForPeriod($begin,$end))>0;
    }   // end function hasBookingsForPeriod()
    
    
}