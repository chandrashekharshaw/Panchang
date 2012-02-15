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

class CalConnection extends MyDB {
  static $default;
  /**
   * @return db connection parameter
   */
  public static function getDSN($prefix) {
    $host = Conf::get($prefix.'_host', 'db', 'dsn');
    $db   = Conf::get($prefix.'_db', 'db', 'dsn');
    $user = Conf::get($prefix.'_user', 'db', 'dsn');
    $pass = Conf::get($prefix.'_pwd', 'db', 'dsn');
    $port = Conf::get($prefix.'_port', 'db', 'dsn');
    $dsn = "mysql://".$user;
    $dsn.=trim($pass)!=''?(":$pass"):'';
    $dsn.= trim($host)!=''?("@".$host):'@localhost';
    $dsn.= (trim($port)!='')?":$port":'';
    $dsn.= (trim($db)!='')?"/$db":'';
    return $dsn;
  }
  public function getKeyDBValue($key) {
    $dsn = Conf::get($key, 'db', 'dsn');
    return $dsn;
  }

}
?>
