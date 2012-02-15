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
require_once('pear/DB.php');
  // protect against multiple inclusions
  if ( isset($db_cal) && isset($db_ops) ) {
  	return;
  }
$db =new DB();
// local 'ops' connector (READ-ONLY)
  $db_ops = $db->connect(__DB_DSN_OPS);
  if ($db->isError($db_ops)) {
    die("Couldn't open MySQL connection to ops database, see error log for more info.");
  }
  $db_ops->setFetchMode(DB_FETCHMODE_ASSOC);


  // local 'cal' connector (READ-ONLY)
  $db_cal = DB::connect(__DB_DSN);
  if (DB::isError($db_cal)) {
    die("Couldn't open MySQL connection to cal database, see error log for more info.");
  }
  $db_cal->setFetchMode(DB_FETCHMODE_ASSOC);


  // protect against multiple inclusions
  if ( isset($db_cal_master) ) {
        return;
  }

  // MASTER 'cal' connector (READ-WRITE)
  $db_cal_master = DB::connect(__DB_DSN_RW);
  if (DB::isError($db_cal_master)) {
    $write_db_down = 1;
  }
  else {
    $write_db_down = 0;
    $db_cal_master->setFetchMode(DB_FETCHMODE_ASSOC);
  }



?>
