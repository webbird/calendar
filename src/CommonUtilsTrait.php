<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait CommonUtilsTrait
{
    /**
     * create a guid; used by the backend, but can also be used by modules
     *
     * @access public
     * @return string
     **/
    public function createGUID() : string
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', random_int(0, 65535), random_int(0, 65535), random_int(0, 65535), random_int(16384, 20479), random_int(32768, 49151), random_int(0, 65535), random_int(0, 65535), random_int(0, 65535));
    }   // end function createGUID()

    /**
     *
     * @access public
     * @return
     **/
    public function getDayNames(\Carbon\Carbon $dt) : array
    {
        $arr = array();
        for ($i = 0; $i < \Carbon\CarbonInterval::getDaysPerWeek(); $i++) {
            $arr[] = $dt->startOfWeek()->addDays($i)->minDayName;
        }
        return $arr;
    }   // end function getDayNames()

    /**
     *
     * @access public
     * @return
     **/
    public function isBetween(\DateTime $date1, \DateTime $date2, \DateTime $date3) : bool
    {
echo "FILE [",__FILE__,"] FUNC [",__FUNCTION__,"] LINE [",__LINE__,"]<br /><textarea style=\"width:100%;height:200px;color:#000;background-color:#fff;\">";
print_r(array($date1,$date2,$date3));
echo "</textarea><br />";
        $result = $date1 >= $date2 && $date1 <= $date3;
echo "RESULT [$result]<br />";
        return $result;
    }   // end function isBetween()
    
    /**
     *
     * @access public
     * @return
     **/
    public function days()
    {
        return $this->startdate->diffInDays($this->enddate);
    }   // end function days()

    /**
     *
     * @access public
     * @return
     **/
    public function hours()
    {
        return $this->startdate->diffInHours($this->enddate);
    }   // end function hours()
}
