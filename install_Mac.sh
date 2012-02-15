#!/bin/bash

#//+---------------------------------------------------------------------------------------------------------------------------------+
#//                                                                                                                                  /
#// Copyright (c) 2012 Yahoo! Inc. All rights reserved.                                                                              /
#// Licensed under the Apache License, Version 2.0 (the "License"); you may not use this                                             /
#// file except in compliance with the License. You may obtain a copy of the License at                                              /
#//                                                                                                                                  /
#//              http://www.apache.org/licenses/LICENSE-2.0                                                                          /
#//                                                                                                                                  /
#// Unless required by applicable law or agreed to in writing, software distributed under                                            /
#// the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF                                              /
#// ANY KIND, either express or implied. See the License for the specific language governing                                         /
#// permissions and limitations under the License. See accompanying LICENSE file.                                                    /
#//                                                                                                                                  /
#// $Author:shawcs@yahoo-inc.com  $Date: 30-Jan-2012                                                                                 /
#//                                                                                                                                  /
#//+---------------------------------------------------------------------------------------------------------------------------------+

sudo apachectl start

sudo sed "s/#LoadModule php5_module/LoadModule php5_module/" /etc/apache2/httpd.conf>~/tmp

sudo mv ~/tmp /etc/apache2/httpd.conf

sudo sed "s/DocumentRoot/#DocumentRoot/" /etc/apache2/httpd.conf>~/tmp

sudo mv ~/tmp /etc/apache2/httpd.conf

sudo cp /etc/php.ini.default php.ini

sudo chmod 666 /etc/php.ini

sudo sed "s/DirectoryIndex index.html/DirectoryIndex index.html index.php/" /etc/apache2/httpd.conf>~/tmp

sudo mv ~/tmp /etc/apache2/httpd.conf

sudo apachectl restart


