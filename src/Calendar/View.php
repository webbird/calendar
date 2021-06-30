<?php

declare(strict_types=1);

namespace webbird\Calendar;

class View
{
    const VERSION = '0.1';

    protected ?\League\Plates\Engine $te;

    /**
     *
     * @access public
     * @return
     **/
    public function getEngine(?string $templatepath = null)
    {
        if(empty($this->te)) {
            $this->te = new \League\Plates\Engine($templatepath);
        }
        return $this->te;
    }   // end function getEngine()

    /**
     *
     * @access public
     * @return
     **/
    public function render(\webbird\Calendar\Calendar $c, mixed ...$optional)
    {

    }   // end function render()

}