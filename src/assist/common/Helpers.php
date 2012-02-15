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

function env() {/*{{{*/
  if(defined('OPS_ENV'))
    return OPS_ENV;

  return getenv('OPS_ENV') ? getenv('OPS_ENV') : 'development';
}/*}}}*/

// initialize OPS_ENV
if(!defined('OPS_ENV'))
  define('OPS_ENV', env());

/**
 * the simple hash used for generating an APC key for user override
 *
 * @param string $username
 * @return string
 */
function username_override_hash($username) {
  return md5('username_override_'.$username);
}

/**
 */
function username($force=false) {/*{{{*/
  static $username;

  if($username && !$force)
    return $username;
  // this hack is for OpsApiServer class
  if(getenv('OPS_API_SERVER_USERNAME'))
    $username = getenv('OPS_API_SERVER_USERNAME');
  else 
    $username = strlen(getenv('_byuser')) ? getenv('_byuser') : getenv('.byuser');

  #if we're not in prod, check in APC for override
  /*if (defined('OPS_ENV') && !preg_match('/^prod/i', OPS_ENV)) {
    $override = apc_fetch(username_override_hash($username));
    if ($override) {
      Log::debug('User '.$username.' acting as '.$override);
      $username = $override;
    }
  }
*/
  if(!$username)
    $username = getenv("USER");

  return $username;
}/*}}}*/

/**
 * return true BY username; used in override process to make sure
 * we don't override an overridden username
 *
 * @return string BY username
 */
function username_strict() {
  $username = strlen(getenv('_byuser')) ? getenv('_byuser') : getenv('.byuser');
  return $username;
}

/**
 * used by OpsApiServer class only
 * @return string
 */
function application() {
  return getenv('.byappname') ?
    getenv('.byappname') : getenv('OPS_API_SERVER_APPLICATION');
}

class Helpers {
  /**
   * the hostname of the current machine
   *
   * this method requires yphp_gethostname package
   * @return string hostname
   */
  function get_localhost() {
    // returns hostname < 255 chars
    // http://dist.corp.yahoo.com/by-package/yphp_gethostname/
    if (defined('PHP_HOSTNAME')) {
      return PHP_HOSTNAME;
    }

    // returns hostname < 32 chars
    $uname = posix_uname();
    return ($uname['nodename']);
  }

  /**
   * @todo document this method
   *
   * @return int
   */
  function apcTimeout(){
    if(defined('APCTIMEOUT'))
      return APCTIMEOUT;

    return getenv('APCTIMEOUT') ? getenv('APCTIMEOUT') : 18000;
  }

  /**
   * check if given value is an array, otherwise put it in array
   * just to save time typing the same code block again and again
   * @param mixed
   * @return array
   */
  function as_array($value) {
    return is_array($value) ? $value : array($value);
  }
}

?>
