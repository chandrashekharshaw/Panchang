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


function redirect_to($controller_name, $action_name=null, $params=array(), $fragment='') {
  $url = $controller_name;

  //TODO if controller_name is a URL and params isn't empty then add it
  if (!preg_match('/^http.*:\/.+/i', $controller_name)) {
    $url = html::url($controller_name, $action_name, $params, $fragment);
  }

  header("Location: $url");
  return array('redirect' => $url);
}

/**
 * internal redirect to a controller + [action].
 * New controller instance created and action called, when redirecting to another controller.
 * Internal controller redirect - when controller name is string 'this'.
 * When action_name is not specified - 'index' will be used.
 *
 * @param string
 * @param string
 * @return array ['controller' => $controller_name, 'action' => $action_name]
 */
function forward_to($controller_name, $action_name=null) {
  if(!$action_name)
    $action_name = 'index';

  return array('controller' => $controller_name, 'action' => $action_name);
}

/**
 * stores an error message in messages context
 * @param string error message
 */
function error($message) {
  $ctx = OpsContext::get('messages');
  if(!isset($ctx->errors))
    $ctx->errors = array();

  $ctx->errors[] = $message;
}

/**
 * generates deprecation warning
 */
function deprecated() {
  $location = debug_backtrace();

  $func = isset($location[1]['function']) ? '<'.$location[1]['function'].'>' : '';
  $class = isset($location[1]['class']) ? ' in class <'.$location[1]['class'].'>' : '';
  $loc = isset($location[1]['file']) ? ' '.$location[1]['file'].' @ line: '.$location[1]['line'] : '';
  trigger_error('DEPRECATED '.$func.$class.$loc, E_USER_WARNING);
}

/**
 * stores a flash message in messages context
 * @param string flash message
 */
function flash($message) {
  $ctx = OpsContext::get('messages');
  if(!isset($ctx->flashes))
    $ctx->flashes = array();

  $ctx->flashes[] = $message;
}

/**
 * Dispatcher
 */

class OpsDispatcher {
  /**
   * peroform an action, follows forwards, no rendering
   * @param string
   * @param string
   */
  static function perform($controller_name, $action_name=null) {
    $controller = null;

    if(!$action_name)
      $action_name = 'index';

    do {
      $controller_filename = $controller_name;
      $controller_name .= 'Controller';

      if(!$controller) {
        if(!class_exists($controller_name))
          require_once($controller_filename.'.php');

        $controller = new $controller_name();
        if($forward = $controller->before_filter()) {
          $controller_name = $forward['controller'];
          $action_name = $forward['action'];
          self::action($controller, $controller_name, $action_name);
          continue;
        }
      }

      if($forward = $controller->{$action_name}()) {
        $controller_name = $forward['controller'];
        $action_name = $forward['action'];
        self::action($controller, $controller_name, $action_name);
      }
      else if($forward = $controller->after_filter()) {
        $controller_name = $forward['controller'];
        $action_name = $forward['action'];
        self::action($controller, $controller_name, $action_name);
      }

      if(isset($forward['redirect']))
        return null;

    } while($forward);

    $controller->action_name = $action_name;
    return $controller;
  }

  /**
   * perform() helper method
   * @param object controller object (reference)
   * @param string controller name (reference)
   * @param string action name (reference)
   */
  static function action(&$controller, &$controller_name, &$action_name) {
    if($controller_name != 'this') {
      if($forward = $controller->after_filter()) {
        $controller_name = $forward[0];
        $action_name = $forward[1];
      }
      $controller = null;
    }
  }

  /**
   * peroform an action, follows forwards, renders the final output
   * @param string
   * @param string
   */
  static function execute($controller_name, $action_name) {
    if($controller = self::perform($controller_name, $action_name))
      $controller->out();
  }
}

/**
 * Base class for application controllers
 */
abstract class OpsControllerBase {
  /**
   * layout file name to render
   *
   * @var string
   */
  public $layout = 'default';

  /**
   * action name to render
   * @var string
   */
  public $action_name;

  /**
   * @var string
   */
  private $layout_content;

    /**
     * view object
     * @var mixed
     */
    public $view;

    /**
     * View Script to render
     * @var string
     */
    protected $_viewScript = null;

    /**
     *
     * @var boolean
     */
    protected $_noRender = false;


    /**
     * Set no render
     *
     * @param   boolean $value
     * @return  OpsControllerBase
     */
    public function setNoRender($value)
    {
        $this->_noRender = $value;
        return $this;
    }

    /**
     * Return no render
     *
     *
     * @return  boolean
     */
    public function getNoRender()
    {
        return $this->_noRender;
    }

    /**
     *
     *
     * @return string
     */
    public function render($a = array())
    {

        /*
         * If we are not rendering a view script then simply return.  This
         * happens when a controller action is returning json such as an AJAX
         * request.  User OpsControllerBase::setNoRender to toggle this
         * behavior
         */
        if ($this->getNoRender()) {
            return '';
        }

        if (!is_object($this->view)) {
            $this->_viewScript = $this->view;
        }

        if (empty($this->_viewScript)) {
            $this->_viewScript = $this->controller_name() . '/' .
            basename($this->action_name);
        }

        extract($a);

        ob_start();
        if ($this->_viewScript) {
            try {
                include OPS_APP_PRIVATE_DIR . '/views/' . $this->_viewScript . '.phtml';
                $this->layout_content = ob_get_clean();
            } catch(Exception $e) {
                // clean output buffer, we don't want to see broken html
                ob_clean();
                throw $e;
            }
        }

        $layout_file = OPS_APP_PRIVATE_DIR . '/layouts/' . $this->layout . '.phtml';

        ob_start();
        if ($this->layout !== null && file_exists($layout_file)) {
            include $layout_file;
        } else {
            echo $this->layout_content;
        }

        return ob_get_clean();
    }

    /**
     *
     * @return string
     */
    public function out() {
        echo $this->render(get_object_vars(OpsContext::get()));
    }

  /**
   * renders partial output
   *
   * finds a 'app/views/_<partial_name>.phtml' and $object's properties (or hash keys/values) become
   * local variables to the partial. This method functionality is similar to 'include'
   * inside a view. You can also use something like 'shared/partial_name', this method will
   * try to use 'app/views/shared/_<partial_name>.phtml'
   *
   * <code>
   * <table>
   *  <? foreach($users as $user): ?>
   *  <tr>
   *   <td><?php echo  $this->render_partial('user', $user) ?></td>
   *  </tr>
   *  <? endforeach ?>
   * </table>
   * </code>
   *
   * @param string $_name partial name, file name "_<partial name>.phtml" will be used as view
   * @param array $a hash that holds all variables, or an object
   */
  public function render_partial($_name, $a)  {
    $__name = '_'.basename($_name);
    $__name = dirname($_name).'/'.$__name;

    if(is_array($a))
      extract($a);
    else if(is_object($a))
      extract(get_object_vars($a));

    ob_start();
    include(OPS_APP_PRIVATE_DIR."/views/$__name.phtml");
    return trim(ob_get_clean());
  }

  /**
   * render text output, stop script
   * (review this method, it might not work properly with API calls, should it?)
   * @param string $v some text
   */
  public function render_text($v) {
    echo $v; exit;
  }

  /**
   * magic method to put variable in 'default' context, this variable will be available
   * in layout/view as local $name
   *
   * @param string $name
   * @param mixed $value
   */
  public function __set($name, $value) {
    OpsContext::get('default')->{$name} = $value;
  }

  /**
   * magic method to get variable from 'default' context
   *
   * @param string $name
   * @return mixed
   */
  public function __get($name) {
    return OpsContext::get('default')->{$name};
  }

  public function before_filter() {}
  public function after_filter() {}

  /**
   * current controller name
   * @return string
   */
  public function controller_name() {
    return preg_replace('/Controller$/', '', get_class($this));
  }

  /**
   * current action name
   * @return string
   */
  public function action_name() {
    return $this->action_name;
  }

  /**
   * usernames authorized to perform an override; returns empty array in base
   * @return array
   */
  protected function authorizedUsers() {
    return array();
  }

  /**
   * override what the username() function returns
   * GET params:
   *   - user: what user to act as
   *   - ttl: for how long (defaults to 60 sec)
   */
  public final function override() {
    if (defined('OPS_ENV') && (strncasecmp(OPS_ENV, 'prod', 4) === 0)) {
      header("HTTP/1.1 401 Unauthorized");
      echo "Can't do that in production.";
      exit;
    }
    $user = Req::get('user');
    if (false === array_search(username_strict(), $this->authorizedUsers(), true)) {
      header("HTTP/1.1 401 Unauthorized");;
      echo "You are not authorized to perform this action";
      exit;
    }
    $ttl = Req::get('ttl') ? Req::get('ttl') : 60;
    Log::debug('User '.username_strict().' will act as '.$user.' for '.$ttl.' seconds');
    apc_store(username_override_hash(username_strict()), $user, $ttl);
    echo "Now $user";
    exit;
  }
  /**
   */
  public final function override_reset() {
    if (defined('OPS_ENV') && (strncasecmp(OPS_ENV, 'prod', 4) === 0)) {
      header("HTTP/1.1 401 Unauthorized");
      echo "Can't do that in production.";
      exit;
    }
    apc_delete(username_override_hash(username_strict()));
    echo "Back to normal username";
    exit;
  }

    /**
     * Return a string representing a unique cache key
     *
     *
     * @return  string
     */
    protected function _getMessageCacheKey()
    {
        static $key;

        if (!$key) {
            $key = username() . '_messages';
        }

        return $key;
    }


    /**
     * Store the messages
     *
     * @param   array  $messages
     * @return  OpsControllerBase
     */
    protected function _storeMessages(array $messages)
    {
        $messages = serialize($messages);
        if (false === apc_store($this->_getMessageCacheKey(), $messages)) {
            //apc seems to always return false?  I couldn't find a valid
            //return type to check for error
            //throw new Exception('Unable to store messages');
        }

        return $this;
    }

    /**
     * Return an array of messages and delete them from cache
     *
     *
     * @return  array
     * @see     OpsControllerBase::getMessages()
     */
    protected function _fetchMessages()
    {

        $messages = $this->getMessages();
        if (!empty($messages)) {

            if (!apc_delete($this->_getMessageCacheKey())) {
                throw new Exception('Unable to delete messages from cache for '
                    . 'user: ' . username());
            }
        }

        return $messages;
    }

    /**
     * Return an array of messages currently in cache without deleting them
     *
     *
     * @return  array
     */
    public function getMessages()
    {

        if ($messages = apc_fetch($this->_getMessageCacheKey())) {
            $messages = (array)unserialize($messages);
        } else {
            $messages = array();
        }

        return $messages;

    }

    /**
     * Add a message
     *
     * Retrieves any current messages and adds message to the message data
     * structure
     *
     * @param   string  $message
     * @param   string  $type - One of the following 'error', 'success', 'info'
     * @return  OpsControllerBase
     * @see     OpsControllerBase::getMessages()
     * @see     OpsControllerBase::_storeMessages()
     */
    public function addMessage($message, $type='error')
    {
        if (!in_array($type, array('error', 'info', 'success'))) {
            throw new Exception('Unknown message type');
        }

        $messages = $this->getMessages();

        if (!array_key_exists($type, $messages)) {
            $messages[$type] = array();
        }

        $messages[$type][] = $message;

        return $this->_storeMessages($messages);
    }

    /**
     * Add a success message
     *
     * @param   string  $message
     * @return  OpsControllerBase
     * @see     OpsControllerBase::addMessage()
     */
    public function success($message)
    {
        return $this->addMessage($message, 'success');
    }


    /**
     * Add an info message
     *
     * @param   string  $message
     * @return  OpsControllerBase
     * @see     OpsControllerBase::addMessage()
     */
    public function info($message)
    {
        return $this->addMessage($message, 'info');
    }


    /**
     * Add an error message
     *
     * @param   string  $message
     * @return  OpsControllerBase
     * @see     OpsControllerBase::addMessage()
     */
    public function error($message)
    {
        return $this->addMessage($message, 'error');
    }

}

/**
 * Wrapper class for $_REQUEST
 */
class Req {
  /**
   * get variable from $_REQUEST[$name]
   * @param string $name
   * @param mixed value to return if $_REQUEST[$name] is not present
   * @return mixed
   */
  public static function get($name, $opt = null) {
    return self::has($name) ? $_REQUEST[$name] : $opt;
  }

  /**
   * get the entire $_REQUEST array
   * @return mixed
   */
  public static function getArray(){
    return $_REQUEST;
  }

  /**
   * check is variable exists in $_REQUEST[$name]
   * @param string $name
   * @return boolean
   */
  public static function has($name) {
    return array_key_exists($name, $_REQUEST);
  }

  /**
   * request method POST/GET/etc.
   * @param string method name that will be set (for unit testing purposes)
   * @return string POST, GET
   */
  public static function method($name=null) {
    if($name)
      $_SERVER['REQUEST_METHOD'] = $name;

    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * puts a variable into the REQUEST (for unit testing purposes)
   * @param string variable name
   * @param mixed variable value
   * @return string
   */
  function put($name, $value) {
    $_REQUEST[$name] = $value;
    $_GET[$name] = $value;
    $_POST[$name] = $value;
  }

  /**
   * creates a form object instance, populates it, and calls validadate() method
   * Example:
   * <code>
   * // MyForm extends OpsFormBase
   * $form = Req::form('MyForm');
   * if($form->valid())
   *   echo 'OK';
   * </code>
   *
   * @param string form name in HTML i.e. "input name="form_name[var]" value="foo"
   * @param string form class name, object class name that will handle this form
   * @return object form instance validated and populated
   */
  static function form($name, $options = array()) {
    $options = array_merge(
      array(
        'class_name' => '',
        'validate' => true
      ),
      $options
    );

    $class_name = $options['class_name'];
    if(!$class_name)
      $class_name = $name;

    $form_obj = new $class_name();
    $fields = get_class_vars(get_class($form_obj));
    $form_arr = self::get($name);

    if(is_array($form_arr))
      foreach($fields as $field => $value)
        $form_obj->$field = isset($form_arr[$field]) ? $form_arr[$field] : null;

    if($options['validate'])
      $form_obj->validate();

    return $form_obj;
  }

  static function web_root() {
    $dir = dirname($_SERVER["SCRIPT_NAME"]) == "/" ? "" : dirname($_SERVER["SCRIPT_NAME"]);

    return $dir;
  }

  static function params($exclude=array()) {
    $params = array_merge($_GET, $_POST);
    foreach($exclude as $key)
      unset($params[$key]);

    return $params;
  }

  /**
   * generates a QUERY STRING, when no args specified current Req::params() used
   *
   * @param mixed args argument array
   * @param mixed exclude array of excluded keys
   * @return string
   */
  static function query_string($args = array(), $exclude = array()) {
    if (!$args)
      $args = self::params($exclude);

    foreach($exclude as $key)
      unset($args[$key]);

    return http_build_query($args);
  }

  /**
   * Return a string prepending a fragment with a hash mark
   *
   * @param     string  $fragment
   * @return    string
   */
  public static function query_fragment($fragment='')
  {
    if (!empty($fragment)) {
        $fragment = '#' . $fragment;
    }

    return $fragment;
  }
}

/**
 * Context - stores application contexts, default is 'default'
 *
 */
class OpsContext {
  private static $contexts;

  /**
   * return requested context object
   * @param string $name context name
   * @return object context object
   */
  public static function get($name='default') {
    if(!self::$contexts)
      self::$contexts = array();

    if(!isset(self::$contexts[$name]))
      self::$contexts[$name] = new stdClass();

    return self::$contexts[$name];
  }
}

/**
 * Base class for form population and validation
 *
 * Example:
 * <code>
 * class MyForm extends OpsFormBase {
 *   public $field1;
 *   public $field2;
 *
 *   function validate() {
 *     // validation logic here
 *   }
 * }
 *
 * $form = Req::form('MyForm');
 * </code>
 */
class OpsFormBase {
  private $valid = true;
  private $error_fields = array();

  /**
   * abstract method
   */
  function validate() {}

  /**
   * check if the form valid
   * @return boolean
   */
  function valid() {
    return $this->valid;
  }

  /**
   * check if a form field has error
   * @param string $name field name
   * @return boolean
   */
  function error_field($name) {
    return in_array($name, $error_fields);
  }

  /**
   * generates an error, makes the form invalid
   * @param string message
   * @param string field name
   */
  function error($message, $field_name=null) {
    $this->valid = false;

    if($field_name) {
      $this->error_fields[] = $field_name;
      $this->error_fields = array_unique($this->error_fields);
    }

    error($message);
  }
}


/**
 * HTML helpers
 */
class html {
  /**
   * generates URL like 'controller.php?action=action&param1=value...
   *
   * @param string
   * @param string
   * @param array
   * @param string  $fragment   Fragment to be placed after a hash mark #
   * @return string
   */
  public static function url($controller_name, $action_name=null, $args=array(), $fragment='') {
    $url = Req::web_root().'/'.$controller_name.'.php';
    if ($action_name) {
      $args['action'] = $action_name;
    }

    if($args) {
      $url .= '?'.Req::query_string($args);
    }

    if (!empty($fragment)) {
        $url .= Req::query_fragment($fragment);
    }

    return $url;
  }

  /**
   * generates a GET URL string
   * @param mixed args argument array
   * @param mixed exclude array of excluded keys
   * @return string
   * @deprecated
   */
  static function getString($args = array(), $exclude = array()) {
    trigger_error('DEPRECATED, use Req::query_string() instead', E_USER_WARNING);
    return Req::query_string($args, $exclude);
  }

  /**
   * SELECT options helper - generates options list,
   * - if group is specified, generates <optgroup> around options for grouping
   * @param array [['value' => 'v', 'label' => 'name', 'options' => array[...]],...]
   * @param mixed selected value, either value or array (for multi-selects)
   * @return string
   */
  static function select_options($options, $selected=array(), $map = null) {
    if($map)
      $options = array_map(create_function('$i', 'return '.$map.';'), $options);

    if(!is_array($options))
      return;
    if(!is_array($selected)) $selected = array($selected);

    $output = '';
    foreach($options as $option) {
      $option = is_object($option) ? get_object_vars($option) : $option;
      list($value, $label, $group) =  array_values($option);
      if(isset($group)) {
        $output .= '<optgroup label="'.self::out($label).'">'."\n";
        $output .= self::select_options($group, $selected);
        $output .= "</optgroup>\n";
      }
      else {
        $output .= '<option value="'.$value.'"'.(in_array($value,$selected) ? ' selected' : '').'>'.self::out($label)."</option>\n";
      }
    }

    return $output;
  }

  /**
   * helper method form input type radio and checkbox
   * Example:
   * <input type="checkbox" name="cb1" <?php echo html::value(5, $cb1)?>>
   *
   * @param string
   * @param boolean
   * @return string
   */
  static function value($value, $checked=null) {
    $v = ' value="'.self::out($value).'" ';
    if($value == $checked)
      $v .= ' checked="checked" ';

    return $v;
  }

  /**
   * shorter representation of htmlspecialchars() -> html::out($a)
   *
   * @param string
   * @return string
   */
  static function out($value) {
    return htmlspecialchars($value);
  }
}

