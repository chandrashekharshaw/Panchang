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

require_once 'ApplicationController.php';

/**-----------------------------------------------------------------------**
 * NavigationController Class
 **-----------------------------------------------------------------------**/
class NavigationController extends ApplicationController 
{
  function menu() 
  {
    $menu = array(
      'services' => array(
        'label' => 'Service Catalog',
        'url' => 'srv_home.php',
        'submenu' => array()
      ),
      'dashboard' => array(
        'label' => 'Dashboard',
        'url' => 'dbr_overview.php',
        'submenu' => array()
      ),
      'systems' => array(
        'label' => 'Systems',
        'url' => 'sys_overview.php',
        'submenu' => array()
      ),
      'news' => array(
        'label' => 'News',
        'url' => 'news_SearchNews.php',
        'submenu' => array()
      ),
      'cms' => array(
        'label' => 'CMS',
        'url' => 'cms_news.php',
        'submenu' => array()
      ),
      'rsc' => array(
        'label' => 'Resources - SLA',
        'url' => 'rsc_docs.php',
        'submenu' => array()
      ),
      'Paranoid' => array(
        'label' => 'Paranoids',
        'url' => 'Paranoid.php',
      	'submenu' => array(
                          'search' => array(
                          'label' => 'Tickets',
                          'url' => 'Paranoid.php',
                          )
		)
      ),
    );

    if (!SCUIHelper::isAllowedCMS()) {
      unset($menu['cms']);
    }

 
    return $menu;
  }
  // }}}

}

?>
