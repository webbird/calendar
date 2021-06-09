<?php

declare(strict_types=1);

namespace webbird\Calendar;

trait ArrayUtilsTrait
{
    /**
     * sort an array
     *
     * @access public
     * @param  array   $arr            - array to sort
     * @param  mixed   $index          - key to sort by
     * @param  string  $order          - 'asc' (default) || 'desc'
     * @param  boolean $natsort        - default: false
     * @param  boolean $case_sensitive - sort case sensitive; default: false
     *
     **/
    public function sortby(array $arr, mixed $index, string $order='asc', bool $natsort=false, bool $case_sensitive=false ) : mixed
    {
        if (count($arr)) {
            $temp = array();
            foreach (array_keys($arr) as $key) {
                if(is_string($key) && isset($index) && isset($arr[$key][$index])) {
                    $temp[$key] = $arr[$key][$index];
                }
            }
            if (!$natsort) {
                ($order=='asc') ? asort($temp) : arsort($temp);
            } else {
                ($case_sensitive) ? natsort($temp) : natcasesort($temp);
                if ($order != 'asc') {
                    $temp = array_reverse($temp, true);
                }
            }
            $sorted = array();
            foreach (array_keys($temp) as $key) {
                (is_numeric($key)) ? $sorted[]=$arr[$key] : $sorted[$key]=$arr[$key];
            }
            return $sorted;
        }
        return $arr;
    }   // end function sortby()
}
