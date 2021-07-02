<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class Calendar
{
    use \webbird\common\PropertyGeneratorTrait;
    use \webbird\common\ArrayUtilsTrait;

    const VERSION = '0.1';

    /** @var string $orig_timezone - saves the original timezone before changing it */
    protected string $orig_timezone;
    /** @var string $timezone - saves the currently used timezone */
    protected string $timezone;
    /** @var array $events */
    protected array $events = array();
    /** @var string $uribase - base for generated URLs */
    protected string $uribase = '';
    /** @var string $type - output as monthview|weekview|... (default: monthview) */
    protected string $type = 'monthview';
    /** @var string $layout - layout (default: bootstrap) */
    protected string $layout = 'bootstrap';
    /** @var string $theme - some layouts have several (color) themes */
    protected string $theme = 'orange-3d';
    /** @var string $title - some layouts allow to have a global title / heading */
    protected string $title = '';
    /** @var string $subtitle - some layouts allow to have a global title / heading */
    protected string $subtitle = '';

    /**
     * Constructor
     *
     * Saves the original timezone and sets $this->timezone to it's value
     *
     * @access public
     * @return object
     **/
    public function __construct()
    {
        $this->orig_timezone = ini_get('date.timezone');
        $this->timezone = $this->orig_timezone;
    }   // end function __construct()

    /**
     *
     * @access public
     * @return
     **/
    public function addEvent(Event $event) : bool
    {
        $this->events[] = $event;
        return true;
    }   // end function addEvent()

    /**
     * retrieves all categories from all events registered so far and returns
     * them as an array of category names
     *
     * @access public
     * @return array
     **/
    public function getEventCategories() : array
    {
        $result = array();
        if(!empty($this->events)) {
            foreach($this->events as $e) {
                if($e->category) {
                    $result[$e->category] = 1;
                }
            }
        }
        return array_keys($result);
    }   // end function getEventCategories()
    
    /**
     * returns the number of events that are registered for the given DateTime
     *
     * @access public
     * @return int
     **/
    public function getEventCount(\DateTime $date) : int
    {
        return count($this->getEventsForDay($date));
    }   # end function getEventCount

    /**
     * extracts all events that are registerd for the given DateTime and returns
     * them as an array of \webbird\Calendar\Event objects
     *
     * @access public
     * @return array
     **/
    public function getEventsForDay(\DateTime $date) : array
    {
        $result = array();
        $dt = Carbon::createMidnightDate($date->year,$date->month,$date->day);
        if(is_array($this->events) && !empty($this->events)) {
            foreach($this->events as $e) {
                $d1 = Carbon::createMidnightDate($e->startdate->year,$e->startdate->month,$e->startdate->day);
                $d2 = Carbon::createMidnightDate($e->enddate->year,$e->enddate->month,$e->enddate->day);
                if($dt->between($d1, $d2, true)) {
                    $result[] = $e;
                }
            }
# !!!!! TODO: Sortierung klappt noch nicht zuverlaessig (dayview) !!!!!!!!!!!!!!
            // sort events by time
            usort(
                $result,
                function ($a, $b) {
                    return $a->startdate->greaterThan($b->startdate) ? 0 : 1;
                }
            );
        }
        return $result;
    }   // end function getEventsForDate()

    /**
     *
     * @access public
     * @return
     **/
    public function hasEvent(\DateTime $date) : bool
    {
        return count($this->getEventsForDay($date))>0;
    }   // end function hasEvent()

    /**
     *
     * @access public
     * @return
     **/
    public function getTimezone() : string
    {
        return $this->timezone;
    }   // end function getTimezone()

    /**
     * reset timezone to $this->orig_timezone
     *
     * @access public
     * @return $this
     **/
    public function resetTimezone() : object
    {
        $this->timezone = $this->orig_timezone;
        return $this;
    }   // end function resetTimezone()
    
    /**
     * set timezone to be used for your calendar
     *
     * @access public
     * @param  string  $timezone
     * @return $this
     * @throws \InvalidArgumentException
     **/
    public function withTimezone(string $tz) : object
    {
        if (!in_array($tz, \DateTimeZone::listIdentifiers())) {
            throw new \InvalidArgumentException(
                sprintf('Invalid timezone: %s', $tz)
            );
        } else {
            $this->timezone = $tz;
        }
        return $this; // chainable
    }   // end function withTimezone()

    /**
     *
     * @access public
     * @return
     **/
    public function renderAs(string $type) : object
    {
        $this->type = $type;
        return $this;
    }   // end function renderAs()

    /**
     *
     * @access public
     * @return
     **/
    public function getRenderType() : string
    {
        return $this->type;
    }   // end function getRenderType()
    
    /**
     *
     * @access public
     * @return
     **/
    public function getTheme() : string
    {
        return $this->theme;
    }   // end function getTheme()

    /**
     *
     * @access public
     * @return
     **/
    public function withTheme(string $theme) : object
    {
        $this->theme = $theme;
        return $this;
    }   // end function withTheme()

    public function getDayNames(\Carbon\Carbon $dt) : array
    {
        $daynames = array();
        for ($i = 0; $i < \Carbon\CarbonInterval::getDaysPerWeek(); $i++) {
            $daynames[] = $dt->startOfWeek()->addDays($i)->minDayName;
        }
        return $daynames;
    }

    /**
     *
     * @access public
     * @return
     **/
    public function getLayout() : string
    {
        return $this->layout;
    }   // end function getLayout()
    
    /**
     *
     * @access public
     * @return
     **/
    public function withLayout(string $layout) : object
    {
        $this->layout = $layout;
        return $this;
    }   // end function withLayout()

    /**
     * set locale for date/time formatting
     *
     * @access public
     * @param  string  name of the locale
     * @return object
     **/
    public function withLocale(string $lc) : object
    {
        $result = setlocale(LC_TIME, $lc);
        if (false===$result) {
            throw new \InvalidArgumentException(
                sprintf('Invalid locale: %s', $lc)
            );
        }
        Carbon::setLocale($lc);
        return $this; // chainable
    }   // end function withLocale()

    /**
     *
     * @access public
     * @param  string  $title - set subtitle
     * @return object
     **/
    public function withSubtitle(string $title) : object
    {
        $this->subtitle = $title;
        return $this;
    }   // end function withSubtitle()

    /**
     *
     * @access public
     * @param  string  $title - set title
     * @return object
     **/
    public function withTitle(string $title) : object
    {
        $this->title = $title;
        return $this;
    }   // end function withTitle()

    /**
     *
     * @access public
     * @param  string  $uri - base uri to use for links
     * @return object
     **/
    public function withURIBase(string $uri) : object
    {
        $this->uribase = $uri;
        return $this;
    }   // end function withURIBase()
    
    /**
     *
     * @access public
     * @param  mixed  $optional - any optional data to be passed to renderer
     * @return void
     **/
    public function output(mixed ...$optional) : void
    {
        $classname = '\webbird\Calendar\Views\\'.ucfirst($this->type);
        if(class_exists($classname,true)) {
            $renderer = new $classname();
            $renderer->render($this,...$optional);
        }
    }   // end function output()
    
}
