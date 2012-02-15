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

//define('OPS_APP_PRIVATE_DIR', dirname(__FILE__));
require_once 'assist/common/init.php';
require_once 'assist/Connection.php';
// initialize config files
Conf::init('conf/calendar_database.ini', 'db');
// DB settings:
define('__DB_DSN',CalConnection::getDSN('backupdb_ro'));
define('__DB_DSN_RW',CalConnection::getDSN('backupdb_rw'));
define('__DB_DSN_OPS',CalConnection::getDSN('ops_ro'));
// Set DB_DataObject properties:

  $pear = new PEAR();
  $options = $pear->getStaticProperty('DB_DataObject','options');
  $options = array(
    'database'         => __DB_DSN_RW,
    'schema_location'  => dirname(__FILE__).'/autoclass',
    'class_location'   => dirname(__FILE__).'/autoclass',
    'require_prefix'   => '',
    'class_prefix'     => '',
    'ignore_sequence_keys' => 'ALL', // to avoid auto_inc behaviour
  );

  // Default backup server group:
  define('__EMPLOYEE_PROFILE','');
  define('__TIMEOUT','300');
  define('__SPAREFILER_CHECK',3*60*60);
  define('__SVN_URL','');

?>
