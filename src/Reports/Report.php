<?php

namespace App\Reports;

abstract class Report
{
    abstract public function generate();
    abstract public function export($format);
}