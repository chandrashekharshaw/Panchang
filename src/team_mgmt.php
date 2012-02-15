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
require_once 'assist/lib/model/calendarConfig.php';

session_start();
$auth = $_SESSION['auth'];
$settings=parse_ini_file('conf/setting.ini', true);
$dbh = Connection::cal_ro();
$obj = new calendarConfig();
$TMG= $obj->isMember($auth->username, $dbh, $settings['manager_group']);
if( !$TMG)
{
		header( "Location: calendar.php");
}
else
{
$action=$_GET['action'];
include 'header.php';
?>

  <td width=300px;><span class="title">Team Management</span>
  </td>
</tr>

<tr><td>&nbsp;</td></tr>
<tr><td colspan=2><table cellspacing=0 cellpadding=0 border=0 width=962>
<tr>
<td align=right><table cellspacing=2 cellpadding=2 border=0><tr>
</tr>
</table>
</td>
</tr></table></td></tr>

</tr>
</table>
</td>
</tr></table>

<tr><td width=962>
<?php
if($action=="addteam"){
	$team_name=$_POST['team_name'];
	$desc=$_POST['description'];
	$user_ilist=$_POST['user_ilist'];
	$admin_ilist=$_POST['admin_ilist'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->addTeamDetails($dbh,$team_name,$desc,$user_ilist,$admin_ilist);
}

if($action=="editteam"){
	if($_POST['team_id'])
		$team_id=$_POST['team_id'];
	$dbh=Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$details = $obj_assignee->getTidDetails($dbh, $team_id);
	$team_name = $details['team_name'];
	$desc = $details['description'];
	$user_ilist=$details['user_ilist'];
	$admin_ilist=$details['admin_ilist'];
	
	if($_POST['team_name'])
		$team_name=$_POST['team_name'];
	if($_POST['description'])
		$desc=$_POST['description'];
	if($_POST['user_ilist'])
		$user_ilist=$_POST['user_ilist'];
	if($_POST['admin_ilist'])
		$admin_ilist=$_POST['admin_ilist'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->editTeamDetails($dbh,$team_id,$team_name,$desc,$user_ilist,$admin_ilist);
}

if($action=="deleteteam"){
	$team_id=$_POST['team_id'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->deleteTeam($dbh, $team_id);
}
?>
<table  width =500px; height= 150px;>
<tr><td>
<a href="#" onclick="document.getElementById('hiddenForm').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Add new Team</a>/
<a href="#" onclick="document.getElementById('hiddenForm2').style.display = 'block';document.getElementById('hiddenForm').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Edit Existing Team Details</a>
/<a href="#" onclick="document.getElementById('hiddenForm3').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm').style.display = 'none'; return false;">Delete a Team</a>
    <form action="team_mgmt.php?action=addteam" method="post" id="hiddenForm" style="display: none;">
    <table border=2px;>
	<tr><td><b>Add New Team:</b></td></tr>
         <tr><td width=200px;>Team Name:</td><td><input type="text" name="team_name"/></td></tr><br/>
         <tr><td>Description:</td><td><input type="text" name="description"/></td></tr><br/>
         <tr><td>User Ilist:</td><td><input type="text" name="user_ilist"/></td></tr><br/>
         <tr><td>Admin Ilist:</td><td><input type="text" name="admin_ilist"/></td></tr><br/>
         </table>
         <br/>
	 <input type="submit" value="Save" />
     </form>

    <form action="team_mgmt.php?action=editteam" method="post" id="hiddenForm2" style="display: none;">
    <table border=2px;>
	<tr><td><b>Edit Existing Team Details:</b></td></tr>
         <tr><td width=200px;>Team Id:</td><td><input type="text" name="team_id"/></td></tr><br/>
         <tr><td>Team Name:</td><td><input type="text" name="team_name"/></td></tr><br/>
         <tr><td>Description:</td><td><input type="text" name="description"/></td></tr><br/>
         <tr><td>User Ilist:</td><td><input type="text" name="user_ilist"/></td></tr><br/>
         <tr><td>Admin Ilist:</td><td><input type="text" name="admin_ilist"/></td></tr><br/>
    </table>
	 <br/>
         <input type="submit" value="Save" />
    </form>

    <form action="team_mgmt.php?action=deleteteam" method="post" id="hiddenForm3" style="display: none;">
      <table border=2px;>
	<tr><td><b>Delete a Team:</b></td></tr>
         <tr><td width=200px;>Team Id:</td><td><input type="text" name="team_id"/></td></tr><br/>
      </table>
	<br/>
	<input type="submit" value="Delete"/>
    </form>	

</td></tr>
</table>
<br/><br/>

<form name='teamdetails' method ='post' action="team_mgmt.php?action=details">
<select name="team_name" onChange="document.forms['teamdetails'].submit()">
<?php
	$dbh = Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$teams = $obj_assignee->getTeamlist($dbh);
	$team="Select a team";
	if($_POST['team_name'] && $_GET['action']=="details")
		$team=$_POST['team_name'];
?>
<option selected> <?php echo $team ?> </option>
<?php
for($i=0;$i<count($teams); $i+=1)
{
	if($teams[$i]['team_name']!=$team)
	{
		?>
		<option> <?php echo  $teams[$i]['team_name']?></option>
		<?php
	}
}
?>
</select>
<br/><br/>	
<table border=4 cellspacing=0 cellpadding=0 width=962  background='#000000'>
<tr>
<td align=center width=20% height=35px;><b>Team Id</b></td>
<td align=center width=20% ><b>Team name</b></td>
<td align=center width=20% ><b>Description</b></td>
<td align=center width=20% ><b>User Ilist</b></td>
<td align=center width=20% ><b>Admin Ilist</b></td>
</tr>

<?php
	if($team!="Select a team"){
		$dbh = Connection::cal_ro();
		$obj_assignee = new calendarConfig();
		$teamdetails=$obj_assignee->getTeamDetails($dbh,$team);
?>
		<tr bgcolor="#F7F7F7">
 		<td align=center width=20% height=35px><?php echo $teamdetails['team_id']?></td>
 		<td align=center width=20% ><?php echo $teamdetails['team_name']?></td>
 		<td align=center width=20% ><?php echo $teamdetails['description']?></td>
 		<td align=center width=20% ><?php echo $teamdetails['user_ilist']?></td>
 		<td align=center width=20% ><?php echo $teamdetails['admin_ilist']?></td>
		</tr>
<?php
	}
?>
</table>


<br/><br/><br/><br/><br/>

      </div>
      <!-- eo CONTENT -->
      
      <!-- FOOTER -->
      <div id="ft">
        <br>
        <div class="margTop" style="border-top: 1px solid rgb(95, 95, 95); position: relative; padding-top: 5px;" align="center">
          <small>Copyright &copy; 2012 <a href="http://www.yahoo.com">Yahoo!</a> Inc. All rights reserved. 
          </small>
          <br />
          <br />
       </div>
      <!-- FOOTER -->
      </div>
<script type="text/javascript" src="js/panchang.js"></script>
<script type="text/javascript" src="js/util.js"></script>      
      <!-- eo FOOTER -->
  </body>
</html>

<?php
}
?>
