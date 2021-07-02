<?php

declare(strict_types=1);

namespace webbird\Calendar\Views;

use \Carbon\Carbon as Carbon;
use \Carbon\CarbonPeriod as CarbonPeriod;

class BookingsMonth extends \webbird\Calendar\View
{
    use \webbird\common\PropertyGeneratorTrait;
    use \webbird\Calendar\CalendarDataValidateTrait;
    use \webbird\Calendar\CommonUtilsTrait;

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
        $this->optional($optional);
        $this->validateYear();
        $this->validateMonth();

        $e = $this->getEngine(__DIR__);

        $dt = Carbon::createMidnightDate(intval($this->year), intval($this->month), 1);

        $period = CarbonPeriod::create(
            $dt->copy()->startOfMonth(),
            $dt->copy()->endOfMonth()
        );

        $data = array(
            'daynames'  => $this->getDayNames($dt),
            'c'         => $c,
            'dt'        => $dt,
            'period'    => $period,
            'today'     => \Carbon\Carbon::today(),
            'current'   => Carbon::createMidnightDate(intval($this->year), intval($this->month), intval($this->day)),
        );

        echo $e->render('bookingsmonth.'.$c->getLayout(), $data);
    }   // end function render()
    
}