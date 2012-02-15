// JavaScript Document
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

var agt=navigator.userAgent.toLowerCase();
function resizeTextArea(t) {
	var a = t.value.split('\n');
	var b=1;
	var x=0;
	for (x=0;x < a.length; x++) {
	 if (a[x].length >= t.cols) { 
	 	b+= Math.floor(a[x].length/t.cols);
	 }
	}
	b+= a.length;
	if (b > t.rows && agt.indexOf('opera') == -1) {
		t.rows = b;
	}
	
}
