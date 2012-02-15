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


class Log {
  /**
   * @var integer current log level (by default disabled)
   */
  public static $level = self::DISABLED;
  
  const DISABLED  = 0;
  const ERROR = LOG_ERR;
  const WARNING = LOG_WARNING;
  const INFO = LOG_INFO;
  const DEBUG = LOG_DEBUG;
  
  /**
   * @var array list of message labels
   */
  private static $level_labels = array(
    self::ERROR => 'ERROR',
    self::WARNING => 'WARNING',
    self::INFO => 'INFO',
    self::DEBUG => 'DEBUG'
  );
  
  /**
   * @deprecated
   */
  static function init($application_name) {
    return trigger_error("DEPRECATED Log::init()", E_USER_WARNING);
  }
  
  static function info($message) {
    self::message(self::INFO, $message);
  }
  
  static function warning($message) {
    self::message(self::WARNING, $message);
  }
  
  static function error($message) {
    self::message(self::ERROR, $message);
  }
  
  static function debug($message) {
    self::message(self::DEBUG, $message);
  }
  
  /**
   * generic message method, used by other methods
   *
   * @param integer level
   * @param string log message
   */
  private static function message($level, $message) {
    if($level <= self::$level) {
      $location = debug_backtrace();
      $message = print_r($message, true);

      if($level <= LOG_WARNING)
        $message = "$message (file: ".$location[1]['file'].' @ line: '.$location[1]['line'].')';
      
      self::error_log('['.self::level_name($level).'] '.$message);
    }
  }
  
  /**
   * custom error_log implementation (by default it uses standard php error_log())
   *
   * feel free to override this method in your application
   *
   * @param string
   */
  private function error_log($message) {
    error_log($message);
  }
  
  static function level_name($level) {
    return self::$level_labels[$level];
  }

  static function level($name) {
    $name = strtoupper($name);
    self::$level = defined("self::$name") ?
      constant("self::$name") : self::WARNING;
  }
}

Log::level(getenv('OPS_LOG_LEVEL'));
