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
//include 'header.php';
?>
<html>
  <head>
    <title>Opensource Calendar</title>
	<link href="css/panchang.css" rel="stylesheet" type="text/css" />
	<link href="css/dashboard.css" rel="stylesheet" type="text/css" />
	<link href="css/buttons.css" rel="stylesheet" type="text/css" />
	<link href="css/toolbar.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/panchang.js"></script>
	<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/dynamic.js"></script>
   
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/container/assets/skins/sam/container.css">
	<link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/2.8.0r4/build/autocomplete/assets/skins/sam/autocomplete.css">
    	<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/container/container-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/menu/menu-min.js"></script>
   
	<script type="text/javascript" src="js/helper/calendar.js"></script>

	<script type="text/javascript" src="js/helper/calendar-en.js"></script>
	<script type="text/javascript" src="js/helper/calendar-setup.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/animation/animation-min.js"></script>
	<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dragdrop/dragdrop-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/datasource/datasource-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/get/get-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/connection/connection-min.js"></script>
        <script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/autocomplete/autocomplete-min.js"></script>
        <style type="text/css">
             #myAutoComplete {
              width:15em; /* set width here or else widget will expand to fit its container */
              padding-bottom:2em;
              }
        </style>
	<script type="text/javascript">
	$(document).ready(function() {

	    $('#btn-add').click(function(){
	        $('#select-from option:selected').each( function() {
	                $('#select-to').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
	            	$(this).remove();
			$("#inshidden").val( $("#inshidden").val()+"("+$("#selectedgid").text()+", "+$(this).val()+")," );
		});
	    });
	    $('#btn-remove').click(function(){
	        $('#select-to option:selected').each( function() {
	            	$('#select-from').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
	            	$(this).remove();
		    	$("#delhidden").val( $("#delhidden").val()+"("+$("#selectedgid").text()+", "+$(this).val()+")," );
		});
	    });

	});
	
	</script>
  <body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0"
    onload="commonInit();" onunload="" class="yui-skin-sam">

        <!-- LOGO -->
	<div style="background-color:#F025EC">
          <table width="98%" border="0" cellpadding="2" cellspacing="0">

            <tbody>
              <tr>
      		<td width="85%"><a href="index.php"><img src="./images/logo.png" alt="Opensource Calendar" align="left" border=0 /></a></td>
		<td align="right">
                Welcome, <strong><?php echo $auth->username; ?></strong>                
		[ <a href="log_out.php">Sign Out</a> ]<br />                  
		<a href="mailto:<?php echo $settings['mail_group'] ?>?subject=[calendar] Feedback/Suggestions">Feedback/Suggestions</a> &nbsp;|&nbsp; <a 
href=<?php echo $settings['bug_url'] ?> target="_blank">Bugzilla</a>&nbsp;|&nbsp;<a href=<?php echo $settings['stats'] ?> target="_blank">Stats</a>&nbsp;
                <br />
                </td>
	      </tr>
            </tbody>
</table>
        </div>

        <!-- eo LOGO -->


<div style="background-color:#8B1089">
        <!-- NAVIGATION -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody>

    <tr>
      <td><div id="yopsnav">
          <ul>
          <li ><a href="calendar.php" title="Backup">Oncall calendar</a></li>      
          <li class="selected"><a href="admin_section.php" title="Backup">Admin Section</a></li>        
	  </ul>
        </div>
          </td>
    </tr>
    <tr>
      <td><div id="yopssubnav">
	<ul>
	   <li><a href="team_mgmt.php">Team Management</li>  	
	   <li><a href="user_mgmt.php">User Management</li>
	   <li><a href="group_mgmt.php">Group Management</li>
        </ul>
	</div>
      </td>
     </tr>
  </tbody>

</table>
<!-- End Toolbar -->
    <!-- eo NAVIGATION -->
              </td></tr>
	    </tbody>
	  </table>
	</div>
	      <!-- CONTENT -->
      <div id="" style="clear:both;padding:0px 0px 0px 0px;height:80%;">
	<table border=0 cellspacing=0 cellpadding=0 width=100%><tr><td>

      
	</td></tr></table>
      
      <style type="text/css">
<!--
tr.hide        { visibility: hidden; display: none; }
tr.show        { visibility: visible; display: table-row; }
-->
</style>
<table cellspacing=1 cellpadding=1 border=0 width=100%>
<tr><td width=100%>
<table cellspacing=1 cellpadding=1 border=0 width=100%>
<tr><td>&nbsp;</td></tr>
<tr>
  <td width=300px;><span class="title">Group Management</span>
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
if($action=="addgroup"){
	$groupname=$_POST['groupname'];
	$description=$_POST['description'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->addGroupDetails($dbh,$groupname,$description);
}

if($action=="editgroup"){
	if($_POST['group_id'])
		$group_id=$_POST['group_id'];
	$dbh=Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$details = $obj_assignee->getGidDetails($dbh, $group_id);
	$groupname = $details['name'];
	$description= $details['description'];
	
	if($_POST['groupname'])
		$groupname=$_POST['groupname'];
	if($_POST['description'])
		$description=$_POST['description'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->editGroupDetails($dbh,$group_id,$groupname,$description);
}

if($action=="deletegroup"){
	$group_id=$_POST['group_id'];
	$dbh=Connection::cal_rw();
	$obj_assignee = new calendarConfig();
	$obj_assignee->deleteGroup($dbh, $group_id);
}
?>
<table  width =500px; height= 150px;>
<tr><td>
<a href="#" onclick="document.getElementById('hiddenForm').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Add new group</a>/
<a href="#" onclick="document.getElementById('hiddenForm2').style.display = 'block';document.getElementById('hiddenForm').style.display = 'none';document.getElementById('hiddenForm3').style.display = 'none'; return false;">Edit existing group details</a>
/<a href="#" onclick="document.getElementById('hiddenForm3').style.display = 'block';document.getElementById('hiddenForm2').style.display = 'none';document.getElementById('hiddenForm').style.display = 'none'; return false;">Delete a group</a>
    <form action="group_mgmt.php?action=addgroup" method="post" id="hiddenForm" style="display: none;">
    <table border=2px;>
	<tr><td><b>Add New Group:</b></td></tr>
         <tr><td width=200px;>Groupname:</td><td><input type="text" name="groupname"/></td></tr><br/>
         <tr><td>Description:</td><td><input type="text" name="description"/></td></tr><br/>
         </table>
         <br/>
	 <input type="submit" value="Save" />
     </form>

    <form action="group_mgmt.php?action=editgroup" method="post" id="hiddenForm2" style="display: none;">
    <table border=2px;>
	 <tr><td><b>Edit Existing Group Details:</b></td></tr>
         <tr><td width=200px;>Group Id:</td><td><input type="text" name="group_id"/></td></tr><br/>
         <tr><td>Groupname:</td><td><input type="text" name="groupname"/></td></tr><br/>
         <tr><td>Description:</td><td><input type="text" name="description"/></td></tr><br/>
    </table>
	 <br/>
	 <input type="submit" value="Save" />
    </form>

    <form action="group_mgmt.php?action=deletegroup" method="post" id="hiddenForm3" style="display: none;">
      <table border=2px;>
	<tr><td><b>Delete a Group:</b></td></tr>
         <tr><td width=200px;>Group Id:</td><td><input type="text" name="group_id"/></td></tr><br/>
      </table>
	<br/>
	<input type="submit" value="Delete"/>
    </form>
  </td></tr>
</table>
<br/><br/>

<form name='GroupMember' method ='post' action="">
<?php
	$dbh = Connection::cal_ro();
	$obj_assignee = new calendarConfig();
	$groups = $obj_assignee->getGroupList($dbh);
	$groupname="Select a group";
	if($_POST['groupname'] && $_GET['action']=="details")
		$groupname=$_POST['groupname'];
	if($_GET['action']=="save"){
		$dbh = Connection::cal_rw();
		$obj_assignee = new calendarConfig();
		if($_POST['inshidden'])
			$resp1 = $obj_assignee->addMember($dbh, $_POST['inshidden']);
		if($_POST['delhidden'])
			$resp2 = $obj_assignee->delMember($dbh, $_POST['delhidden']);
		if($resp1=="fail" || $resp2 == "fail")
		{
			echo "<font size = 3 color='red'><b><i>There was some problem in your selection, so not able to save the list. [Retry ]</i</b></font><br>";
		}
		
	}
	
?>
<select name="groupname" id="selectedgroup" onChange="document.forms['GroupMember'].action='group_mgmt.php?action=details';document.forms['GroupMember'].submit()">
<option selected> <?php echo$groupname ?> </option>
<?php
for($i=0;$i<count($groups); $i+=1)
{
	if($groups[$i]['name']!=$groupname)
	{
		?>
		<option> <?php echo $groups[$i]['name']?></option>
		<?php
	}
}
?>
</select>
<br/><br/>	
<table border=4 cellspacing=0 cellpadding=0 width=962  background='#000000'>
<tr>
<td align=center width=16% height=35px;><b>Group Id</b></td>
<td align=center width=16% ><b>Groupname</b></td>
<td align=center width=17% ><b>Description</b></td>
</tr>

<?php
if($groupname!="Select a group"){
$dbh = Connection::cal_ro();
$obj_assignee = new calendarConfig();
$groupdetails=$obj_assignee->getGroupDetails($dbh,$groupname);
$memberlist=$obj_assignee->getMemberList($dbh,$groupdetails['gu_id']);
$userlist=$obj_assignee->getNonMemberList($dbh,$groupdetails['gu_id']);

?>
<tr bgcolor="#F7F7F7">
 <td id="selectedgid" align=center width=16% height=35px><?php echo$groupdetails['gu_id']?></td>
 <td align=center width=16% ><?php echo$groupdetails['name']?></td>
 <td align=center width=17% ><?php echo$groupdetails['description']?></td>
</tr>
<?php
}
?>
</table>
<br/>
<b>Add/Remove User:</b><fieldset>
  <br/>
  <table>
    <tr>
	<td><b>User List</b></td>
	<td></td>
	<td><b>Member List</b></td>
    </tr>
    <tr>
    	<td width=80px;>
	<select name="selectfrom[]" id="select-from" multiple size="10" style="background-color: #18B7EB;">
	<?php
      	foreach($userlist as $user){
	?>
	<option value=<?php echo$user['user_id'].">".$user['username']?></option>
	<?php
	}
	?>
	</select>
   </td>
   <td width=80px;>
	<center>
		<a style="display:block; border:1px solid #aaa; margin:2px; background-color: #F724F3;" href="JavaScript:void(0);" id="btn-add" >Add&raquo;</a><br>
    		<a style="display:block; border:1px solid #aaa; margin:2px; background-color: #18DDEB;" href="JavaScript:void(0);" id="btn-remove">&laquo;Remove </a>
		<input type="hidden" name="inshidden" id="inshidden" value="">
		<input type="hidden" name="delhidden" id="delhidden" value="">
	</center>
   </td>
   <td width=80px;>
	<select name="selectto[]" id="select-to" multiple size="10" style="background-color: #EB18E8;">
      	<?php
      	foreach($memberlist as $member){
	?>
	<option value=<?php echo$member['user_id'].">".$member['username']?></option>
	<?php
	}
	?>
    	</select>
   </td>
   </tr>
   </table>
  </fieldset>
  <br/>
  <input type="submit" value="Save" onClick="document.forms['GroupMember'].action='group_mgmt.php?action=save';document.forms['GroupMember'].submit();"/>	
    
</form>

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
