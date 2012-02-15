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

include_once("../www/pear/Auth.class");
include_once("../www/pear/DB.php");
include_once("../www/pear/PageProperties.class");


class PagePropertiesTest extends PHPUnit_Framework_TestCase {

	protected $backupGlobals = FALSE;
	protected $isolated = TRUE;
	
	function Setup(){
		$this->db_ops = DB::connect('mysql://yername:passwordy@127.0.0.1:');
		$this->auth = new Auth($db_ops, 'u1');
		$this->_db_obj = new PageProperties('',$auth);
	}	
		
	function testaddToHeader() {
		
		$res = $this->_db_obj->addToHeader("js","./js/util.js");
		$res1 = $this->_db_obj->addToHeader("css","./js/panchang.css");
		$this->assertTrue($res=='' && $res1=='');
	}
	function testprintHeader() {
		$str = $this->_db_obj->printHeader();
		$this->assertTrue(trim($str)=='');
	}
	
	function testprintSubTabs() {
		$str = $this->_db_obj->printToolbar(true,"storage_");
	        $this->assertTrue(trim($str)=='');
	}
	

}
