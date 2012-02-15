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

##### Download Mysql packages

sudo wget --progress=bar --directory-prefix=/tmp/ ftp://ftp.jaist.ac.jp/pub/mysql/Downloads/MySQL-5.5/MySQL-server-5.5.20-1.linux2.6.i386.rpm

sudo wget --progress=bar --directory-prefix=/tmp/ http://ftp.jaist.ac.jp/pub/mysql/Downloads/MySQL-5.5/MySQL-client-5.5.20-1.linux2.6.i386.rpm 

sudo wget --progress=bar --directory-prefix=/tmp/ http://ftp.jaist.ac.jp/pub/mysql/Downloads/MySQL-5.5/MySQL-shared-5.5.20-1.linux2.6.i386.rpm

##### Download apache package

sudo wget --progress=bar --directory-prefix=/tmp/ http://ftp.wayne.edu/apache//httpd/httpd-2.2.21.tar.gz

#### Downlaod PHP package

sudo wget --progress=bar --directory-prefix=/tmp/ http://in.php.net/distributions/php-5.3.9.tar.gz

pushd .

cd /tmp/

sudo rpm -ivh MySQL-client-5.5.20-1.linux2.6.i386.rpm MySQL-server-5.5.20-1.linux2.6.i386.rpm MySQL-shared-5.5.20-1.linux2.6.i386.rpm

sudo mysql_install_db

sudo /sbin/ldconfig

cd /usr/local/

sudo cp /tmp/httpd-2.2.21.tar.gz ./

sudo tar -xzvf httpd-2.2.21.tar.gz

cd httpd-2.2.21

sudo ./configure --enable-so

sudo make

sudo make install

cd /usr/local/

sudo cp /tmp/php-5.3.9.tar.gz ./

sudo tar -xzvf php-5.3.9.tar.gz

cd php-5.3.9

sudo ./configure --with-apxs2=/usr/local/apache2/bin/apxs --with-mysql-dir=/usr/bin/mysql --with-pdo-mysql=mysqlnd

sudo make

sudo make install

sudo cp php.ini-development /usr/local/lib/php.ini

sudo sed "s/short_open_tag = Off/short_open_tag = On/" /usr/local/lib/php.ini>~/tmp

sudo mv ~/tmp /usr/local/lib/php.ini

sudo sed "s/display_errors/;display_errors/" /usr/local/lib/php.ini>~/tmp

sudo mv ~/tmp /usr/local/lib/php.ini

sudo sed "s/short_open_tag/;short_open_tag/" /usr/local/lib/php.ini>~/tmp

sudo mv ~/tmp /usr/local/lib/php.ini

sudo echo "display_errors = Off">>/usr/local/lib/php.ini

sudo sed "s/#LoadModule php5_module/LoadModule php5_module/" /usr/local/apache2/conf/httpd.conf>~/tmp

sudo mv ~/tmp /usr/local/apache2/conf/httpd.conf

sudo sed "s/DirectoryIndex index.html/DirectoryIndex index.html index.php/" /usr/local/apache2/conf/httpd.conf>~/tmp

sudo mv ~/tmp /usr/local/apache2/conf/httpd.conf

sudo echo "AddType application/x-httpd-php .php .phtml">>/usr/local/apache2/conf/httpd.conf

sudo echo "AddType application/x-httpd-php-source .phps">>/usr/local/apache2/conf/httpd.conf

sudo /etc/init.d/mysql start

sudo /usr/local/apache2/bin/apachectl start

popd

sudo mkdir /usr/local/apache2/htdocs/calendar

sudo cp -R src/* /usr/local/apache2/htdocs/calendar/


