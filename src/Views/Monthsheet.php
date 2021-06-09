<?php

declare(strict_types=1);

namespace webbird\Calendar\Views;

use \Carbon\Carbon as Carbon;
use \Carbon\CarbonPeriod as CarbonPeriod;

class Monthsheet extends \webbird\Calendar\View
{
    use \webbird\Calendar\PropertyGeneratorTrait;
    use \webbird\Calendar\CalendarDataValidateTrait;

    const VERSION = '0.1';

    protected \webbird\Calendar\Calendar $c;

    /**
     *
     * @access public
     * @return
     **/
    public function render(
        \webbird\Calendar\Calendar $c,
        mixed ...$optional
    ) {
        $this->c = $c;
        if(is_array($optional)) {
            foreach($optional as $key => $value) {
                $this->{$key} = $value;
            }
        }
        $this->validateYear();
        $this->validateMonth();
        $this->validateDay();

        $e = $this->getEngine(__DIR__);

        $dt = Carbon::createMidnightDate(intval($this->year), intval($this->month), 1);

        // BEWARE: If the start of the first week in month is in last month,
        // this will change the current month!
        // Example: Month is 2021-04
        // BEFORE:  startOfMonth will be 2021-04-01
        // AFTER:   startOfMonth will be 2021-03-01 !!!
        #$dt->startOfWeek(Carbon::MONDAY);

        $period = CarbonPeriod::create(
            $dt->copy()->startOfWeek(),
            $dt->copy()->endOfMonth()->endOfWeek()
        );

        $data = array(
            'daynames'  => array(),
            'c'         => $c,
            'dt'        => $dt,
            'period'    => $period,
            'today'     => \Carbon\Carbon::today(),
            'current'   => Carbon::createMidnightDate(intval($this->year), intval($this->month), intval($this->day)),
        );
        for ($i = 0; $i < \Carbon\CarbonInterval::getDaysPerWeek(); $i++) {
            $data['daynames'][] = $dt->startOfWeek()->addDays($i)->minDayName;
        }

        echo $e->render('monthview.'.$c->getLayout(), $data);
    }   // end function render()
    
}