<?php

declare(strict_types=1);

namespace webbird\Calendar\Views;

use \Carbon\Carbon as Carbon;
use \Carbon\CarbonPeriod as CarbonPeriod;

class Daysheet extends \webbird\Calendar\View
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

        $dt = Carbon::createMidnightDate(intval($this->year), intval($this->month), intval($this->day));

        // handle next/prev
        if(isset($_REQUEST['np']) && in_array($_REQUEST['np'], array('next','previous'))) {
            if($_REQUEST['np'] == 'next') {
                $dt->addDays(1);
            } else {
                $dt->addDays(-1);
            }
        }

        $data = array(
            'c'         => $c,
            'dt'        => $dt,
            'today'     => \Carbon\Carbon::today(),
            'current'   => $dt,
        );

        echo $e->render('dayview.'.$c->getLayout(), $data);
    }   // end function render()
    
}