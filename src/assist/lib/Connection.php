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


class Connection extends MyDB {
  static $default;
  
  /**
   * Portal read/write db connector
   *
   * @return db connection handler
   */
  public static function cal_rw() {
    $dsn = "mysql:host=".Conf::get('backupdb_rw_host', 'db', 'dsn') . ";dbname=".Conf::get('backupdb_rw_db', 'db', 'dsn');
    $dsn .= ";port=".Conf::get('backupdb_rw_port', 'db', 'dsn');
    $user = Conf::get('backupdb_rw_user', 'db', 'dsn');
    $pass = Conf::get('backupdb_rw_pwd', 'db', 'dsn');
    return self::connect($dsn, $user, $pass);
  }
   /**
   * Backupdb read only db connector
   *
   * @return db connection handler
   */
  
 public static function cal_ro() {
    $dsn = "mysql:host=".Conf::get('backupdb_ro_host', 'db', 'dsn') . ";dbname=".Conf::get('backupdb_ro_db', 'db', 'dsn');
    $dsn .= ";port=".Conf::get('backupdb_ro_port', 'db', 'dsn');
    $user = Conf::get('backupdb_ro_user', 'db', 'dsn');
    $pass = Conf::get('backupdb_ro_pwd', 'db', 'dsn');
    return self::connect($dsn, $user, $pass);
  }
  /**
   * OPS read only db connector
   *
   * @return db connection handler
   */
 
   public static function ops_ro() {
    $dsn = "mysql:host=".Conf::get('ops_ro_host', 'db', 'dsn') . ";dbname=".Conf::get('ops_ro_db', 'db', 'dsn');
    $dsn .= ";port=".Conf::get('ops_ro_port', 'db', 'dsn');
    $user = Conf::get('ops_ro_user', 'db', 'dsn');
    $pass = Conf::get('ops_ro_pwd', 'db', 'dsn');
    return self::connect($dsn, $user, $pass);
  }
}

?>
