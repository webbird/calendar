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
        $this->optional($optional);
        $this->validateYear();
        $this->validateMonth();
        $this->validateDay();

        $e = $this->getEngine(__DIR__);
        $dt = Carbon::createMidnightDate(intval($this->year), intval($this->month), 1);

        $period = CarbonPeriod::create(
            $dt->copy()->startOfWeek(),
            $dt->copy()->endOfMonth()->endOfWeek()
        );

        // handle next/prev
        $np = filter_input(type: INPUT_GET, var_name: 'np', filter:  FILTER_SANITIZE_STRING );
        switch($np) {
            case 'next':
            case 'n':
                $dt->addMonths(1);
                break;
            case 'previous':
            case 'p':
            case 'prev':
                $dt->addMonths(-1);
                break;
            default:
                break;
        }

        $data = array(
            'daynames'  => $this->getDayNames(),
            'c'         => $c,
            'dt'        => $dt,
            'period'    => $period,
            'today'     => \Carbon\Carbon::today(),
            'current'   => Carbon::createMidnightDate(intval($this->year), intval($this->month), intval($this->day)),
        );

        echo $e->render('monthview.'.$c->getLayout(), $data);
    }   // end function render()
    
}