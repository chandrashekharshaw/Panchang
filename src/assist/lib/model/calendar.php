<?php
//+---------------------------------------------------------------------------------------------------------------------------------+
//																    /
// Copyright (c) 2012 Yahoo! Inc. All rights reserved. 										    /
// Licensed under the Apache License, Version 2.0 (the "License"); you may not use this 				            /
// file except in compliance with the License. You may obtain a copy of the License at 						    /
//																    /
//		http://www.apache.org/licenses/LICENSE-2.0 									    /
//																    /
// Unless required by applicable law or agreed to in writing, software distributed under 					    /
// the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF    					    /
// ANY KIND, either express or implied. See the License for the specific language governing 					    /
// permissions and limitations under the License. See accompanying LICENSE file.						    /
// 																    /
// $Author:shawcs@yahoo-inc.com  $Date: 30-Jan-2012										    /
//																    /
//+---------------------------------------------------------------------------------------------------------------------------------+


class calender { 
	public $days;
	public $startday;
	public $caption;
	private $month;
	private $year;
	public $prev_year;
	public $prev_month;
	public $next_year;
	public $next_month;
	public $curr_day;
	public $highlight;
	public $month_year;
	public $wdays;
	public function __construct($month,$year) {
		$this->month = $month;
		$this->year = $year;
		$this->month_year = $year."-".$month;
		$this->wdays = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	}
	public function getDetails() {
		$this->getDays();
		$this->getDayOfWeek();
		$this->getCaption();
		$this->getNextMonthDetails();
		$this->getPrevMonthDetails();
		if(date("m") == $this->month && date("Y")== $this->year) {
			$this->highlight = true;
		}
		$this->curr_day = date("j");
	}
	private function getCaption() {
		$this->caption = date("F",$this->getFirstDate())."-".date("Y",$this->getFirstDate());	
	}
	private function getDayOfWeek() {
		$this->startday = date("w",$this->getFirstDate());
	}
	private function getFirstDate() {
		return strtotime($this->year."-".$this->month."-1");
	}
	private function getDays() {
		$this->days = date("t",$this->getFirstDate());
	}
	private function getNextMonthDetails() {
		$ts = mktime(0,0,0,($this->month+1),1,$this->year);
		$this->next_month = date("m",$ts);
		$this->next_year = date("Y",$ts);
	}
	private function getPrevMonthDetails() {
		$ts = mktime(0,0,0,($this->month-1),1,$this->year);
		$this->prev_month = date("m",$ts);
		$this->prev_year = date("Y",$ts);
	}

}
?>
