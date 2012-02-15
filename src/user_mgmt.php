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

  <td width=300px;><span class="title">User Management</span>
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
if($action=="adduser"){
	$username=$_POST['username'];
	$name=$_POST['name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->addUserDetails($dbh,$username,$name,$email,$password);
}

if($action=="edituser"){
	if($_POST['user_id'])
		$user_id=$_POST['user_id'];
	$dbh=Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$details = $obj_assignee->getUidDetails($dbh, $user_id);
	$username = $details['username'];
	$name= $details['name'];
	$email=$details['email'];
	$password=$details['password'];
	
	if($_POST['username'])
		$username=$_POST['username'];
	if($_POST['name'])
		$name=$_POST['name'];
	if($_POST['email'])
		$email=$_POST['email'];
	if($_POST['password'])
		$password=hash('md4',$_POST['password']);
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->editUserDetails($dbh,$user_id,$username,$name,$email,$password);
}

if($action=="deleteuser"){
	$user_id=$_POST['user_id'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->deleteUser($dbh, $user_id);
}
?>
<table  width =500px; height= 150px;>
<tr><td>
<a href="#" onclick="document.getElementById('hiddenForm').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Add new user</a>/
<a href="#" onclick="document.getElementById('hiddenForm2').style.display = 'block';document.getElementById('hiddenForm').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Edit existing user details</a>
/<a href="#" onclick="document.getElementById('hiddenForm3').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm').style.display = 'none'; return false;">Delete an user</a>
    <form action="user_mgmt.php?action=adduser" method="post" id="hiddenForm" style="display: none;">
    <table border=2px;>
	<tr><td><b>Add New User:</b></td></tr>
         <tr><td width=200px;>Username:</td><td><input type="text" name="username"/></td></tr><br/>
         <tr><td>Name:</td><td><input type="text" name="name"/></td></tr><br/>
         <tr><td>Email ID:</td><td><input type="text" name="email"/></td></tr><br/>
	 <tr><td>Password:</td><td><input type="text" name="password" /></td></tr><br/> 
         </table>
         <br/>
	 <input type="submit" value="Save" />
     </form>

    <form action="user_mgmt.php?action=edituser" method="post" id="hiddenForm2" style="display: none;">
    <table border=2px;>
	<tr><td><b>Edit Existing User Details:</b></td></tr>
         <tr><td width=200px;>User Id:</td><td><input type="text" name="user_id"/></td></tr><br/>
         <tr><td>Username:</td><td><input type="text" name="username"/></td></tr><br/>
         <tr><td>Name:</td><td><input type="text" name="name"/></td></tr><br/>
         <tr><td>Email ID:</td><td><input type="text" name="email"/></td></tr><br/>
	 <tr><td>Password:</td><td><input type="text" name="password" /></td></tr><br/> 
    </table>
	 <br/>
         <input type="submit" value="Save" />
    </form>

    <form action="user_mgmt.php?action=deleteuser" method="post" id="hiddenForm3" style="display: none;">
      <table border=2px;>
	<tr><td><b>Delete an User:</b></td></tr>
         <tr><td width=200px;>User Id:</td><td><input type="text" name="user_id"/></td></tr><br/>
      </table>
	<br/>
	<input type="submit" value="Delete"/>
    </form>	

</td></tr>
</table>
<br/><br/>

<form name='userdetails' method ='post' action="user_mgmt.php?action=details">
<select name="username" onChange="document.forms['userdetails'].submit()">
<?php
	$dbh = Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$users = $obj_assignee->getUserList($dbh);
	$username="Select an user";
	if($_POST['username'] && $_GET['action']=="details")
		$username=$_POST['username'];
?>
<option selected> <?php echo $username ?> </option>
<?php
for($i=0;$i<count($users); $i+=1)
{
	if($users[$i]['username']!=$username)
	{
		?>
		<option> <?php echo  $users[$i]['username']?></option>
		<?php
	}
}
?>
</select>
<br/><br/>	
<table border=4 cellspacing=0 cellpadding=0 width=962  background='#000000'>
<tr>
<td align=center width=16% height=35px;><b>User Id</b></td>
<td align=center width=16% ><b>Username</b></td>
<td align=center width=17% ><b>Name</b></td>
<td align=center width=17% ><b>Email</b></td>
</tr>

<?php
if($username!="Select an user"){
$dbh = Connection::cal_ro();
$obj_assignee = new calendarConfig();
$userdetails=$obj_assignee->getUserDetails($dbh,$username);

?>
<tr bgcolor="#F7F7F7">
 <td align=center width=16% height=35px><?php echo $userdetails['user_id']?></td>
 <td align=center width=16% ><?php echo $userdetails['username']?></td>
 <td align=center width=17% ><?php echo $userdetails['name']?></td>
 <td align=center width=17% ><?php echo $userdetails['email']?></td>
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
