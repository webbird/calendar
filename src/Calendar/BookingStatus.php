<?php

declare(strict_types=1);

namespace webbird\Calendar;

class BookingStatus
{
    use \webbird\common\PropertyGeneratorTrait;
    use CommonUtilsTrait;
    use CalendarDataValidateTrait;

    /** @var string $title - season name / title */
    protected string $title;
    /** @var string $cssclass */
    protected string $cssclass;
    /** @var string $color */
    protected string $color;

    /**
     * constructor
     *
     * @access public
     * @param  string  $title
     * @param  mixed $other  - any number of other properties (ex: description)
     * @return
     **/
    public function __construct(
        string $title,
        mixed ...$optional
    ) {
        $this->title = $title;
        $this->getParameters($optional);
    }   // end function __construct()

}