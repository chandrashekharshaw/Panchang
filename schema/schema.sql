/*
//+---------------------------------------------------------------------------------------------------------------------------------+
//                                                                                                                                  /
// Copyright (c) 2012 Yahoo! Inc. All rights reserved.                                                                              /
// Licensed under the Apache License, Version 2.0 (the "License"); you may not use this                                             /
// file except in compliance with the License. You may obtain a copy of the License at                                              /
//                                                                                                                                  /
//              http://www.apache.org/licenses/LICENSE-2.0                                                                          /
//                                                                                                                                  /
// Unless required by applicable law or agreed to in writing, software distributed under                                            /
// the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF                                              /
// ANY KIND, either express or implied. See the License for the specific language governing                                         /
// permissions and limitations under the License. See accompanying LICENSE file.                                                    /
//                                                                                                                                  /
// $Author:shawcs@yahoo-inc.com  $Date: 30-Jan-2012                                                                                 /
//                                                                                                                                  /
//+---------------------------------------------------------------------------------------------------------------------------------+
*/

/* Create database */
CREATE DATABASE opencal;

/* Create required tables */
CREATE TABLE opencal.`user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL DEFAULT '',
  `name` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(30) DEFAULT NULL,
  `c_time` int(10) unsigned NOT NULL DEFAULT '0',
  `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=100001 DEFAULT CHARSET=latin1;

CREATE TABLE opencal.`groupUser` (
  `gu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(128) NOT NULL DEFAULT '',
  `c_time` int(10) unsigned NOT NULL DEFAULT '0',
  `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gu_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=latin1;

CREATE TABLE opencal.`groupUser_user` (
  `gu_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `e_time` int(10) unsigned NOT NULL DEFAULT '1735718400',
  `s_time` int(10) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  UNIQUE KEY `gu_id_2` (`gu_id`,`user_id`),
  KEY `gu_id` (`gu_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE opencal.`backupAssigneeConfig` (
  `assignee_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `assign_time` tinyint(2) NOT NULL DEFAULT '0',
  `c_time` int(10) NOT NULL DEFAULT '0',
  `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1',
  `oncall_type` tinyint(1) NOT NULL DEFAULT '0',
  `oncall_from` date NOT NULL DEFAULT '0000-00-00',
  `oncall_to` date NOT NULL DEFAULT '0000-00-00',
  `team_id` int(50) NOT NULL,
  PRIMARY KEY (`assign_time`,`oncall_type`,`oncall_from`,`oncall_to`,`team_id`),
  UNIQUE KEY `assignee_id` (`assignee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE opencal.`dictionary` (
  `dict_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(32) NOT NULL DEFAULT '',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_num` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dict_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	
CREATE TABLE opencal.`backupAssigneeTime` (
		       `assigneetime_id` int(10) NOT NULL AUTO_INCREMENT,
		       `timezone_id` int(10) NOT NULL DEFAULT '0',
		       `start_time` time NOT NULL DEFAULT '00:00:00',
		       `end_time` time NOT NULL DEFAULT '00:00:00',
		       `c_time` int(10) NOT NULL DEFAULT '0',
		       `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		       `escalation_manager` varchar(80) DEFAULT NULL,
		       PRIMARY KEY (`timezone_id`),
		       UNIQUE KEY `assignee_id` (`assigneetime_id`)
		     ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		
CREATE TABLE opencal.`calendarLock` (
		  `lock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` int(10) NOT NULL DEFAULT '0',
		  `calendar_type` char(1) NOT NULL DEFAULT '',
		  `m_time` int(10) NOT NULL DEFAULT '0',
		  `is_finished` char(1) NOT NULL DEFAULT 'N',
		  PRIMARY KEY (`lock_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		
CREATE TABLE opencal.`oncallConfig_log_2012` (
		  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `user_id` int(10) NOT NULL DEFAULT '0',
		  `calendar_type` varchar(20) NOT NULL DEFAULT '',
		  `change_log` longtext,
		  `m_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `is_update` char(1) NOT NULL DEFAULT 'N',
		  PRIMARY KEY (`log_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		
		
CREATE TABLE opencal.`team` (
		`team_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		`team_name` varchar(64) NOT NULL DEFAULT '',
		`description` varchar(128) NOT NULL DEFAULT '',
		`user_ilist` varchar(64) NOT NULL DEFAULT '',
		`admin_ilist` varchar(64) NOT NULL DEFAULT '',
		PRIMARY KEY (`team_id`)
	       ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Insert Required informations*/
INSERT INTO opencal.`user` (`username`, `name`, `email`, `password`) VALUES('admin', 'admin', 'admin@yahoo-inc.com', 'f9d4049dd6a4dc35d40e5265954b2a46');
INSERT INTO opencal.`groupUser` (`name`, `description`) VALUES('admin', 'admin group');
INSERT INTO opencal.`groupUser_user` (`gu_id`, `user_id`, `is_admin`) VALUES(1001, 100001, 1);
insert into opencal.dictionary values(16, 'US', 'United State', 'US', 590,0 );
insert into opencal.dictionary values(17, 'IN', 'India', 'IN', 590,1 );
insert into opencal.dictionary values(20, 'userGroupType', 'User Group Type', 'UGT', 0,2 );
insert into opencal.dictionary values(62, 'userGroupType_ilist', 'ilist user groups', 'ilist' ,20,3);
insert into opencal.dictionary values(590, 'timezone', 'timezone for subnets', 'timezone', 94, 4);

/* Grant Permission */
GRANT SELECT ON opencal.* TO 'readonly'@'127.0.0.1' IDENTIFIED BY 'readonly';
GRANT SELECT ON opencal.* TO 'oncall_ro'@'127.0.0.1' IDENTIFIED BY 'on1406call';
GRANT ALL PRIVILEGES ON opencal.* TO 'oncall_rw'@'127.0.0.1' IDENTIFIED BY 'on1406call';

