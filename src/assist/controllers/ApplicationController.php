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


class ApplicationController extends OpsControllerBase {
  function before_filter() {
    $this->username = username();
  }

  // this method used by views with pagination
  final protected function order_by($order_by, $current_order, $label=null ,$class='') {
    $label = $label ? $label : $order_by;

    if(preg_match('/(-*)([\w\.]+)/',$current_order, $res)) {
      if($res[2] == $order_by) {
        $label .= '&#160;'.($res[1] == '-' ? '&darr' : '&uarr');
        $order_by = ($res[1] == '-' ? '' : '-').$order_by;
      }
    }
    $url = html::url($this->controller_name(), $this->action_name(), Req::params(array('order_by')));
    return '<a href="'.$url.'&order_by='.$order_by.'" class="'. $class .'">'.$label.'</a>';
  }

  // this method used by views with pagination
  final protected function page_url($page) {
    $url = html::url($this->controller_name(), $this->action_name(), Req::params(array('page')));
    return "{$url}&page={$page}";
  }

  // this method used by views with pagination
  final protected function per_page_url() {
    return html::url($this->controller_name(), $this->action_name(), Req::params(array('per_page')));
  }
}

?>
