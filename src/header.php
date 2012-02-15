<?php
//+---------------------------------------------------------------------------------------------------------------------------------+
//                                                                                                                                  /
// Copyright (c) 2012 Yahoo! Inc. All rights reserved.                                                                              /
// Licensed under the Apache License, Version 2.0 (the "License"); you may not use this                                             /
// file except in compliance with the License. You may obtain a copy of the License at                                              /
//                                                                                                                                  /
//              http://www.apache.org/licenses/LICENSE-2.0                                                                          /
//                                                                                                                                  /
// Unless required by applicable law or agreed to in writing, software distributed under                                            /
// the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF                                              /
// ANY KIND, either express or implied. See the License for the specific language governing                                         /
// permissions and limitations under the License. See accompanying LICENSE file.                                                    /
//                                                                                                                                  /
// $Author:shawcs@yahoo-inc.com  $Date: 30-Jan-2012                                                                                 /
//                                                                                                                                  /
//+---------------------------------------------------------------------------------------------------------------------------------+
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

  <body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0"
    onload="commonInit();" onunload="" class="yui-skin-sam">

        <!-- LOGO -->
	<div style="background-color:#F025EC">
          <table width="98%" border="0" cellpadding="2" cellspacing="0">

            <tbody>
              <tr>
      		<td width="85%"><a href="index.php"><img src="./images/logo.png" alt="Opensource Calendar" align="left" border=0 /></a></td>
		<td align="right">
                Welcome, <strong><?php echo  $auth->username; ?></strong>                
		[ <a href="log_out.php">Sign Out</a> ]<br />                  
		<a href="mailto:<?php echo  $settings['mail_group'] ?>?subject=[calendar] Feedback/Suggestions">Feedback/Suggestions</a> &nbsp;|&nbsp; <a 
href=<?php echo  $settings['bug_url'] ?> target="_blank">Bugzilla</a>&nbsp;|&nbsp;<a href=<?php echo  $settings['stats'] ?> target="_blank">Stats</a>&nbsp;
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
