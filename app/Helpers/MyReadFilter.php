<?php

namespace App\Helpers;

class MyReadFilter implements \PHPExcel_Reader_IReadFilter { 

    public function readCell($column, $row, $worksheetName = 'catCFDI_.csv') { 
        //  Read rows 1 to 7 and columns A to E only 
        if ($row >= 1) { 
            if (in_array($column,range('A'))) { 
                return true; 
            } 
        } 
        return false; 
    } 
} 