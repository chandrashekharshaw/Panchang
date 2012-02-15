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

require_once 'Logger.php';
require_once 'Conf.php';


class MyDB
{/*{{{*/


    /*
     * These constants are intended to standardize the indexes in arrays
     * that are parsed configurations.  This allows external classes to
     * refer to these indexes in the same way that the internals of this class
     * refers to them.
     */
    const DSN       = 'dsn';
    const USERNAME  = 'username';
    const PASSWORD  = 'password';
    const HOST      = 'host';
    const PORT      = 'port';
    const DATABASE  = 'database';


  /**
   * @var array database connections hash
   */
  static $connections;

  /**
   * create connection instance (PDO)
   * @param string
   * @param string
   * @param string
   * @return object
   */
  static function connect($dsn, $username, $password=null) {/*{{{*/
    $key = md5("pdo-$dsn-$username-$password");

    if(isset(self::$connections[$key]))
      return self::$connections[$key];

    $dbh = new OpsPDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$connections[$key] = $dbh;

    return $dbh;
  }/*}}}*/

  /**
   * create connection instance (PEAR)
   * @param string
   * @return object
   */
  static function connect_legacy($dsn) {/*{{{*/
    $key = md5("pear-$dsn");

    if(isset(self::$connections[$key]))
      return self::$connections[$key];

    $dbh = DB::connect($dsn);

    if(DB::isError($dbh)) {

        /*
         * strip the password out of the dsn before attempting to
         * output an error message
         */
        $config = self::parseDsn($dsn);

        throw new Exception('Unable to connect to database ('
            . $config[self::DSN] . ') with username (' . $config[self::USERNAME] . ')');
    }

    $dbh->setFetchMode(DB_FETCHMODE_ASSOC);
    self::$connections[$key] = $dbh;


    return $dbh;
  }/*}}}*/

  /**
   * database connection (PDO)
   * get DSN from ['db'][$name] and create connection instance
   * @param string DSN key name in the config file
   * @return object
   */
  function get($name) {/*{{{*/
    // when PDO throws an exception it includes username and password in clear text
    // we want to avoid this, so catch and throw exception again
    try {
      list($dsn, $username, $password) = self::get_dsn_username_password($name);
      return self::connect($dsn, $username, $password);
    }
    catch(PDOException $e) {
      throw new PDOException($e->getMessage());
    }
  }/*}}}*/

  /**
   * database connection (PEAR)
   * get DSN from ['db'][$name] and create connection instance
   * @param string key name in the config file
   * @return object
   */
  function get_legacy($name) {/*{{{*/
    return self::connect_legacy(self::get_dsn($name));
  }/*}}}*/

    /**
     * parse PEAR style DSN string
     * @param string DSN in PEAR format
     * @return array (PDO style) $dsn, $username, $password
     */
    public static function get_dsn_username_password($name)
    {/*{{{*/

        $parsed = self::parseDsn(self::get_dsn($name));

        return array(
            $parsed[self::DSN],
            $parsed[self::USERNAME],
            $parsed[self::PASSWORD],
        );

    }/*}}}*/

    /**
     * Parse dsn, username, password from string
     *
     * This method also returns the parts of the dsn individually such as
     * the host, port, and database.  See the return value for more description.
     *
     * Expected string
     *    mysql://username:password@host:port/database
     *
     *  port and password are optional
     *
     * @param   string  $value
     * @return  array   indexes dsn, username, password, host, port, database
     */
    public static function parseDsn($value)
    {
        if (empty($value)) {
            throw new Exception(__METHOD__ . ' - format of DSN should conform '
                . 'to mysql://username:password@host:port/database - Received '
                . 'empty value');
        }

        /*
         * Matches will return:
         *  - value after double forward slashes but before the @ as index [1]
         *  - value after @ but before the next forward slash as index[2]
         *  - value after the forward slash as index[3]
         */
        if (!preg_match('/.+:\/\/(.+)\@(.*)\/(.*)/', $value, $matches)) {
            throw new Exception(__METHOD__ . ' - format of DSN should conform '
                . 'to mysql://username:password@host:port/database - Received ('
                . $value . ')');
        }

        $username   = null;
        $password   = null;
        $host       = null;
        $port       = null;
        $database   = null;

        $username = $matches[1];
        if (false !== strpos($username, ':')) {
            list($username, $password) = explode(':', $username);
        }

        $host = $matches[2];
        if (false !== strpos($host, ':')) {
            list($host, $port) = explode(':', $host);
        }

        //default to localhost
        if (empty($host)) {
            $host = '127.0.0.1';
        }

        $database = $matches[3];

        $dsn = 'mysql:host=' . $host . ';' . 'dbname=' . $database;

        if (!empty($port)) {
            $dsn .= ';port=' . $port;
        }

        return array(
            self::DSN       => $dsn,
            self::USERNAME  => $username,
            self::PASSWORD  => $password,
            self::HOST      => $host,
            self::PORT      => $port,
            self::DATABASE  => $database,
        );
  }

  /**
   * read 'db' conf file and get PEAR style DSN
   * @param string name of the DSN in the 'db' configuration file
   * @return string
   */
  static function get_dsn($name) {/*{{{*/
    return Conf::get($name, 'db', 'dsn');
  }/*}}}*/

  /**
   * helper: generate comma separated '?' using array size
   * @param array
   * @return string
   */
  static function qmarks(&$list) {
    return join(',', array_fill(0, count($list), '?'));
  }

  /**
   * helper: generate SQL parts and values array to be used with PDO
   *
   * list of SQL parts that will be joined like "join(',', $parts)".
   * in case of
   *   - update: sql part looks like 'field = ?' and 'field = DEFAULT' if value == (string) 'DEFAULT'
   *   - insert: sql part looks like '?' or 'DEFAULT'
   *
   * example:
   * <code>
   * <?php
   * // ...
   * list($fields, $values) = MyDB::parts_for('update', array('col1', 'col2'), $data);
   * $query = 'update t1 set '.join(',', $fields).' where id = ?'
   * $values[] = 443; // add id for the where clause
   * $stmt = $dbh->prepare($query);
   * $stmt->execute($values);
   * // ...
   * ?>
   * </code>
   *
   * @param string 'insert' or 'update'
   * @param array list of allowed fields (this way we sanitize SQL)
   * @param array key/value pairs
   * @return array [array $sql_parts, array $values]
   */
  static function parts_for($mode, $fields, &$data) {/*{{{*/
    $sql_parts = $values = array();
    $mode = strtolower($mode);
    foreach($data as $field => $value)
      if(in_array($field, $fields)) {
        if(($mode == 'insert' && $value !== 'DEFAULT') || $mode == 'update') {
          $sign = $value === 'DEFAULT' ? 'DEFAULT' : '?';
          $sql_parts[] = $mode == 'insert' ? $field : "{$field} = {$sign}";

          if($value !== 'DEFAULT')
            $values[] = $value;
        }
      }

    return array($sql_parts, $values);
  }/*}}}*/
}/*}}}*/

/**
 * Wrapper class around PHP's PDO
 *
 * added logging and exceptions handling
 */
class OpsPDO extends PDO {/*{{{*/
  private $active_transaction = false;

  /**
   * @return PDOStatement
   */
  public function prepare($query, $opts = NULL) {
    Log::debug('query (prepare): '.$query);

    if(!$stmt = parent::prepare($query)) {
      $error_info = $this->errorInfo();
      Log::error('query failed: '.$query.' error: '.$error_info[0].' '.$error_info[2]);
      throw new Exception('Internal Application Error (DATABASE)');
    }

    return new OpsPDOStatement($stmt);
  }

  /**
   *
   * @return PDOStatement
   */
  function query($query) {
    Log::debug('query: '.$query);
    if (Log::$level == Log::DEBUG) {
      return new OpsPDOStatement(parent::query($query));
    } else {
      return parent::query($query);
    }
  }

  function exec($query) {
    Log::debug('query (exec): '.$query);
    return parent::exec($query);
  }

  function beginTransaction() {
    if($this->active_transaction) {
      Log::debug('transaction already started');
      return false;
    }

    $this->active_transaction = true;

    Log::debug('begin transaction');
    return parent::beginTransaction();
  }

  function commit() {
    Log::debug('commit transaction');
    $this->active_transaction = false;
    return parent::commit();
  }

  function rollback() {
    Log::debug('rollback transaction');
    $this->active_transaction = false;
    return parent::rollback();
  }
  
	/**
	 * Fetches all SQL result rows as a sequential array.
	 * Uses the current fetchMode
	 * 
	 * @author											A. Stefan De Clercq <declercq@yahoo-inc.com>
	 * @param string								$sql  An SQL SELECT statement.
	 * @param mixed                 $bind Data to bind into SELECT placeholders.
	 * @param mixed                 $fetchMode Override default fetch mode.
	 * @return array
   */
	public function getAll($sql, $bind = array(), $fetchMode = PDO::FETCH_ASSOC) {
		if (! is_array($bind)) {
			$bind = array($bind);
  	}
  	
		$stmt = parent::prepare($sql);
		$stmt->execute($bind);
  	
		return $stmt->fetchAll($fetchMode);
  	
	}
  
	/**
	 * Fetches the first row of the SQL result.
	 * Uses the current fetchMode for the adapter.
	 *
	 * @author											A. Stefan De Clercq <declercq@yahoo-inc.com>
	 * @param string								$sql An SQL SELECT statement.
	 * @param mixed 								$bind Data to bind into SELECT placeholders.
	 * @param mixed                 $fetchMode Override default fetch mode.
	 * @return array
	 */
	public function getRow($sql, $bind = array(), $fetchMode = PDO::FETCH_ASSOC) {
		if (! is_array($bind)) {
			$bind = array($bind);
		}

		$stmt = parent::prepare($sql);
		$stmt->execute($bind);
  	
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Fetches all SQL result rows as an array of key-value pairs.
	 *
	 * The first column is the key, the second column is the
	 * value.
	 * 
	 * @author											A. Stefan De Clercq <declercq@yahoo-inc.com>
	 * @param string         				$sql An SQL SELECT statement.
	 * @param mixed 				 				$bind Data to bind into SELECT placeholders.
	 * @return array
	 */
	
	public function getPairs($sql, $bind = array()) {
		if (! is_array($bind)) {
			$bind = array($bind);
		}
	  
		$stmt = parent::prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute($bind);
	  
		$data = array();
		while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
			$data[$row[0]] = $row[1];
		}
	  
		return $data;
	}
	
	/**
	 * Fetches the first column of all SQL result as an array
	 * 
	 * The first column in each row is used as the array key.
	 * 
	 * @author											A. Stefan De Clercq <declercq@yahoo-inc.com>
	 * @param string								$sql An SQL SELECT statement.
   * @param mixed									$bind Data to bind into SELECT placeholders.
   * @return array
	 */
	
	public function getCol($sql, $bind = array()) {
		if (! is_array($bind)) {
			$bind = array($bind);
		}
		
		$stmt = parent::prepare($sql);
		$stmt->execute($bind);
  	
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}
	
	/**
	 * Fetches the first column of the the first row of an SQL result as a mixed variable
	 * 
	 * @author											A. Stefan De Clercq <declercq@yahoo-inc.com>
	 * @param string								$sql An SQL SELECT statement
	 * @param mixed									$bind Data to bind into SELECT placeholders
	 * @return mixed
	 */
	public function getOne($sql, $bind = array()) {
		if (! is_array($bind)) {
			$bind = array($bind);
		}
		
		$stmt = parent::prepare($sql);
		$stmt->execute($bind);
		
		$result = $stmt->fetchColumn();
		
		return $result? $result : NULL; 
	}
	
}/*}}}*/

/**
 * Wrapper class around PHP's PDOStatement
 *
 * added logging
 */
class OpsPDOStatement implements IteratorAggregate {/*{{{*/
  private $__stmt;

  function __construct(PDOStatement $PDOStatement) {
    $this->__stmt = $PDOStatement;
  }

  function execute($v = null) {
    Log::debug('statement (execute)');
    Log::debug($v);
    return $this->__stmt->execute($v);
  }

  /** reflection seems to break bindParam on occasion**/
  function bindParam($param, $value) {
    $this->__stmt->bindParam($param, $value);
  }

  function __call($name, $args) {
    $method = new ReflectionMethod($this->__stmt, $name);
    return $method->invokeArgs($this->__stmt, $args);
  }

  function getIterator() { return $this->__stmt; }
}/*}}}*/

/**
 * Base class for Application Connection
 * contains basic helper methods.
 * This is obsolete, don't use this approach (akabanov 04/22/08)
 * @see MyDB
 * @deprecated
 */
abstract class ConnectionBase {/*{{{*/
  /**
   * @param string configuration name
   * @return string
   */
  static function get_dsn($conf_name) {
    return 'mysql:host='.Conf::$FILE[$conf_name][OPS_ENV]['hostname'].
           ';dbname='.Conf::$FILE[$conf_name][OPS_ENV]['database'];
  }

  /**
   * @param string configuration name
   * @return string
   */
  static function get_username($conf_name) {
    return Conf::$FILE[$conf_name][OPS_ENV]['username'];
  }

  /**
   * @param string configuration name
   * @return string
   */
  static function get_password($conf_name) {
    return Conf::$FILE[$conf_name][OPS_ENV]['password'];
  }
}/*}}}*/

/**
 * Database Connections Registry, we should obsolete this
 * use DB class instead. We can't delete it because some apps
 * still use it. Use MyDB::get() and MyDB::get_legacy() (akabanov 04/22/08)
 * @deprecated
 * This is obsolete, don't use this approach (akabanov 04/22/08)
 * @see MyDB
 * @deprecated
 */
class DbRegistry {/*{{{*/
  /**
   * @var array current connections list
   */
  static $connections;

  /**
   * create new connection
   *
   * when new connection is requested it checks connections list and if the requested connection doesn't exists
   * creates it and puts in the connections array
   *
   * @param string DSN
   * @param string username
   * @param string password
   */
  static function connect($dsn, $username, $password=null) {
    $cuid = md5($dsn.$username.$password);
    if(isset(self::$connections[$cuid])) {
      return self::$connections[$cuid];
    }

    $dbh = new OpsPDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    self::$connections[$cuid] = $dbh;

    return $dbh;
  }
}/*}}}*/

?>
