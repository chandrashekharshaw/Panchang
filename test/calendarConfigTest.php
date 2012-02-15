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

include '../www/pear/lib/model/calendarConfig.php';
require_once '../www/pear/common/Helpers.php';
require_once '../www/pear/common/Logger.php';
require_once '../www/pear/common/Conf.php';
require_once '../www/pear/common/MVC.php';
require_once '../www/pear/common/DbRegistry.php';


class CalendarConfigTest extends PHPUnit_Framework_TestCase{

	function Setup(){
		$this->dbh = MyDB::connect('mysql:host=127.0.0.1;dbname=;port=', 'username', 'password');
		$this->cal = new calendarConfig();
	}
	
	function testauthenticate(){
		$this-> assertTrue($this->cal->authenticate($this->dbh, 'u1', 'p1'));
	}
	
	function testgetTeamlist(){
		$list = $this->cal->getTeamlist($this->dbh);
		$this-> assertContains('t1', $list[3]['team_name']);
	}
	
	function testgetTeamid(){
		$this->assertEquals(4,$this->cal->getTeamid($this->dbh, 't1'));
	}
	
	function testgetTeamDetails(){
		$det = $this->cal->getTeamDetails($this->dbh, 't1');
		$this->assertEquals(4, $det['team_id']);
		$this->assertEquals('d1', $det['description']);
		$this->assertEquals('u1', $det['user_ilist']);
		$this->assertEquals('ad1', $det['admin_ilist']);
	}
	
	function testgetTidDetails(){
		$det = $this->cal->getTidDetails($this->dbh, 4);
		$this->assertEquals('t1', $det['team_name']);
		$this->assertEquals('d1', $det['description']);
		$this->assertEquals('u1', $det['user_ilist']);
		$this->assertEquals('ad1', $det['admin_ilist']);
	}
	
	function testgetUserList(){
		$list = $this->cal->getUserList($this->dbh);
		$this->assertContains('u1', $list[2]['username']);
	}
	
	function testgetUserDetails(){
		$det = $this->cal->getUserDetails($this->dbh, 'u1');
		$this->assertEquals(1014, $det['user_id']);
		$this->assertEquals('u1', $det['username']);
		$this->assertEquals('n1', $det['name']);
		$this->assertEquals('u1@yahoo-inc.com', $det['email']);
	}
	
	function testgetUidDetails(){
		$det = $this->cal->getUidDetails($this->dbh, 1014);
		$this->assertEquals('u1', $det['username']);
		$this->assertEquals('n1', $det['name']);
		$this->assertEquals(hash('md4','p1'), $det['password']);
	}
	
	function testgetGroupList(){
		$list=$this->cal->getGroupList($this->dbh);
		$this->assertContains('group1', $list[0]['name']);
	}
	function testgetGroupDetails(){
		$det = $this->cal->getGroupDetails($this->dbh, 'group1');
		$this->assertEquals(6, $det['gu_id']);
		$this->assertEquals('group1', $det['name']);
		$this->assertEquals('desc1', $det['description']);
	}
	
	function testgetGidDetails(){
		$det = $this->cal->getGidDetails($this->dbh, 6);
		$this->assertEquals('group1', $det['name']);
		$this->assertEquals('desc1', $det['description']);
	}
	
	function getAdmingroup(){
		$admingrp = $this->cal->getAdmingroup($this->dbh, 't1');
		$this->assertEquals('ad1', $admingrp);
	}
	function testisMember(){
		$this->assertEquals(1001, $this->cal->isMember('user', $this->dbh, 'admin' ));
	}
	
	function testgetMemberList(){
		$list = $this->cal->getMemberList($this->dbh, 30267);
		$this->assertEquals('shawcs', $list[0]['username']);
	}
	function testgetZoneList(){
		$list=$this->cal->getZoneList($this->dbh, 'timezone');
		$this->assertEquals('US',$list[0]['name'] );
	}
	
	function testgetTimeDetails(){
		$det=$this->cal->getTimeDetails($this->dbh, 'timezone');
		$this->assertEquals('US', $det[2]['timezone']);
		$this->assertEquals('6:00', $det[2]['start_time']);
		$this->assertEquals('13:59', $det[2]['end_time']);
	}
	
}


?>
