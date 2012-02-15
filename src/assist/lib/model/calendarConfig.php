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


class calendarConfig {
    private $time_diff;
	public function __construct() {
		$this->time_diff = __TIMEOUT;
	}

	
	public function authenticate($dbh, $user, $pass)
	{
		try
		{
			$query = "SELECT password from opencal.user 
					WHERE username=?";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(1,$user);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!is_array($row) || sizeof($row) <= 0)
				return false;

			$res = $row['password'];
			if(strcmp($res, hash('md4', $pass)) == 0)
			{
				return true;
			}	 

			return false;
		}
		catch(PDOException $e)
		{
			return "error";
		}
		
	}
	
	/* Methods for Team management */
	public function getTeamlist($dbh) 
	{
		try
		{
			$query = "
				SELECT team_name 
				FROM
				opencal.team";
			$stmt = $dbh->prepare($query);
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($row) && sizeof($row)>0)
				return $row;
			else
				return false;
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	public function getTeamid($dbh, $team){
		try
		{
			$query="
				SELECT team_id
				FROM
				opencal.team
				WHERE team_name=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_array($row) && sizeof($row)>0)
				return $row['team_id'];
			else
				return false;
		}
		catch(PDOException $e)
		{
			
		}
		
		}	

	function getTeamDetails($dbh,$team){
		try
		{
			$query = "SELECT team_id,team_name,description,user_ilist,admin_ilist
				  FROM opencal.team
				  WHERE team_name=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}

	function getTidDetails($dbh,$team_id){
		try
		{
			$query = "SELECT team_name,description,user_ilist,admin_ilist
				  FROM opencal.team
				  WHERE team_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team_id);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}


	function addTeamDetails($dbh,$team_name,$desc,$user_ilist,$admin_ilist){
		try
		{
			$query = "INSERT INTO opencal.team(team_name,description,user_ilist,admin_ilist)
				  VALUES(?,?,?,?)";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team_name);
			$stmt->bindParam(2,$desc);
			$stmt->bindParam(3,$user_ilist);
			$stmt->bindParam(4,$admin_ilist);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		

		}
	function editTeamDetails($dbh,$team_id,$team_name,$desc,$user_ilist,$admin_ilist){
		try
		{
			$query = "UPDATE opencal.team set team_name=?,description=?,user_ilist=?,admin_ilist=?
				  WHERE team_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team_name);
			$stmt->bindParam(2,$desc);
			$stmt->bindParam(3,$user_ilist);
			$stmt->bindParam(4,$admin_ilist);
			$stmt->bindParam(5,$team_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		

	}

	function deleteTeam($dbh,$team_id){
		try
		{
			$query = "DELETE FROM opencal.team
				  WHERE team_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$team_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		
	}

	/* Methods for User Management */
	
	function getUserList($dbh){
		try
		{
			$query = "SELECT username FROM opencal.user";
		        $stmt=$dbh->prepare($query);
		        $stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}
		
	function getUserDetails($dbh,$username){
		try
		{
			$query = "SELECT user_id,username,name,email
				  FROM opencal.user
				  WHERE username=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$username);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}

	function getUidDetails($dbh,$user_id){
		try
		{
			$query = "SELECT username, name,email,password
				  FROM opencal.user
				  WHERE user_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$user_id);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}


	function addUserDetails($dbh,$username,$name,$email,$pass){
		try
		{
			$query = "INSERT INTO opencal.user(username,name,email,password)
				  VALUES(?,?,?,?)";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$username);
			$stmt->bindParam(2,$name);
			$stmt->bindParam(3,$email);
			$stmt->bindParam(4,hash('md4', $pass));
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		
		}

	function editUserDetails($dbh,$user_id,$username,$name,$email,$password){
		try
		{
			$query = "UPDATE opencal.user set username=?,name=?,email=?,password=?
				  WHERE user_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$username);
			$stmt->bindParam(2,$name);
			$stmt->bindParam(3,$email);
			$stmt->bindParam(4,$password);
			$stmt->bindParam(5,$user_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		
	}

	function deleteUser($dbh,$user_id){
		try
		{
			$query = "DELETE FROM opencal.user
				  WHERE user_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$user_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	/* Methods for Group Management */
	
	function getGroupList($dbh){
		try
		{
			$query = "SELECT name FROM opencal.groupUser";
		        $stmt=$dbh->prepare($query);
		        $stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}
		
	function getGroupDetails($dbh,$group){
		try
		{
			$query = "SELECT gu_id,name,description
				  FROM opencal.groupUser
				  WHERE name=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$group);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}
	
	function getGidDetails($dbh,$gu_id){
		try
		{
			$query = "SELECT name,description
				  FROM opencal.groupUser
				  WHERE gu_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$gu_id);
			$stmt->execute();
			$results=$stmt->fetch(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
		}


	function addGroupDetails($dbh,$name,$desc){
		try
		{
			$query = "INSERT INTO opencal.groupUser(name,description)
				  VALUES(?,?)";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$name);
			$stmt->bindParam(2,$desc);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}


		}
	function editGroupDetails($dbh,$gu_id,$name,$desc){
		try
		{
			$query = "UPDATE opencal.groupUser set name=?,description=?
				  WHERE gu_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$name);
			$stmt->bindParam(2,$desc);
			$stmt->bindParam(3,$gu_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		

	}

	function deleteGroup($dbh,$gu_id){
		try
		{
			$query = "DELETE FROM opencal.groupUser
				  WHERE gu_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$gu_id);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			
		}
		
	}

	function getAdmingroup($dbh, $team) {
		try
		{
			$query = "
				SELECT admin_ilist
				FROM
				opencal.team 
				WHERE team_name=?";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(1,$team);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_array($row) && sizeof($row)>0)
				return $row['admin_ilist'];
			else
				return false;
		}
		catch(PDOException $e)
		{
			
		}
		
		}

	/* Methods to manage Group Member */
	
	function isMember($user,$dbh,$grp) {
		try
		{
			$query = "
				SELECT
					guu.user_id 
				FROM 
				opencal.user as u
				LEFT JOIN opencal.groupUser_user AS guu on (u.user_id=guu.user_id)
				LEFT JOIN  opencal.groupUser AS gu ON (guu.gu_id=gu.gu_id) 
				WHERE gu.name=? AND u.username=?";
			$stmt = $dbh->prepare($query);
			$stmt->bindParam(1,$grp);
			$stmt->bindParam(2,$user);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(is_array($row) && sizeof($row)>0)
				return $row[user_id];
			else 
				return false;
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	function getMemberList($dbh,$guid){
		try
		{
			$query = "SELECT u.username,u.user_id
				  FROM opencal.user as u
				  LEFT JOIN opencal.groupUser_user as guu on (u.user_id=guu.user_id)
				  WHERE gu_id=?";
			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$guid);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
	}

	function getNonMemberList($dbh,$guid){
		try
		{
			$query = "SELECT u.username, u.user_id
				  FROM opencal.user as u
				  WHERE user_id NOT IN(SELECT user_id FROM opencal.groupUser_user WHERE gu_id=?)";

			$stmt=$dbh->prepare($query);
			$stmt->bindParam(1,$guid);
			$stmt->execute();
			$results=$stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;
		}
		catch(PDOException $e)
		{
			
		}
		
	}

	function addMember($dbh, $str){
		try
		{
			$str = substr($str, 0, -1);
			$query = "INSERT INTO opencal.groupUser_user(gu_id, user_id) values".$str;
			$stmt = $dbh->prepare($query);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			return "fail";
		}
	}

	function delMember($dbh, $str){
		try
		{
			$str = substr($str, 0, -1);
			$query = "DELETE FROM opencal.groupUser_user where (gu_id, user_id) IN(".$str.")";
			$stmt = $dbh->prepare($query);
			return $stmt->execute();
		}
		catch(PDOException $e)
		{
			return "fail";
		}
	}	
	
	public function isValidDictType($zone,$dbh,$ptype='timezone') {
		try
		{
			$str_query = "SELECT 
					d1.dict_id
					FROM opencal.dictionary as d1 
					LEFT JOIN opencal.dictionary as d2 on (d1.parent_id=d2.dict_id) 
					WHERE d2.name=? and d1.name=?";
			$stmt = $dbh->prepare($str_query);
			$stmt->bindParam(1,$ptype);
			$stmt->bindParam(2,$zone);
			$stmt->execute();
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if($rec[dict_id]) {
				return $rec[dict_id];
			} else 
				return false;
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	private function isValidType($type) {
		if(preg_match("/PRI/",$type)) {
			return true;
		} else  if(preg_match("/SEC/",$type)) {
			return true;
		} else {
			return false;
		}
	}

	private function isValidDate($dt1,$dt2) {
		
		$today = mktime(0,0,0,date("m"),date("d"),date("Y"));
		$regx = "/[0-9]{1,4}-[0-9]{1,2}-[0-9]{1,2}/";
		if(preg_match($regx,$dt1) && preg_match($regx,$dt2) && strtotime($dt1)<=strtotime($dt2)&& strtotime($dt2)>=$today) {
			return true;
		} else {
			return false;
		}	
	}

	private function isValidInfo($row,$dbh,$grp) {
		$cols = explode("|",$row);
		if(sizeof($cols)!=5) {
			return false;
		}
		$userid = $this->isMember(trim($cols[4]),$dbh,$grp);
		$dictname = 'timezone';
		$timezone = $this->isValidDictType($cols[2],$dbh,$dictname);
		$octype = $this->isValidType($cols[3]);
		$dt = $this->isValidDate($cols[0],$cols[1]);
		$rec = array();
		if($userid && $timezone && $octype && $dt)
		{
			$rec[userid] = $userid;
			$rec[timezone] = $timezone;
			$rec[octype] = $cols[3];
			$rec[from] = $cols[0];
			$rec[to] = $cols[1];
			return $rec;
		} else {
			return false;
		}
	}

	public function editConfig($dbh,$args, $team) {
		$ptr = '';
		$errors = array();
		if(!isset($args['oncall']) || trim($args['oncall'])=='') {
			$errors[] = 'Pls provide OnCall details!';
		} else {
		$arr_details = explode("\n",$args['oncall']);
		foreach($arr_details as $key => $val) {
		 	$row = explode("|",$val);
		 	if(trim($row[4])!='') {
				$arr_details[$key] = trim($val);
		 	} else {
		 		unset($arr_details[$key]);
		 	}	
		}
		
		$teamid = $this->getTeamid($dbh, $team);
		$grpdet = $this->getTeamDetails($dbh,$team);
		$grp = $grpdet['user_ilist'];
		$recs = $this->getConfigList($dbh, $teamid);
		
		$erecs = array();
		foreach($recs as $rec) {
			$erecs[] = $rec[from_dt]."|".$rec[to_dt]."|".$rec[timezone]."|".($rec[oncall_type]==1?"PRI":"SEC")."|".$rec[username];
		}

		list($add_recs,$del_recs) = $this->checkDiff($arr_details,$erecs);
		$recs = array();
		foreach($add_recs as $line) {
			$rec = $this->isValidInfo($line,$dbh,$grp);
			if(!$rec) {
				$errors[] = "Invalid format :: ".$line;
			} else {
				$recs[] = $rec;
			}		
		}
		}
		if(sizeof($errors)>0){
			foreach($errors as $error) {
				 error($error);
			}
			return false;
		} 
		$luser = $this->loginUser();
		$luserid = $this->getUserIDByName($dbh,$luser);
		$insert_query = "INSERT INTO opencal.backupAssigneeConfig(user_id,assign_time,is_active,c_time,oncall_type,oncall_from,oncall_to,team_id) 
			         VALUES(?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE assign_time=?,oncall_type=?,oncall_from=?,oncall_to=?,user_id=?";
		$str_my = $args['year']."-".$args['month'];
		foreach($del_recs as $drec) {
			$dcols = explode("|",$drec);
			$uid = $this->getUserIDByName($dbh,$dcols[4]);
			$dt1 = $dcols[0];
			$dt2 = $dcols[1];
			$str_del = "DELETE FROM opencal.backupAssigneeConfig WHERE user_id=? AND oncall_from=? AND oncall_to=?";
			$stmt_del = $dbh->prepare($str_del);
			$stmt_del->bindParam(1,$uid);
			$stmt_del->bindParam(2,$dt1);
			$stmt_del->bindParam(3,$dt2);
			$stmt_del->execute();
		}
		foreach($recs as $rc) {
			$ins_query = $insert_query;
			$oc_type = $this->getTypeID($rc['octype']);
			$ctime = time();
			$user_id=$rc[userid];
			$timezone = $rc['timezone'];
			$status = '1';
			$from_dt = $rc[from];
			$to_dt = $rc[to];
			$stmt = $dbh->prepare($ins_query);
			$stmt->bindParam(1,$user_id);
			$stmt->bindParam(2,$timezone);
			$stmt->bindParam(3,$status);
			$stmt->bindParam(4,$ctime);
			$stmt->bindParam(5,$oc_type);
			$stmt->bindParam(6,$from_dt);
			$stmt->bindParam(7,$to_dt);
			$stmt->bindParam(8,$teamid);
			$stmt->bindParam(9,$timezone);
			$stmt->bindParam(10,$oc_type);
			$stmt->bindParam(11,$from_dt);
			$stmt->bindParam(12,$to_dt);
			$stmt->bindParam(13,$user_id);
			$stmt->execute();
		} 
		$lrecs = $this->getConfigList($dbh,$teamid,NULL,NULL,1);
		$logtxt = 'Changed By :: '.$luser."\n"; 
		foreach($lrecs as $rec) {
			$logtxt .= $rec[from_dt]."|".$rec[to_dt]."|".$rec[timezone]."|".($rec[oncall_type]==1?"PRI":"SEC")."|".$rec[username]."\n";
		}
		$this->logDetails($dbh,$luserid,'oncall',$logtxt);
		return true;
	}

	public function getTimeDetails($dbh,$dname='timezone') {
		$str_query = "SELECT 
			assigneetime_id,d1.label as timezone,timezone_id,time_format(start_time,'%k:%i') as start_time,
				time_format(end_time,'%k:%i') as end_time,
				escalation_manager
				FROM opencal.backupAssigneeTime as at 
				LEFT JOIN opencal.dictionary as d1 on (at.timezone_id=d1.dict_id)
				LEFT JOIN opencal.dictionary as d2 on (d1.parent_id=d2.dict_id) 
			      WHERE d2.name=? order by d1.name";
		$stmt = $dbh->prepare($str_query);
		$stmt->bindParam(1,$dname);
		$stmt->execute();
		$recs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $recs;
	}
	
	public function getTimezoneDetail($dbh,$id,$tz='timezone') {
		try
		{
			$str_query = "SELECT 
				assigneetime_id,d1.label as timezone,timezone_id,
					time_format(start_time,'%k:%i') as start_time,time_format(end_time,'%k:%i') as end_time, 
					escalation_manager
					FROM opencal.backupAssigneeTime as at 
					LEFT JOIN opencal.dictionary as d1 on (at.timezone_id=d1.dict_id)
					LEFT JOIN opencal.dictionary as d2 on (d1.parent_id=d2.dict_id) 
				      WHERE d2.name=? and assigneetime_id=?";
			$stmt = $dbh->prepare($str_query);
			$stmt->bindParam(1,$tz);
			$stmt->bindParam(2,$id);
			$stmt->execute();
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			return $rec;
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	public function getZoneList($dbh,$tz='timezone'){
		try
		{
			$sql = "SELECT d1.name 
				FROM opencal.dictionary as d1
				LEFT JOIN opencal.dictionary as d2 on (d1.parent_id=d2.dict_id)
				WHERE d2.name=?";
			$stmt=$dbh->prepare($sql);
			$stmt->bindParam(1,$tz);
			$stmt->execute();
			$list=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $list;
		}
		catch(PDOException $e)
		{
			
		}
		
	}
	
	public function getConfigList($dbh,$teamid,$month=NULL,$year=NULL,$all=0) {
		$str_config = "SELECT 
			bac.assignee_id,ou.name,ou.username,d.name as timezone,
			bac.is_active as isactive,bac.oncall_type,bac.oncall_from as from_dt,bac.oncall_to as to_dt	
			       FROM  opencal.backupAssigneeConfig as bac 
			       LEFT JOIN opencal.user as ou on (bac.user_id=ou.user_id) 
			       LEFT JOIN opencal.dictionary as d on (bac.assign_time=d.dict_id)";
		$str_where =" WHERE bac.team_id='".$teamid."' ";
		if(!$all) {
		if($month == NULL && $year == NULL) {
			$str_where.=" AND (oncall_from >=? OR oncall_to>=?) ";
			$str_param = date("Y-m-d");
		} else {
			$str_where.= " AND (date_format(bac.oncall_from,'%Y-%m') = ? OR date_format(bac.oncall_to,'%Y-%m') = ?)";
			$str_param = $year."-".$month;
		}	
		}
		$str_config.= $str_where." ORDER BY from_dt,timezone,bac.oncall_type DESC";
		$stmt = $dbh->prepare($str_config);
		if(!$all) {
		$stmt->bindParam(1,$str_param);
		$stmt->bindParam(2,$str_param);
		}
		$stmt->execute();
		$recs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $recs;
	}


	public function updateTimeConfig($args,$dbh) {
		$errors = array();
		if(trim($args['from_hh'])=='' || trim($args['from_mm'])=='') {
			$errors[] = 'Pls select start time!';
		}
		if(trim($args['end_hh'])=='' || trim($args['end_mm'])=='') {
			$errors[] = 'Pls select end time!';
		}
		if(isset($args[escalation_manager])) {
		  if($args[escalation_manager] == '') {
		    $errors[] = 'Please enter the Escalation Manager';
		  }
		  else {
		    $userQuery = "SELECT username from opencal.user where username='%s'";
		    $userQuery = sprintf($userQuery, $args[escalation_manager]);
		    $user = $dbh->getOne($userQuery);
		    if(!isset($user)) {
		      $errors[] = 'Please provide a valid user as Escalation Manager';
		    }
		  }
		}
	
		if(sizeof($errors)>0){
			foreach($errors as $error) {
				error($error);
			}
			return false;
		} 
	
		$aid = $args['aid'];
		$from_ts = $args[from_hh].":".$args[from_mm];
		$to_ts = $args[end_hh].":".$args[end_mm];
		$str_update = "UPDATE opencal.backupAssigneeTime set start_time=?,end_time=?,escalation_manager=? WHERE assigneetime_id=?";
		$stmt = $dbh->prepare($str_update);
		$stmt->bindParam(1,$from_ts);
		$stmt->bindParam(2,$to_ts);
		$stmt->bindParam(3,$args[escalation_manager]);
		$stmt->bindParam(4,$aid);
		$stmt->execute();
		return true;
	}
	
	public function getLogDetails($dbh,$args) {
		$from_ts = isset($args['from_ts'])?trim($args['from_ts']):date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
		$to_ts = isset($args['to_ts'])?trim($args['to_ts']):date("Y-m-d");
		$today = date("Y-m-d");
		$params[] = date("Y-m-d",strtotime($from_ts));
		$params[] = date("Y-m-d",strtotime($to_ts));
	
		if($args['caltype'] == '0') {
			$str_config = " SELECT  u.name as oname,u.username,oncall_to,oncall_from,'P' as octype,'US' as timezone 
				FROM  backupTapeopencalCalendar as btc 
				LEFT JOIN opencal.user as u on (btc.user_id=u.user_id)  
				WHERE oncall_to BETWEEN ? AND ?";
		} else {
		$str_config = "SELECT 
					u.name as oname,u.username,d.name as timezone,if(oncall_type=1,'P','S') as octype,oncall_to,oncall_from 
			       FROM backupAssigneeConfig as bac 
			       LEFT JOIN opencal.user as u on (bac.user_id=u.user_id)  
			       LEFT JOIN opencal.dictionary as d on (bac.assign_time=d.dict_id) 
			       WHERE oncall_to BETWEEN ? AND ?";
		}
		if(trim($args['search'])!='any' && trim($args[search])!='') {
			$str_config.= " AND u.username like ?"; 
			$params[] = "%".trim($args['search'])."%";
		}
		if(isset($args[timezone]) && $args[timezone]!=-1) {
			$str_config .= " AND bac.assign_time=?";
			$params[] = $args[timezone];
		}
		$options = array(
			        'page' => array(
			        'per_page' => (Req::has('per_page')) ? Req::get('per_page') : 50,
			        'current_page' => Req::get('page'),
                                'order_by' => Req::get('order_by') ? Req::get('order_by') : 'oncall_from'
			        )
			        );
		                $options['page']['query'] = $str_config;
		                $options['page']['db'] = $dbh;
				$options['page']['params'] = $params;
			        $recs = Pager::paginate($options['page']);
				
			        return $recs;
	}

	private function checkDiff($nrows,$erows) {
		$add_rows = array_diff($nrows,$erows);
		$del_rows = array_diff($erows,$nrows);
		return array($add_rows,$del_rows);
	}
	private function loginUser() {
		$username = $_SESSION['auth']->username;
		
		return $username;
	}	
	 public function getUserIDByName($dbh,$username) {
		$str_query = "SELECT
				user_id
				FROM opencal.user WHERE username=?";
		$stmt=$dbh->prepare($str_query);
		$stmt->bindParam(1,$username);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row[user_id];
	}
	private function logDetails($dbh,$userid,$fname,$content) {
		$year = date("Y");
		$tbl_name = "opencal.oncallConfig_log_".$year;
		$query = "INSERT INTO %s (`user_id`,`calendar_type`,`change_log`) VALUES(?,?,?)";
		$query = sprintf($query, $tbl_name);
		$stmt = $dbh->prepare($query);
		$stmt->bindParam(1,$userid);
		$stmt->bindParam(2,$fname);
		$stmt->bindParam(3,addslashes($content));
		$stmt->execute();
	}
    private function getTypeID($type) {
	    if(preg_match("/PRI/",$type)) {
                      return 1;
             } else  {
                   return 0;
             }
	  
	}
    public function checkCalendarEdit($dbh,$caltype,$already_editing=0) {
		$ctime = time();
		$luser = $this->loginUser();
	    	$luserid = $this->getUserIDByName($dbh,$luser);
		$str_query = "SELECT
				l.lock_id,username,l.m_time
				FROM opencal.calendarLock as l LEFT JOIN opencal.user as u on (l.user_id=u.user_id)  
				WHERE l.is_finished='N' AND username is not null AND (? - l.m_time) < ? AND l.calendar_type=? AND ";
		if(!$already_editing) {
			$str_query .= "l.user_id!=?";
		} else {
			$str_query .= "l.user_id=?";
		}
		
		$stmt=$dbh->prepare($str_query);
		$stmt->bindParam(1,$ctime);
		$stmt->bindParam(2,$this->time_diff);
		$stmt->bindParam(3,$caltype);
		$stmt->bindParam(4,$luserid);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row[username]) {
			$userid = $row[username];
			$timediff = $ctime - $row[m_time];
			$lockid = $row[lock_id];
		} else {
			$userid = '';
			$timediff = 0;
			$lockid = 0;
		}
		return array($userid,$timediff,$lockid);
	}

	public function checkIntermediateUpdate($dbh,$lockid,$caltype) {
		$str_query = "SELECT
				lock_id
				FROM opencal.calendarLock as l   
				WHERE l.is_finished='N' AND l.calendar_type=? AND l.lock_id > ?";
		
		$stmt=$dbh->prepare($str_query);
		$stmt->bindParam(1,$caltype);
		$stmt->bindParam(2,$lockid);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($row[lock_id]) {
			$lock_id = $row[lock_id];
		} else {
			$lock_id = false;
		}
		return $lock_id;
	}
	
	
	public function lockCalendarEdit($dbh,$caltype) {
		$ctime = time();
		$luser = $this->loginUser();
	        $luserid = $this->getUserIDByName($dbh,$luser);
	    	list($euser_id,$flag_editing,$lock_id) = $this->checkCalendarEdit($dbh,$caltype,1);
	    	if(!$flag_editing) {
			$str_query = "INSERT INTO opencal.calendarLock(user_id,calendar_type,m_time) VALUES(?,?,?)";
			$stmt=$dbh->prepare($str_query);
			$stmt->bindParam(1,$luserid);
			$stmt->bindParam(2,$caltype);
			$stmt->bindParam(3,$ctime);
			$stmt->execute();
			$sql = "SELECT lock_id from opencal.calendarLock WHERE user_id=? AND calendar_type=? AND m_time=? AND is_finished='N'";
			$stmt1 = $dbh->prepare($sql);
			$stmt1->bindParam(1,$luserid);
			$stmt1->bindParam(2,$caltype);
			$stmt1->bindParam(3,$ctime);
			$stmt1->execute();
			$rec = $stmt1->fetch(PDO::FETCH_ASSOC);
			return $rec[lock_id];
	    	} else 
	    	return $lock_id;
	}
	public function releaseCalendarLock($dbh,$lockid) {
			$str_query = "Update opencal.calendarLock set is_finished='Y' WHERE lock_id=?";
			$stmt=$dbh->prepare($str_query);
			$stmt->bindParam(1,$lockid);
			$stmt->execute();
	}
	public function generateDates($start,$duration) {
	$arr_dates = array();
	$int_i = 0;
	$day = 24*60*60;
	$start1 = $end1 = strtotime($start);
	$d = date("d",strtotime($start));
	$m = date("m",strtotime($start));
	$y = date("Y",strtotime($start));
	$end = mktime(23,59,59,$m+6,$d,$y);
	while(strtotime($start1)<$end) {
		$start1 = date("Y-m-d",($end1+$day));
		$end1 = date("Y-m-d",($end1+($day*$duration)));
		$arr_dates[$int_i][] = $start1;
		$arr_dates[$int_i][] = $end1;
		$end1 = strtotime($end1);
		$int_i++;
	}
	return $arr_dates;
	}
	
}
?>
