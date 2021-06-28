<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class BookingsCalendar extends Calendar
{
    use \webbird\Calendar\ArrayUtilsTrait;

    const VERSION = '0.1';

    /** @var bool $legend - wether to show a legend (default: false) */
    protected bool $legend      = false;
    /** @var array $seasons */
    protected array $seasons    = array();
    /** @var array $properties */
    protected array $properties = array();
    /** @var array $status */
    protected array $status     = array();

    /**
     *
     * @access public
     * @return
     **/
    public function addProperty(\webbird\Calendar\Property $property) : bool
    {
        $this->properties[] = $property;
        return true;
    }   // end function addProperty()

    /**
     *
     * @access public
     * @return
     **/
    public function addSeason(\webbird\Calendar\Season $season) : bool
    {
        $this->seasons[] = $season;
        return true;
    }   // end function addSeason()

    /**
     *
     * @access public
     * @return
     **/
    public function addSeasons(array $seasons) : bool
    {
        foreach($seasons as $s) {
            if(!$s instanceof Season) {
                throw new \UnexpectedValueException(sprintf(
                    'Instance of %s\Season expected, got type %s instead',
                    __NAMESPACE__, gettype($s)
                ));
            }
            $this->addSeason($s);
        }
        return true;
    }   // end function addSeasons()

    /**
     *
     * @access public
     * @return
     **/
    public function addStatus(\webbird\Calendar\BookingStatus $status)
    {
        $this->status[] = $status;
        return true;
    }   // end function addStatus()
    
    /**
     *
     * @access public
     * @return
     **/
    public function getProperties(?bool $sorted=false) : array
    {
        if(empty($this->properties)) {
            return array();
        }
        if($sorted) {
            $p = $this->properties;
            usort($p, function($a, $b) {
                return $a->getName() <=> $b->getName();
            });
            return $p;
        }
        return $this->properties;
    }   // end function getProperties()

    /**
     *
     * @access public
     * @return
     **/
    public function getSeasonForDate(\DateTime $date) : mixed
    {
        $seasons = $this->getSeasons();
        $dt = Carbon::createMidnightDate($date->year,$date->month,$date->day);
        if(is_array($seasons) && !empty($seasons)) {
            foreach($seasons as $s) {
                $d1 = Carbon::createMidnightDate($s->startdate->year,$s->startdate->month,$s->startdate->day);
                $d2 = Carbon::createMidnightDate($s->enddate->year,$s->enddate->month,$s->enddate->day);
                if($dt->between($d1, $d2, true)) {
                    return $s;
                }
            }
        } else {
            $default = new Season(name: 'default', cssclass: 'default');
            $this->addSeason($default);
            return $default;
        }
    }   // end function getSeasonForDate()

    /**
     *
     * @access public
     * @return
     **/
    public function getSeasons() : array
    {
        if(empty($this->seasons)) {
            return array();
        }
        return $this->seasons;
    }   // end function getSeasons()
    
    /**
     *
     * @access public
     * @return
     **/
    public function getStatus() : array
    {
        if(empty($this->status)) {
            return array();
        }
        return $this->status;
    }   // end function getStatus()

    /**
     *
     * @access public
     * @return
     **/
    public function legendEnabled() : bool
    {
        return $this->legend;
    }   // end function legendEnabled()

    /**
     *
     * @access public
     * @return
     **/
    public function withLegend(bool $switch) : object
    {
        $this->legend = $switch;
        return $this;
    }   // end function withLegend()
    
}