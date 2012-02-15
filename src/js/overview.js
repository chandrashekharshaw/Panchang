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
var objOverview = function(paction,oby,dest_div,limit,sdir) { //,drill_down) {
 var drillDownContent = function(recs,arr_cols,trname,tmp_strip,link,param,param_data) {
       var tbl_data = Array();
       var j = 0;
       var tmp_trname = "tr_"+trname;
       for(var i=0 ;i<recs.length;i++) {
              var tr_name = tmp_trname+"_"+i;
              var data = recs[i];
              tbl_data[j++] = "<tr "+tmp_strip+" id='"+tr_name+"'>";
              for(var k=0;k<arr_cols.length;k++) {
                     var column = arr_cols[k];
                     var td_align = (data.name=='Total')?" class='summary_title'":'';
                           td_align += (column=='name')?" align='left'":" align='right'";
                     tbl_data[j++] = "<td "+td_align+">";
		      if(param=='filer_version') {
			if(column == link) {
				if(data.vendor=='Netapp') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else if (data.vendor=='HNAS') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=hnas.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else if (data.vendor=='EMC') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=emc.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				}
			} else {
				tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data[column];
			}
		      } else if (param=='site_id') {
			if(column == link) {
				if(data[column] == 'Corp Sites') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else if (data[column]!='Total' && data.vendor=='Netapp') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else if (data[column]!='Total' && data.vendor=='HNAS') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=hnas.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"("+data.vendor+")</a>";
				} else if (data[column]!='Total' && data.vendor=='EMC') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=emc.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"("+data.vendor+")</a>";
				} else if (data[column]!='Total') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				} else {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data[column];
				}
			} else {
				tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data[column];
			}
		      } else {
			if(column == link) {
				if (data[column]!='Total' && data.vendor=='Netapp') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data.vendor+"</a>";
				} else if (data[column]!='Total' && data.vendor=='HNAS') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=hnas.php?"+param+"="+data[param_data]+" class='href_black'>"+data.vendor+"</a>";
				} else if (data[column]!='Total' && data.vendor=='EMC') {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=emc.php?"+param+"="+data[param_data]+" class='href_black'>"+data.vendor+"</a>";
				} else {
					tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data.vendor+"</a>";
				}
			} else {
				tbl_data[j++] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+data[column];
			}
		      }
                     tbl_data[j++] = "</td>";
              }
              tbl_data[j++] = "</tr>";
       }
       var content = tbl_data.join('');
       return content;
 };
 var formatData = function(jsonData) {
       var caption  = jsonData.caption;
       var arr_titles = caption.split(",");
       var sort_cols = jsonData.scols;
       var arr_scols = sort_cols.split(",");
       var cols = jsonData.cols;
       var arr_cols = cols.split(",");
       var recs = jsonData.data;
       var tbl_data = Array();
       var param = jsonData.param;//param to use in url
       var param_data = jsonData.param_data; //get actual data to attach with url
       var link = jsonData.link; //column to use for add link
       var j=0;
       var i = 0;
       var k = 0;
       var column = "";
       var span_id = "";
       var td_align = "";
       var col_length = arr_cols.length;
       tbl_data[j++] = "<table border='0' cellspacing='1' cellpadding='1' width='100%'>";
       tbl_data[j++] = "<tr class='tbl_head'>";
       for(i=0;i<arr_titles.length;i++) {
              caption = arr_titles[i];
              column = arr_cols[i];
              span_id = "sort_"+column;
              td_align = (column=='name')?" align='left'":" align='right'";
              if(column==oby) {
                    var img = sdir==1?"./images/sort_up.gif":"./images/sort_down.gif";
                    caption = caption+"&nbsp;"+"<img src='"+img+"' border=0>";
              }
              var new_dir = (sdir==-1)?1:-1;
              tbl_data[j++] = "<td class='ov_title' "+td_align+">";
              tbl_data[j++] = "<span id='"+span_id+"'";
              for(k=0;k<arr_scols.length;k++) {
                    if(column == arr_scols[k]) {
                         tbl_data[j++] = "onClick=\"javascript:objOverview('"+paction+"','"+column+"','"+dest_div+"','"+limit+"','"+new_dir+"')\"";
                    }
              }
	      tbl_data[j++] = ">"+caption+"</span>";
	      tbl_data[j++] = "</td>";    
       }
       tbl_data[j++]="</tr>";
       tbl_data[j++] = "<tbody>";
       for(i=0 ;i<recs.length;i++) {
              var data = recs[i];
              var sub_recs = data.details;
              var drill_down = 0;
              var sub_len = 0;
              var curr_class = '';
               if(sub_recs!==undefined && sub_recs.length>0) {
                     //alert(sub_recs);
                     drill_down = 1;
                     sub_len = sub_recs.length;
              }
              if(i%2===0) {
                     curr_class = " class = 'ov_strip hide'";
                     tbl_data[j++] = "<tr class='ov_strip'>";
              } else {
                     curr_class = " class = 'ov_alt_strip hide'";
                     tbl_data[j++] = "<tr class='ov_alt_strip'>";       
              }
              var tr_name = '';
              for(k=0;k<arr_cols.length;k++) {
                      if(drill_down == 1) {
                            tr_name = data.name;
                            tr_name = tr_name.replace(".","_");
                            tr_name = tr_name.replace(" ","_");
                      }
                     column = arr_cols[k];
                     td_align = (data.name=='Total')?" class='summary_title'":'';
                           td_align += (column=='name')?" align='left'":" align='right'";
                     tbl_data[j++] = "<td "+td_align+">";
                     if(column=='name' && drill_down==1) {
                            var act = " onClick=showDrillDownData('"+tr_name+"',"+sub_len+") ";
                            var img_id = "img_"+tr_name;
                           tbl_data[j++] = "<span "+act+"><img id='"+img_id+"' src='./images/play_arrow.png' alt='drill down' border=0></span>&nbsp;"+data[column]; 
                     } else {
                            if(column == link && data[column]!='Total' && data.vendor=='Netapp') {
                                    tbl_data[j++] = "&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
                            } else if(column == link && data[column]!='Total' && data.vendor=='HNAS') {
			    	if(param == 'site_id' || param == 'prop_id') {
			    	    tbl_data[j++] = "&nbsp;&nbsp;<a href=hnas.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"  ("+data.vendor+")</a>";
				} else {
			    	    tbl_data[j++] = "&nbsp;&nbsp;<a href=hnas.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				}
                            } else if(column == link && data[column]!='Total' && data.vendor=='EMC') {
			    	if(param == 'site_id' || param == 'prop_id') {
			    	    tbl_data[j++] = "&nbsp;&nbsp;<a href=emc.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"  ("+data.vendor+")</a>";
				} else { 
			    	    tbl_data[j++] = "&nbsp;&nbsp;<a href=emc.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
				}
                            } else if(column == link && data[column]!='Total') {
                                    tbl_data[j++] = "&nbsp;&nbsp;<a href=storage_filers.php?"+param+"="+data[param_data]+" class='href_black'>"+data[column]+"</a>";
			    } else {
                                   tbl_data[j++] = "&nbsp;&nbsp;"+data[column];
                            }
                     }
                     tbl_data[j++] = "</td>";
              }
              tbl_data[j++] = "</tr>";
              if(drill_down == 1) {
                   tr_name = data.name;
                   tr_name = tr_name.replace(".","_");
                   tr_name = tr_name.replace(" ","_");
                   tbl_data[j++] = drillDownContent(sub_recs,arr_cols,tr_name,curr_class,link,param,param_data);
              }
       }
       if(limit==1 || limit==0) {
                     var lc_caption = limit==1?'&lt;&lt;less':'more&gt;&gt;';
                     var lc_class = limit==1?'href_notice':'href_green';
                     limit = 1-parseInt(limit, 10);
                     tbl_data[j++] = "<tr><td colspan='"+col_length+"' align=right><a class='"+lc_class+"' href=\"javascript:objOverview('"+paction+"','"+oby+"','"+dest_div+"','"+limit+"','"+sdir+"')\">"+lc_caption+"</td></tr>";
       }       
       tbl_data[j++] = "</tbody>";
       tbl_data[j++] = "</table>";
       var content = tbl_data.join('');
       return content;
 };
 
 var callbacks = {
        success : function (o) {
              try {
                var messages = YAHOO.lang.JSON.parse(o.responseText);
                var content = formatData(messages);
                var div = document.getElementById(dest_div);
                div.innerHTML = content;
            }
            catch (x) {
              alert(x);
             }
        },
        failure : function (o) {
            if (!YAHOO.util.Connect.isCallInProgress(o)) {
                alert("Async call failed!");
            }
        },
        timeout : 3000
    };
 var url = "./overview.php?action="+paction+"&order_by="+oby+"&showall="+limit+"&sdir="+sdir;
 YAHOO.util.Connect.asyncRequest('GET', url, callbacks);
};

var showDrillDownData = function(tr_name,len) {
       var img_id = "img_"+tr_name;
       tr_name = "tr_"+tr_name;
       var img_opt = document.getElementById(img_id).src;
       var curr_class = 'hide';
       var new_class = 'show';
       if(/play/.test(img_opt)) {
           document.getElementById(img_id).src = './images/down_arrow.png';
       } else {
            document.getElementById(img_id).src = './images/play_arrow.png';
            curr_class = 'show';
            new_class = 'hide';
       }
       for(var i=0;i<len;i++) {
              var new_tr_name = tr_name+"_"+i;
              var classname = document.getElementById(new_tr_name).className;
              if(/hide/.test(classname)) {
                     classname = classname.replace('hide','show');
              } else {
                     classname = classname.replace('show','hide');
              }       
              document.getElementById(new_tr_name).className = classname;
       }
};
