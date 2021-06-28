<?php

declare(strict_types=1);

namespace webbird\Calendar;

use \Carbon\Carbon as Carbon;

class Season
{
    use PropertyGeneratorTrait;
    use CommonUtilsTrait;
    use CalendarDataValidateTrait;

    /** @var string $title - season name / title */
    protected string $title;
    /** @var \DateTime $startdate - start date */
    protected \DateTime $startdate;
    /** @var \DateTime $enddate - end date */
    protected \DateTime $enddate;
    /** @var string $cssclass */
    protected string $cssclass;

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

}