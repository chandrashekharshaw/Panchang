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

        session_start();
	if($_SESSION && $_SESSION['logged'] )
	{
		header("Location: calendar.php");
	}
	else
	{
		?>
		<html>
		<body leftmargin="0" topmargin="0" rightmargin="0" marginwidth="0" marginheight="0" >
		<div style="background-color:#F025EC">
          	<table width="98%" border="0" cellpadding="2" cellspacing="0">
           	<tbody>
            	<tr>
            	<td width="85%"><a href="index.php"><img src="./images/logo.png" alt="Y! Opensource Calendar" align="left" border=0 
/></a></td>	
                </td>
               	</tr>
           	</tbody>
          	</table>
		<center>
		<div id="login" >
		
		<div id="title" style="background-color: #8B1089; width: 100%;">
		<table style="height: 20px; margin: 5px;">
			<tr><td><p><font size=5> Login Please :- </font></p></td></tr>
		</table>
		</div>
		<div id="body" style="height: 85%; background-color: rgb(155, 248, 251);">
		<br/>	
		<form action="calendar.php" method="post" id="loginform" >
		<table width="400px;" height="100px;" border="2;" style="background-color: rgb(91, 37, 240);">
		<tr>
			<th>Username</th>
			<td><input type="text" name="username"/></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" name="password" /></td>
		</tr>
		</table>
		<br/>
		<input type="submit" value="Login">
		</div>
		</div>
		</center>
		</body>
		</html>
		<?php
	}
?>
