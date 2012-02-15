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

define('OPS_APP_HOME_DIR', dirname(__FILE__));

require_once 'assist/prepend.php';
require_once 'assist/PageProperties.class';
require_once 'assist/controllers/NavigationController.php';
require_once 'assist/lib/model/calendarConfig.php';
require_once 'assist/lib/model/calendar.php';

session_start();
if($_POST['username'] && $_POST['password'])
{
	$dbh = Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	if($obj_assignee->authenticate($dbh, $_POST['username'], $_POST['password']))
	{
		$_SESSION['logged'] = 1;
		if( !isset($auth))
		{
			$auth = new Auth($db_ops, $_POST['username']);
			$_SESSION['auth'] = $auth;
		}

	}
}

if($_SESSION['logged'] != 1)
	header("Location: index.php");
class calendarController extends NavigationController {
	function index() {
		$this->invalid_crumb = 0;
 	        return forward_to('this', 'configCalendar');
	} 

function configCalendar() { 	 
			 $team = $_POST['teamname'];
			 $this->team= $team; 
			 $this->title = 'Opensource Calendar'; 	 
	                 $this->addYUI = 1; 	 
	                 $this->addAutocomplete = 1; 	 
	                 $this->onCall = 1; 	 
	                 $this->menu = 'backup'; 	 
	                 $this->view = 'calendar/calendar'; 	 
	                 $this->pagetitle = 'Opensource Calendar'; 	 
	                 $dbh = Connection::cal_ro(); 	 
	                 $this->action = 'configCalendar'; 	 
	                 $this->next_action = 'configEdit'; 	 
	                 $this->caltype = 'oncall'; 	 
	                 $this->timeaction = 'configTime'; 	 
	                 $obj_assignee = new calendarConfig(); 	 
			 $teamid = $obj_assignee->getTeamid($dbh, $team);
			 $admingrp=$obj_assignee->getAdmingroup($dbh, $team);
			 $this->is_allowed = $this->checkUserPermission($admingrp); 	 
			 $this->svn_url = __SVN_URL."dp/oncall.txt?view=log"; 	 
	                 $month = (isset($_REQUEST['month']) && $_REQUEST['month']!='')?$_REQUEST['month']:date("m"); 	 
	                 $year = (isset($_REQUEST['year']) && $_REQUEST['year']!='')?$_REQUEST['year']:date("Y"); 	 
	                 $this->month = $month; 	 
	                 $this->year = $year; 	 
	                 $this->showTime = 1; 	 
	                 $this->next_action = 'configEdit'; 	 
	                 $obj_cal = new calender($month,$year); 	 
	                 $this->days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"); 	 
	                 $obj_cal->getDetails(); 	 
	                 $this->assignee = $obj_assignee->getConfigList($dbh,$teamid,$month,$year); 	 
	                 $this->teamlist = $obj_assignee->getTeamlist($dbh);
			 $this->timezones= $obj_assignee->getTimeDetails($dbh); 	 
	                 $this->oncall_tab = " class='selected'"; 	 
	                 $this->cal = $obj_cal; 	 
	                 if($_REQUEST['ftwiki']=='1') { 	 
	                                 $this->hideheader = 1; 	 
	                                 $this->hideothers = 1; 	 
	  	 
	                 } 	 
	         } 	 
function configEdit() { 	 
			 $team = $_GET['team'];
			 $this->title = 'Opensource Calendar'; 	 
	                 $this->addYUI = 1; 	 
	                 $this->addAutocomplete = 1; 	 
	                 $this->onCall = 1; 	 
	                 $this->menu = 'backup'; 	 
	                 $this->view = 'calendar/calendar'; 	 
	                 $this->pagetitle = 'Opensource Calendar'; 	 
	                 $dbh = Connection::cal_ro(); 	 
	                 $this->action = 'configCalendar'; 	 
	                 $this->next_action = 'configEdit'; 	 
	                 $this->caltype = 'oncall'; 	 
	                 $this->timeaction = 'configTime'; 	 
	                 $obj_assignee = new calendarConfig(); 	 
			 $teamid = $obj_assignee->getTeamid($dbh, $team);
			 $admingrp=$obj_assignee->getAdmingroup($dbh, $team);
			 $this->is_allowed = $this->checkUserPermission($admingrp); 	 
	                 $this->svn_url = __SVN_URL."dp/oncall.txt?view=log"; 	 
	                 $month = (isset($_REQUEST['month']) && $_REQUEST['month']!='')?$_REQUEST['month']:date("m"); 	 
	                 $year = (isset($_REQUEST['year']) && $_REQUEST['year']!='')?$_REQUEST['year']:date("Y"); 	 
	                 $this->month = $month; 	 
	                 $this->year = $year; 	 
	                 $this->showTime = 1; 	 
	                 $this->next_action = 'configEdit'; 	 
	                 $obj_cal = new calender($month,$year); 	 
	                 $this->days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"); 	 
	                 $obj_cal->getDetails(); 	 
	                 $this->assignee = $obj_assignee->getConfigList($dbh,$teamid,$month,$year); 	 
	                 $this->teamlist = $obj_assignee->getTeamlist($dbh);
	                 $this->title = 'Opensource Calendar'; 	 
	                 $this->addYUI = 1; 	 
	                 $this->addAutocomplete = 1; 	 
	                 $this->onCall = 1; 	 
	                 $this->menu = 'backup'; 	 
	                 $this->view = 'calendar/addedit'; 	 
	                 $dbh = Connection::cal_rw(); 	 
	                 $this->caltype = 'oncall'; 	 
	                 $this->timeaction = 'configTime'; 	 
	                 $this->pagetitle = $team." Calendar"; 	 
	                 $this->help = "Start&nbsp;Date|End&nbsp;Date|timezone(IN|US)|Oncall&nbsp;Type(PRI|SEC|PRIMARY|SECONDARY)|Username<br>"; 	 
	                 $this->help.= "Example:<br>2009-08-01|2009-08-10|US|PRI|jack<br>"; 	 
	                 $obj = new calendarConfig(); 	 
			 $admingrp=$obj->getAdmingroup($dbh, $team);
	                 $this->is_allowed = $this->checkUserPermission($admingrp); 	 
	  	 	
	                 if(!$this->is_allowed) { 	 
	                         $messages = OpsContext::get('messages'); 	 
	                         $messages->errors[] = "You don't have sufficient privilege to <b>Edit</b> this calendar! <br>"; 	 
	                         return forward_to('this', 'configCalendar'); 	 
	                 } 	
			 $this->invalid_crumb = 0;
			 if(getenv(".bycrumb") != $_REQUEST['crumb'] && $_REQUEST['btnSubmit'] != '') {
			 	$this->invalid_crumb = 1;
			 }
			 if(!$this->invalid_crumb) {
			 	if($_REQUEST['oncall']) { 	 
		                         $chk_old = $obj->checkIntermediateUpdate($dbh,$_REQUEST['lockid'],'O'); 	 
	        	                 $this->lockid = $_REQUEST['lockid']; 	 
	                	         $this->oncall = $_REQUEST['oncall']; 	 
	                        	 if(!$chk_old) { 	 
			        	         try { 	 
	                	                         $res = $obj->editConfig($dbh, $_REQUEST, $team); 	 
		                                         if($res) { 	 
		                                                 $obj->releaseCalendarLock($dbh,$_REQUEST['lockid']); 	 
	        	                                         $this->done = true; 	 
		                                                 return redirect_to('calendar', 'configCalendar'); 	 
		                                         } 	 
	        	                         } catch(Exception $e) { 	 
	                	                         $messages = OpsContext::get('messages'); 	 
		                                         $messages->errors[] = $e->getMessage(); 	 
		                             } 	 
	        	                 } else { 	 
	                	                 $messages = OpsContext::get('messages'); 	 
	                        	         $messages->errors[] = "Your update session expired/Calendar updated by other user!"; 	 
		                                 $obj->releaseCalendarLock($dbh,$_REQUEST['lockid']); 	 
		                                 return forward_to('this', 'configCalendar'); 	 
	        	                 } 	 
	                	 } else { 	 
		                     list($edit_userid,$time_diff,$lock_id) = $obj->checkCalendarEdit($dbh,'O'); 	 
		                         if(!$edit_userid) { 	 
		                                 $this->lockid = $obj->lockCalendarEdit($dbh,'O'); 	 
			                         $recs= $obj->getConfigList($dbh,$teamid); 	 
	                	                 $timezones = $obj->getZoneList($dbh);
						 $oncall = ''; 	 
	                        	         foreach($recs as $rec) { 	 
	                                	     $oncall.= $rec[from_dt]."|".$rec[to_dt]."|".$rec[timezone]."|".($rec[oncall_type]==1?"PRI":"SEC")."|".$rec[username]."\n"; 	 
		                                     if($start=='' || strtotime($start)<strtotime($rec[to_dt])) { 	 
		                                                 $start = $rec['to_dt']; 	 
	        	                             } 	 
	                	                 } 	 
						 $start = trim($start)==''?date("Y-m-d",strtotime("next Friday")):$start;
	                                	 $arr_dates = $obj->generateDates($start,7); 	 
		                                 foreach($arr_dates as $adates) { 	 
		                                         foreach($timezones as $zone){
								$oncall .= $adates[0]."|".$adates[1]."|".$zone[name]."|PRI|"."\n"; 	 
	        	                                 	$oncall .= $adates[0]."|".$adates[1]."|".$zone[name]."|SEC|"."\n"; 	  	 
	                                	 	 }
						 } 	 
		                                 $this->oncall = $oncall; 	 
		                         } else { 	 
	        	                         $this->edituser = $edit_userid; 	 
	                	                 $this->lockid = $lock_id; 	 
	                        	         $this->usage = $this->remainingDuration($time_diff); 	 
		                                 $this->duration = $this->remainingDuration($time_diff,1); 	 
		                                 $this->calendar_type = "this Calendar."; 	 
	        	                 } 	 
	                	 } 	 
			} else {
				error("INVALID Crumb");
			}
		        $this->oncall_tab = " class='selected'"; 	 
	         }

 function configTime() { 	 
			 $this->title = 'Calendar Time'; 	 
	                 $this->addYUI = 1; 	 
	                 $this->menu = 'backup'; 	 
	                 $this->view = 'calendar/addedittime'; 	 
	                 $this->addAutocomplete = 1; 	 
	                 $dbh = Connection::cal_ro(); 	 
	                 $obj_assignee = new calendarConfig(); 	 
			 $admingrp=$obj_assignee->getAdmingroup($dbh, $team);
	                 $this->is_allowed = $this->checkUserPermission($admingrp); 	 
	                 $time = $obj_assignee->getTimezoneDetail($dbh,Req::get('aid')); 	 
	                 $this->pagetitle = 'Session Timing'; 	 
	                 $this->hideheader = 1; 	 
	                 $this->time = $time; 	 
	                 $this->action = 'updateTime'; 	 
	         } 	 
function updateTime() { 	 
			 $team = $_POST['teamname'];
	                 $args = $_REQUEST; 	 
	                 $this->menu = 'backup'; 	 
	                 $this->view = 'calendar/addedittime'; 	 
	                 $obj_assignee = new calendarConfig(); 	 

			 if($args[btnSubmit]) {
			 	$this->invalid_crumb = 0;
				if(getenv(".bycrumb") != $_REQUEST['crumb']) {
					$this->invalid_crumb = 1;
				}
				if(!$this->invalid_crumb) {
		                	$dbh = Connection::cal_rw(); 	 
			                try { 	 
	        		             $res = $obj_assignee->updateTimeConfig($args,$dbh); 	 
	                		} catch(Exception $e) { 	 
	                        	     $messages = OpsContext::get('messages'); 	 
		                             $messages->errors[] = $e->getMessage(); 	 
		                             return forward_to('this', 'configTime'); 	 
	        	          	} 	 
	 		            	if($res) { 	 
	                        		 echo "<script language='javascript'>parent.window.location=parent.window.location</script>"; 	 
			                } else { 	 
		         	                 return forward_to('this', 'configTime'); 	 
	        	           	} 	 
			 	} else {
					error("INVALID Crumb");
					return forward_to('this', 'configTime');
				}
			 } else {
			   return forward_to('this', 'configTime');
			 }
}	         
	
	function remainingDuration($diff,$used='0') {
		$allow_time = __TIMEOUT;
		$rem_time = $used?($allow_time - $diff):$diff;
		$mins = floor($rem_time/60);
		$secs = ($rem_time%60);
		return "&nbsp;$mins mins $secs seconds&nbsp;";	
	}
	
	function checkUserPermission($admingrp) {
		$auth = $_SESSION['auth'];
		$dbh = Connection::cal_ro();
		$obj = new calendarConfig();
		$TMG= $obj->isMember($auth->username, $dbh, $admingrp);
		if(!$TMG){
			return 0;
		}
		return 1;
	}
	
	function showInPST($gmt_date) {
		$date_us = strtotime($gmt_date) - (7*60*60);
        	$date_us = date("Y-m-d H:i:s",$date_us);
		return $date_us;
	}


}

$controller_name = preg_replace('/\.php$/', '', basename($_SERVER['SCRIPT_NAME']));
$action_name = Req::get('action');

OpsDispatcher::execute($controller_name, $action_name);
?>
