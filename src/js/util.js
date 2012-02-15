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

function isValidEmail(email) {
  var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (filter.test(email)) { return true; }
  else { return false; }
}

function trim(inputString) {
  if (typeof inputString != "string") { return inputString; }
  var retValue = inputString.replace(/^\s+|\s+$/g,"");
  var ch = retValue.substring(0, 1);
  while (ch == " ") {
    retValue = retValue.substring(1, retValue.length);
    ch = retValue.substring(0, 1);
  }
  ch = retValue.substring(retValue.length-1, retValue.length);
  while (ch == " ") {
    retValue = retValue.substring(0, retValue.length-1);
    ch = retValue.substring(retValue.length-1, retValue.length);
  }
  while (retValue.indexOf("  ") != -1) {
    retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length);
  }
  return retValue;
}

function unblur() {
  this.blur();
}

function removeFocus() {
  var links = document.getElementsByTagName("a");
  var i = 0;
  for(i = 0; i < links.length; i++) {
    links[i].onfocus = unblur;
  }
}

function checkAll(theForm, cName, controller) {
  var i = 0;
  var n = 0;
  for (i = 0, n = theForm.elements.length; i < n; i++) {
    if (theForm.elements[i].className.indexOf(cName) != -1) {
      if (theForm.elements[i].checked == true && !theForm.elements[i].disabled) {
        theForm.elements[i].checked = controller.checked = false;
      } else {
        if (!theForm.elements[i].disabled) {
          theForm.elements[i].checked = controller.checked = true;
        }
      }
    }
  }
}

var popup_window;
// {{{ openPopup()
function openPopup(url, width, height) {
  var x=(640-width)/2; var y=(480-height)/2;
  if (screen) {
    y=(screen.availHeight-height)/2;
    x=(screen.availWidth-width)/2;
  }
  if (screen.availWidth>1800) {
    x=((screen.availWidth/2)-width)/2;
  }
  popup_window = window.open(url,'newopenPopup','width='+width+',height='+
  height+',screenX='+x+',screenY='+y+',top='+y+',left='+x+',scrollbars=yes,resizable=yes,status=yes');

  //popup_window.focus();
}
function openNamedPopup(url, width, height, in_name, in_focus) {
  var x=(640-width)/2; var y=(480-height)/2;
  if (screen) {
    y=(screen.availHeight-height)/2;
    x=(screen.availWidth-width)/2;
  }
  if (screen.availWidth>1800) {
    x=((screen.availWidth/2)-width)/2;
  }
  var pwin = window.open(url,in_name,'width='+width+',height='+
    height+',screenX='+x+',screenY='+y+',top='+y+',left='+x+',scrollbars=yes,resizable=yes,status=yes');
  if(in_focus) {
    pwin.focus();
  }
}
// }}}

function getSelected(id) {
  var sel_index = document.getElementById(id).selectedIndex;
  var sel_val   = document.getElementById(id).options[sel_index].value;
  return sel_val;
}

function get_mouse(e) {
  if (document.all) {
    document.getElementById("popup").style.left = event.x - 2;
    document.getElementById("popup").style.top  = event.y + 23;
  } else if (!document.all && document.getElementById) {
    document.getElementById("popup").style.left = e.pageX - 2;
    document.getElementById("popup").style.top  = e.pageY + 25;
  }
}

function pop(msg, id) {
  var content =
    '<table border="0" cellspacing="0" cellpadding="1">' +
    '<tr><td align="center" valign="middle" bgcolor="#000000">' +
    '<table border="0" cellspacing="0" cellpadding="2">' +
    '<tr><td bgcolor="#FFFFE1">&nbsp;' + msg + '&nbsp; </td>' +
    '</tr></table></td></tr></table>';
  var element_id = 'popup';
  if(id) {
    element_id = id;
  }
  document.getElementById(element_id).innerHTML = content;
  document.getElementById(element_id).style.visibility="visible";
}

function off(id) {
  var content = "";
  var element_id = 'popup';
  if(id) {
    element_id = id;
  }
  document.getElementById(element_id).innerHTML = content;
  document.getElementById(element_id).style.visibility="hidden";
}

function isNumeric(input) {
  input = trim(input);
  if (input.length == 0) {
    return false;
  }
  var i = 0;
  var validChars = "0123456789";
  var isNumber = true;
  for (i = 0; i < input.length && isNumber == true; i++) {
    if (validChars.indexOf(input.charAt(i)) == -1) {
      isNumber = false;
    }
  }
  return isNumber;
}

function makeVisible(id) {
  if (document.layers) {
    document.getElementById(id).visibility = 'show';
    document.getElementById(id).display = 'block';
  } else {
    document.getElementById(id).style.visibility = 'visible';
    document.getElementById(id).style.display = 'block';
  }
}

function makeInvisible(id) {
  if (document.layers) {
    document.getElementById(id).visibility = 'hide';
    document.getElementById(id).display = 'none';
  } else {
    document.getElementById(id).style.visibility = 'hidden';
    document.getElementById(id).style.display = 'none';
  }
}

function changeSrc(id, src){
		document.getElementById(id).src = src;
}

// A lot like the print_r for php
function print_r(theObj){
  if(theObj.constructor == Array ||
     theObj.constructor == Object){
    document.write("<ul>");
    for(var p in theObj){
      if(theObj[p].constructor == Array||
         theObj[p].constructor == Object){
        document.write("<li>["+p+"] => "+typeof(theObj)+"</li>");
        document.write("<ul>");
        print_r(theObj[p]);
        document.write("</ul>");
      } else {
        document.write("<li>["+p+"] => "+theObj[p]+"</li>");
      }
    }
    document.write("</ul>");
  }
}


function groupNodes(url) {
    var serialized = "";
      var is_checked = false;
      var i = 0;
      var n = 0;
      var curr_element = "";
        for (i = 0, n = nodefinder.elements.length; i < n; i++) {
              curr_element = document.nodefinder.elements[i];
                  if (curr_element.name == 'nodeid[]' && curr_element.checked) {
                          serialized += curr_element.value + "|";
                                is_checked = true;
                                    }
                    }
          serialized = serialized.substring(0, (serialized.length-1));
            if (is_checked) {
                  openPopup(url + "?ids=" + serialized, 700, 450);
                    } else {
                          alert("Please select at least one node!");
                            }
}

function XHttpObject(url,callbackfun,id) {
var xhr;
var arr_msxml=Array('MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP','Microsoft.XMLHTTP');
try {
   // Firefox, Opera 8.0+, Safari
   xhr = new XMLHttpRequest();
}
catch (e) {
	try {
	     //IE 7 
	     xhr = new XMLHttpRequest();
	}
	catch (e) {
	    for(obj in arr_msxml){
	        try {
		     xhr = new ActiveXObject(arr_msxml[obj]);
	     }
	     catch (e) { }
	}
	}
}
if(xhr) {
	xhr.open('GET',url,true);
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4) {
			callbackfun(xhr.responseXML,id);
		}
	};
	xhr.send(null);
} else {
	alert("Unable to initiate XMLHttpRequest! Unsupport Browser!");
}
}

function updateVollist(xmlResponse,id) {
   var trid = "trfiler"+id; 
   var imgid = "imgfiler" + id;
   var tdid = "tdfiler"+id;
    var xmldoc = xmlResponse.documentElement;

    var xmlmeta = xmldoc.getElementsByTagName("columns");
    var hostid = xmlmeta[0].getAttribute("host_id");
    var is_admin = xmlmeta[0].getAttribute("is_admin");
    var host = xmlmeta[0].getAttribute("hostname");

    var xmlColumns = xmldoc.getElementsByTagName("col");
    var xmlavols = xmldoc.getElementsByTagName("aname");
    var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='0'><thead><tr height=20>";
    for(var i=0;i<xmlColumns.length;i++) {
      var caption = xmlColumns[i].getAttribute("caption");
      var cdir = xmlColumns[i].getAttribute("dir");
      var simg = xmlColumns[i].getAttribute("showdir");
      var column = xmlColumns[i].firstChild.data;
      var img = ((simg == -1)?'':(simg==1?"./images/sort_up.gif":"./images/sort_down.gif"));
        var src = '';
          if(img!='') {
          src = "<img src='"+img+"' border=0>";
          }
          var align="right";
          var width = "100";
          if(column == 'name') {
              align="left";
              width= "150";
          }
      tbl = tbl + "<td nowrap align='"+align+"' width='"+width+"'><span>"+caption+"</span></td>";
    }
    tbl = tbl + "</tr></thead><tbody>";
    for(var j=0;j<xmlavols.length;j++) {
      tbl = tbl + "<tr height=20 bgcolor=\"#F7F7F7\" onMouseOver=\"this.style.backgroundColor='#D0D0D0';\" onMouseOut=\"this.style.backgroundColor='#f7f7f7';\">";
      var xmlname = xmlavols[j].getElementsByTagName("volname");
      var vname = xmlavols[j].getAttribute("name");
      var total = xmlavols[j].getAttribute("total");
      var used = xmlavols[j].getAttribute("used");
      var percent = xmlavols[j].getAttribute("percent");
      var lbackup1 = '';
      var lbackup = '';
      lbackup = xmlavols[j].getAttribute("lbackup");
      var hbackupr = xmlavols[j].getAttribute("hbackupr");
      var rbackup = xmlavols[j].getAttribute("rbackup");
      var path =  xmlavols[j].getAttribute("path");
      var xmlack = xmlavols[j].getElementsByTagName("ackdetails");
      var ackdetail = xmlack[0].firstChild.data;
      var ackby = xmlack[0].getAttribute("ackby");
      var ackdt = xmlack[0].getAttribute("ackdate");

      var tr_id = "tr_id_"+id;
      var alink = '--';
      if(lbackup != '--') {
        var frmts = xmlavols[j].getAttribute("from_ts");
        var tots = xmlavols[j].getAttribute("to_ts");
        alink = "./backup_search.php?list_view=job&search="+host+"&backup_path="+path+"&from_ts="+frmts+"&to_ts="+tots+"&order_by=end_time&direction=desc";
        alink = "<a href='"+alink+"' target=_blank>"+lbackup+"</a>";
      } 
      var snapmirror = '';
      var acklink = "<td>&nbsp;</td>";
      if(is_admin == 1) {
        var link = "llink"+hostid+j;
        acklink = "<td align=right>&nbsp;<a id='"+link+"' href=\"#\" onclick=\"javascript:addLog('"+link+"',"+hostid+",'"+vname+"'); return false;\">";
        acklink = acklink + "<img src='images/icons/icon_edit.gif' border=0 title='Acknowledgement'></a>&nbsp;";
        if(ackdetail != '--') {   
           var ack_desc = "<b>ACK_BY:</b>"+ackby+"<br><b>ACK_DET:</b>"+ackdetail+"<br><b>ACK_DATE:</b>"+ackdt;
           acklink = acklink + "<img id='ack"+hostid+"' src='images/icons/icon_verified.gif' title='"+ack_desc+"'>";
           acklink = acklink + "<script type='text/javascript'>";
           acklink = acklink + " var tooltip"+hostid+" = new YAHOO.widget.Tooltip('tooltip"+hostid+"',{context:'ack"+hostid+"',autoDismissDelay:30000});</script>";
        }
        acklink = acklink + "</td>";
      }

      if(vname.indexOf('snapshot')==-1) {
      var svname = vname.replace(/\/vol\//,'');
      svname = svname.replace(/\//,'');
      snapmirror = "./storage_snapmirror_vols.php?any_vol="+svname+"&any_name="+host+"&btnSubmit=Search";
      snapmirror = "<a href='"+snapmirror+"'><img src='./images/icons/server_link.png' border=0></a>";

      }



      tbl = tbl + "<td align=left width=150>"+vname+"&nbsp;"+snapmirror+"</td><td align=right width='100'>"+total+"</td><td align=right width='100'>"+used+"</td><td width='100' align=right>"+percent+"</td><td align=right>"+(hbackupr == 'Yes'?"<span class='text_green'>Yes</span>":hbackupr)+"</td><td align=right>"+rbackup+"</td><td align=right>"+alink+"</td>"+acklink;
      tbl = tbl + "</tr>";
      for(var k=0;k<xmlname.length;k++) {
      var ackdetail1 = xmlname[k].firstChild.data;  
      var vname1 = xmlname[k].getAttribute("name");
      if(vname1 == null) {
       vname1 = xmlname[k].firstChild.data;
      }
      var total1 = xmlname[k].getAttribute("total");
      var used1 = xmlname[k].getAttribute("used");
      var hbackupr1 = "";
      var rbackup1 = "";
      var percent1 = "";
      var path1 = "";
      var ackby1 = "";
      var ackdt1 = "";
      if(vname1 !='Summary') {
      lbackup1 = xmlname[k].getAttribute("lbackup");
      hbackupr1 = xmlname[k].getAttribute("hbackupr");
      rbackup1 = xmlname[k].getAttribute("rbackup");
      percent1 = xmlname[k].getAttribute("percent");
      path1 =  xmlname[k].getAttribute("path");
      ackby1 = xmlname[k].getAttribute("ackby");
      ackdt1 = xmlname[k].getAttribute("ackdate");
      }

      var url1 = '--';
      if(lbackup1!='--') {
        var frmts1 = xmlname[k].getAttribute("from_ts");
        var tots1 = xmlname[k].getAttribute("to_ts");
        url1 = "./backup_search.php?list_view=job&search="+host+"&backup_path="+path1+"&from_ts="+frmts1+"&to_ts="+tots1+"&order_by=end_time&direction=desc";
        url1 = "<a href='"+url1+"' target=_blank>"+lbackup1+"</a>";

      }

      var classname = '';
        if(vname1 == 'Summary') {
        tbl = tbl + "<tr height=20 bgcolor=\"#F7F7F7\" onMouseOver=\"this.style.backgroundColor='#D0D0D0';\" onMouseOut=\"this.style.backgroundColor='#f7f7f7';\"><td align=left width=150 class=title>&nbsp;&nbsp;&nbsp;&nbsp;"+vname1+"</td><td align=right width='100' class='title'>"+total1+"</td><td align=right width='100' class='title'>"+used1+"</td><td colspan=5>&nbsp;</td></tr>";
      } else { 
        var snapmirror1 = '';
      var acklink1 = "<td>&nbsp;</td>";

      if(vname1.indexOf('snapshot')==-1) {
      var svname1 = vname1.replace(/\/vol\//,'');
      svname1 = svname1.replace(/\//,'');
      snapmirror1 = "./storage_snapmirror_vols.php?any_vol="+svname1+"&any_name="+host+"&btnSubmit=Search";
      snapmirror1 = "<a href='"+snapmirror1+"'><img src='./images/icons/server_link.png' border=0></a>";


      }
      if(is_admin == 1) {
        var link1 = "llink"+hostid+j;
        acklink1 = "<td align=right>&nbsp;<a id='"+link1+"' href=\"#\" onclick=\"javascript:addLog('"+link1+"',"+hostid+",'"+vname1+"'); return false;\">";
        acklink1 = acklink1 + "<img src='images/icons/icon_edit.gif' border=0 title='Acknowledgement'></a>&nbsp;";
        if(ackdetail1 != '--') {   
           var ack_desc1 = "<b>ACK_BY:</b>"+ackby1+"<br><b>ACK_DET:</b>"+ackdetail1+"<br><b>ACK_DATE:</b>"+ackdt1;
           acklink1 = acklink1 + "<img id='ack"+hostid+"' src='images/icons/icon_verified.gif' title='"+ack_desc1+"'>";
           acklink1 = acklink1 + "<script type='text/javascript'>";
           acklink1 = acklink1 + " var tooltip"+hostid+" = new YAHOO.widget.Tooltip('tooltip"+hostid+"',{context:'ack"+hostid+"',autoDismissDelay:30000});</script>";
        }
        acklink1 = acklink1 + "</td>";
      }
       tbl = tbl + "<tr height=20 bgcolor=\"#F7F7F7\" onMouseOver=\"this.style.backgroundColor='#D0D0D0';\" onMouseOut=\"this.style.backgroundColor='#f7f7f7';\"><td align=left width=150>&nbsp;&nbsp;&nbsp;&nbsp;"+vname1+"&nbsp;"+snapmirror1+"</td><td align=right width='100'>"+total1+"</td><td align=right width='100'>"+used1+"</td><td width='100' align=right>"+percent1+"</td><td align=right>"+(hbackupr1 == 'Yes'?"<span class='text_green'>Yes</span>":hbackupr1)+"</td><td align=right>"+rbackup1+"</td><td align=right>"+url1+"</td>"+acklink1+"</tr>";
      }
      }
    }
    tbl = tbl + "</tbody></table>";
    document.getElementById(tdid).innerHTML = '';
    document.getElementById(tdid).innerHTML = tbl;
    var imgsrc = document.getElementById(imgid).src;
    if(/_loading/i.test(imgsrc)) {
      document.getElementById(imgid).src = 'images/icons/icon_minus.gif';
    } 
}



function updateVolumes(xmlResponse,id) {
   var imgid = "img_" + id;
   var tdid = "td_"+id;
    var xmldoc = xmlResponse.documentElement;
    var xmlColumns = xmldoc.getElementsByTagName("col");
    var xmlavols = xmldoc.getElementsByTagName("aname");
//    var xmlTot = xmldoc.getElementsByTagName("total");
    var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='0'><thead><tr height=20>";
    for(var i=0;i<xmlColumns.length;i++) {
      var caption = xmlColumns[i].getAttribute("caption");
      var cdir = xmlColumns[i].getAttribute("dir");
      var simg = xmlColumns[i].getAttribute("showdir");
      var column = xmlColumns[i].firstChild.data;
      var img = ((simg == -1)?'':(simg==1?"./images/sort_up.gif":"./images/sort_down.gif"));
        var src = '';
          if(img!='') {
          src = "<img src='"+img+"' border=0>";
          }
          var align="right";
          var width = "100";
          if(column == 'name') {
              align="left";
              width= "150";
          }
      tbl = tbl + "<td nowrap align='"+align+"' width='"+width+"'><span onClick=\"javascript:showFilerAggrs('"+id+"','"+column+"','"+cdir+"','"+id+"')\">"+caption+"&nbsp;"+src+"</span></td>";
    }
    tbl = tbl + "</tr></thead><tbody>";
    for(var j=0;j<xmlavols.length;j++) {
      tbl = tbl + "<tr class=\"result\" height=20>";
      var xmlname = xmlavols[j].getElementsByTagName("volname");
      var vname = xmlavols[j].getAttribute("name");
      var total = xmlavols[j].getAttribute("total");
      var used = xmlavols[j].getAttribute("used");
      var avil = xmlavols[j].getAttribute("avil");
      var vname1 = "";

      var tr_id = "tr_id_"+id;
      tbl = tbl + "<td align=left width=150>"+vname+"</td><td align=right width='100'>"+total+"</td><td align=right width='100'>"+used+"</td><td width='100' align=right>"+avil+"</td>";
      tbl = tbl + "</tr>";
      for(var k=0;k<xmlname.length;k++) {
        var vtotal = xmlname[k].getAttribute("total");
        var vused = xmlname[k].getAttribute("used");
        var vavil = xmlname[k].getAttribute("avil");
        vname1 = xmlname[k].firstChild.data;  
        var classname = '';
        if(vname1 == 'Summary') {
          classname = 'title';
        } 
          
        tbl = tbl + "<tr class=result height=20 width=150><td class='"+classname+"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+vname1+"</td><td align=right width=100 class='"+classname+"'>"+vtotal+"</td><td align=right width=100 class='"+classname+"'>"+vused+"</td><td align=right width=100 class='"+classname+"'>"+vavil+"</td></tr>";
      }
    }
    tbl = tbl + "</tbody></table>";
    document.getElementById(tdid).innerHTML = '';
    document.getElementById(tdid).innerHTML = tbl;
    var imgsrc = document.getElementById(imgid).src;
    if(/_loading/i.test(imgsrc)) {
      document.getElementById(imgid).src = 'images/icons/icon_minus.gif';
    } 
}

function showFilerAggrs(nodeid,scolumn,sdir) {
  var url = "./storage_share_filers.php?hostid=" + nodeid +"&ajax_call=true";
  url = url + "&scolumn="+scolumn+"&sdir="+sdir;
  var imgid = "img_" + nodeid;
  var tdid = "td_" + nodeid;
  var trid = "tr_" + nodeid;
  
  var imgsrc = document.getElementById(imgid).src;
  if(/_plus.gif/i.test(imgsrc)) {
               document.getElementById(trid).className = 'show';
               document.getElementById(imgid).src = 'images/icons/icon_loading.gif';
               XHttpObject(url,updateVolumes,nodeid);
  } else {
            document.getElementById(trid).className = 'hide';
            document.getElementById(imgid).src = 'images/icons/icon_plus.gif';

  }
}


function AppendIntoList(thisfrm,basediv) {
var doc = '';
var arr_list = Array();
var obj = eval("document." + thisfrm);
var is_checked = false;
var int_i = 0;
var i = 0;
var n = 0;
var curr_element = "";
for(i = 0,n = obj.elements.length; i < n;i++) { 
curr_element = obj.elements[i];
 if (curr_element.name == 'listids[]' && curr_element.checked) {
  arr_list[int_i++] = curr_element.value;
 }
}

var tblname = "tbl_" + basediv;
var tblbname = "tbody_" + basediv;
var tblctrl = window.opener.document.getElementById(tblname);
var append_to_parent = false;
var tbl = '';
var tbl_exist = "";
if (tblctrl) { 
var  tbody = tblctrl;
    tbl_exist = "<table border=0 cellspacing=1 cellpadding=3 bgcolor='#EEEEEE' width=250 id='"+tblname+"'>"; 
    tbl_exist += "<tbody id='"+tblbname+"'>";
}
else {
    append_to_parent = true;
    tbl = "<table border=0 cellspacing=1 cellpadding=3 bgcolor='#EEEEEE' width=250 id='"+tblname+"'>"; 
    tbl += "<tbody id='"+tblbname+"'>";
}
var txtbxName = "txt" + basediv +"[]";
for(var re in arr_list) {
  var rec = arr_list[re].split("|");
  var trdiv = ("div" + basediv + "id"+rec[0]); 
  if (opener.document.getElementById(trdiv)) {
    continue;
  }
  tbl = tbl + "<tr id='"+trdiv+"' onMouseOver=\"this.style.backgroundColor='#F7F7F7';\" onMouseOut=\"this.style.backgroundColor='#EEEEEE';\">";
  tbl = tbl + "<td><input type=hidden name='"+txtbxName+"' id='"+txtbxName+"' value='"+rec[0]+"'></td>";
  for(var col in rec) {
      tbl = tbl + "<td>"+rec[col]+"</td>";
  }
  tbl = tbl + "<td align=center><img src='./images/delete.png' onClick=\"removeRow('"+trdiv+"')\"></td>";
  tbl = tbl + "</tr>";
}

if(append_to_parent) {
tbl = tbl + "</tbody></table>";
window.opener.document.getElementById(basediv).innerHTML=tbl;
}
else {
  tbl_exist = tbl_exist +  window.opener.document.getElementById(tblbname).innerHTML + tbl;
  tbl_exist = tbl_exist + "</tbody></table>";
window.opener.document.getElementById(basediv).innerHTML ='';
window.opener.document.getElementById(basediv).innerHTML= tbl_exist;
}
//this.window.close();
}

function updateOv(xmlResponse,id) {
    var xmldoc = xmlResponse.documentElement;
    var xmlColumns = xmldoc.getElementsByTagName("col");
    var xmlProps = xmldoc.getElementsByTagName("name");
    var xmlTot = xmldoc.getElementsByTagName("total");
    var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='3'><thead><tr>";
    var showAll = 0;
    for(var i=0;i<xmlColumns.length;i++) {
      var caption = xmlColumns[i].getAttribute("caption");
      var cdir = xmlColumns[i].getAttribute("dir");
      var simg = xmlColumns[i].getAttribute("showdir");
      showAll = xmlColumns[i].getAttribute("showAll");
      var column = xmlColumns[i].firstChild.data;
      var img = ((simg == -1)?'':(simg==1?"./images/sort_up.gif":"./images/sort_down.gif"));
        var src = '';
          if(img!='') {
          src = "<img src='"+img+"' border=0>";
          }
      tbl = tbl + "<td nowrap><span onClick=\"javascript:sortProp('"+column+"','"+cdir+"','"+id+"','"+showAll+"')\">"+caption+"&nbsp;"+src+"</span></td>";

     }
    tbl = tbl + "</tr></thead><tbody>";
    var prop_count = xmlProps.length;
    for(var j=0;j<xmlProps.length;j++) {
      tbl = tbl + "<tr class=\"result\">";
      var pname = xmlProps[j].firstChild.data;
      var filers = xmlProps[j].getAttribute("filer_count");
      var space_total = xmlProps[j].getAttribute("space_total");
      var space_used = xmlProps[j].getAttribute("space_used");
      var percent = xmlProps[j].getAttribute("percent");
      var prop_id = xmlProps[j].getAttribute("prop_id");
      tbl = tbl + "<td align=left><a href='./storage_filers.php?prop_id="+prop_id+"'>"+pname+"</a></td><td align=right>"+filers+"</td><td align=right>"+space_total+"</td><td align=right>"+space_used+"</td><td align=right>"+percent+"</td>";
      tbl = tbl + "</tr>";
    }
    var tfilers = xmlTot[0].getAttribute("filers");
    var tspace = xmlTot[0].getAttribute("tspace");
    var uspace = xmlTot[0].getAttribute("uspace");
    var per = xmlTot[0].getAttribute("percent");
    var details_caption = "More&nbsp;&gt;&gt;";
    var showtype = 1;
    if(showAll == 1) {
    details_caption = "&lt;&lt;&nbsp;Less";
    showtype = 0;
    }
    tbl = tbl + "<tr class='result'><td align=right><strong>TOTAL:</strong></td><td align=right><strong>"+tfilers+"</strong></td><td align=right><strong>"+tspace+"</strong></td><td align=right><strong>"+uspace+"</strong></td><td align=right><strong>"+per+"</strong></td></tr>";
    tbl = tbl + "<tr><td colspan=5 align=right><a href=\"javascript:sortProp('space_total','0','div_ov_prop','"+showtype+"')\">"+details_caption+"</a></td></tr>";
    tbl = tbl + "</tbody></table>";
    var headid = "head_"+id;
    document.getElementById(headid).innerHTML = '';
    document.getElementById(headid).innerHTML = "PROPERTY Overview&nbsp;(Top&nbsp;"+prop_count+")";
    document.getElementById(id).innerHTML = '';
    document.getElementById(id).innerHTML = tbl;
}

function sortProp(colname,direc,id,showall) {
  var busy = "<img src='./images/busybar_1.gif' border=0>";
  document.getElementById(id).innerHTML = '';
  document.getElementById(id).innerHTML = busy;

  var url = "./storage_ov_ajax.php?ajax_call=true";
  url = url + "&colname="+colname+"&direc="+direc;
  url = url + "&showAll="+showall;
  XHttpObject(url,updateOv,id);
}

function showPercent(per) {
  var blen = 100;
 var tbl = '';
 if(per > 100) {
   per = 100;
 } else if(per < 0) {
   per = 0;
 }
 tbl = "<table cellpadding=0 cellspacing=1 border=0 bgcolor='#999999' width='"+blen+"'><tr>";
 if(per>0) {
   tbl = tbl + "<td width='"+per+"' bgcolor='#AAAAAA'>&nbsp;</td>";
 }
 if(per<100) {
   tbl = tbl + "<td bgcolor='#FFFFFF'>&nbsp;</td>";
 }
 tbl = tbl + "</tr></table>";

return tbl;
}

function updateVolumeList(xmlResponse,id) {
   var ctrl = 'arrow_'+id;
   var divid = "div_agr_"+id;
   var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='0'><tbody>";
    var xmldoc = xmlResponse.documentElement;
    var xmlmeta = xmldoc.getElementsByTagName("list");
    var recs = xmlmeta[0].getAttribute("recs");
    var hostid = xmlmeta[0].getAttribute("hostid");
    var is_admin = xmlmeta[0].getAttribute("is_admin");
    var host = xmlmeta[0].getAttribute("host");
    var xmlvols = xmlmeta[0].getElementsByTagName("vol");
    for(var j=0;j<xmlvols.length;j++) {
      var details = xmlvols[j].firstChild.data;
      var vname = xmlvols[j].getAttribute("vname");
      var threshold_percent = xmlvols[j].getAttribute("threshold_percent");
      var threshold_cc_to = xmlvols[j].getAttribute("threshold_cc_to");
      var vtype = "";
      var qvol = "";
      var per = "";
      var ack_date = "";
      var ack_by = "";
      var lmodified = "";
      if(vname != 'Summary'){ 
      vtype = xmlvols[j].getAttribute("type");
      qvol = xmlvols[j].getAttribute("qvol");
      per = xmlvols[j].getAttribute("per");
      host = xmlvols[j].getAttribute("host");
      ack_date = xmlvols[j].getAttribute("ack_date");
      ack_by = xmlvols[j].getAttribute("ack_by");
      lmodified = xmlvols[j].getAttribute("lmodified");
      }
      var vol_state = xmlvols[j].getAttribute("vol_state");
      var total = xmlvols[j].getAttribute("total");
      var used = xmlvols[j].getAttribute("used");
      var snapmirror = "./storage_snapmirror_vols.php?any_name="+host+"&btnSubmit=Search";
      var snapmirror_url = '';
      var drill = "&nbsp;";
      var qtree_tr = '';
      var qtree_div = '';
      if(vtype == 'volume') {
      tbl = tbl + "<tr bgcolor='#F7F7F7' height=20>";
      snapmirror_url = snapmirror + "&any_vol="+vname;
      snapmirror_url = "<a href=\"#\" onclick=\"window.opener.location='"+snapmirror_url+"';window.close();\"><img src='./images/icons/server_link.png' title='Snapmirror Info' border=0></a>";
      var img_id = "img_qtree_"+qvol+id;
      drill = "<span onClick=\"javascript:getQtreeList("+id+","+hostid+",'"+qvol+"')\"><img src='./images/play_arrow.png' border=0 id='"+img_id+"'></span>";
      qtree_tr = "qtree_tr_"+qvol+id;
      qtree_div = "qtree_div_"+qvol+id;
      } else {
      tbl = tbl + "<tr bgcolor='#FBFBFB' height=20>";
      }
      var tr_id = "tr_id_"+id;
      if(vname != 'Summary') {
      tbl = tbl + "<td width=10>"+drill+"</td><td align=left width=224>"+vname+"&nbsp;&nbsp;"+snapmirror_url+"</td><td width=100 align=center>"+vol_state+"</td><td width=77 align=right>&nbsp;"+total+"</td><td width=80 align=right>&nbsp;"+used+"</td><td width=195><table cellspacing=0 cellpadding=0 border=0 width=100%><tr><td>"+showPercent(per)+"</td><td align=right>&nbsp;"+per+"&nbsp;%&nbsp;</td></tr></table></td><td width=150>"+lmodified+"</td>";
      if(is_admin == 1) {
        var link = "llink"+hostid+j;
        tbl = tbl + "<td>&nbsp;<a id='"+link+"' href=\"#\" onclick=\"javascript:addVLog('"+link+"',"+hostid+",'"+vname+"'); return false;\">";
        tbl = tbl + "<img src='images/icons/icon_edit.gif' border=0 title='Acknowledgement'></a>&nbsp;";
        if(details != '--') {                                                                                                                        var ack_desc = "<b>ACK_BY:</b>"+ack_by+"<br><b>ACK_DET:</b>"+details+"<br><b>ACK_DATE:</b>"+ack_date;
           tbl = tbl + "<img id='ack"+hostid+"' src='images/icons/icon_verified.gif' title='"+ack_desc+"'>";
           tbl = tbl + "<script type='text/javascript'>";
           tbl = tbl + " var tooltip"+hostid+" = new YAHOO.widget.Tooltip('tooltip"+hostid+"',{context:'ack"+hostid+"',autoDismissDelay:30000});</script></td>";
        }
        var link_threshold = "link_threshold"+hostid+j;
        tbl = tbl + "<td>&nbsp;<a id='"+link_threshold+"' href=\"#\" onclick=\"javascript:addThreshold('"+link+"',"+hostid+",'"+vname+"','"+threshold_percent+"', '"+threshold_cc_to+"'); return false;\">";
        tbl = tbl + threshold_percent + "%</a>&nbsp;";
      }
      } else {
        tbl = tbl + "<td>&nbsp;</td><td class='title'>"+vname+"</td><td class=title align=right>"+total+"</td><td class=title align=right>"+used+"</td><td colspan=3>&nbsp;</td>";
      }
      tbl = tbl + "</tr>";
      if(vtype == 'volume') {
        tbl = tbl + "<tr id='"+qtree_tr+"' class='hide'><td>&nbsp;</td><td colspan=6 width=100%><div id='"+qtree_div+"'></div></td></tr>";
      }
      }
    if(recs == 0) {
      tbl = tbl + '<tr><td>No volume(s) found!</td></tr>';
    }
    tbl = tbl + "</tbody></table>";
    document.getElementById(divid).innerHTML = '';
    document.getElementById(divid).innerHTML = tbl;
    document.getElementById(ctrl).src = './images/icons/icon_minus.gif';
}

function getVolumesList(id,node,aname) {
 var ctrl = 'arrow_'+id;
 var trid = "tr_agr_" + id;
 var imgsrc = document.getElementById(ctrl).src ;
 if(/_plus.gif/i.test(imgsrc)) {
 document.getElementById(ctrl).src = './images/icons/icon_loading.gif';
 var url = "./storage_filer_details_ajax.php?hostid=" + node +"&aggr="+aname+"&ajax_call=true";
 document.getElementById(trid).className = 'show';
 XHttpObject(url,updateVolumeList,id,node);
 } else {
    document.getElementById(trid).className = 'hide';
    document.getElementById(ctrl).src = './images/icons/icon_plus.gif';
 }
}


function updateQtreeList(xmlResponse,id) {
    var xmldoc = xmlResponse.documentElement;
    var xmlColumns = xmldoc.getElementsByTagName("col");
    var xmllist = xmldoc.getElementsByTagName("list");
    var xmltrees = xmldoc.getElementsByTagName("tree");
    var recs = xmllist[0].getAttribute("recs");
    var hostid = xmllist[0].getAttribute("hostid");
    var vol = xmllist[0].getAttribute("vol");

    var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='1'><thead><tr><td width=5>&nbsp;</td>";
    var img_id = "";
    
    for(var i=0;i<xmlColumns.length;i++) {
      var caption = xmlColumns[i].firstChild.data;
      tbl = tbl + "<td nowrap><span>"+caption+"</span></td>";
     }
    tbl = tbl + "</tr></thead><tbody>";
    for(var j=0;j<xmltrees.length;j++) {
      var name = xmltrees[j].firstChild.data;
      var qtreeid = xmltrees[j].getAttribute("id");
      var style = xmltrees[j].getAttribute("style");
      var stat = xmltrees[j].getAttribute("status");
      var oplock = xmltrees[j].getAttribute("oplock");
      var volid = xmltrees[j].getAttribute("volid");
      var is_quota = xmltrees[j].getAttribute("is_quota_on");
     img_id = "quota_img_"+volid+qtreeid+id;
     var drill = "";
     if(is_quota == 1) {
      drill = "<span onClick=\"javascript:getQuota("+id+","+hostid+","+volid+","+qtreeid+",'"+name+"')\"><img src='./images/play_arrow.png' border=0 id='"+img_id+"'></span>";
     } else {
    	 drill = "<img src='./images/icons/icon_alert.gif' border=0 id='"+img_id+"' alt='Quota not enabled'>";
     }
      var quota_tr = "quota_tr_"+volid+qtreeid+id;
     var quota_div = "quota_div_"+volid+qtreeid+id;

      tbl = tbl + "<tr class='result'><td>"+drill+"</td><td><span>"+qtreeid+"</span></td><td><b>"+name+"</b></td><td>"+style+"</td><td>"+stat+"</td><td>"+oplock+"</td></tr>";
      tbl = tbl + "<tr id='"+quota_tr+"' class='hide'><td>&nbsp;</td><td colspan=5 width=100%><div id='"+quota_div+"'></div></td></tr>";
    }
   if(recs == 0) {
      tbl = tbl + '<tr height=20><td colspan=5 align=center>No Qtree(s) found!</td></tr>';
    }
    tbl = tbl + "</tbody></table>";

    var  qtree_div = "qtree_div_"+vol+id;
    document.getElementById(qtree_div).innerHTML = '';
    document.getElementById(qtree_div).innerHTML = tbl;
    img_id = "img_qtree_"+vol+id;
    document.getElementById(img_id).src = './images/down_arrow.png';
}

function getQtreeList(id,node,vname) {
 var  qtree_tr = "qtree_tr_"+vname+id;
 var ctrl = "img_qtree_"+vname+id;
 var imgsrc = document.getElementById(ctrl).src ;
 if(/play_arrow/i.test(imgsrc)) {
 document.getElementById(ctrl).src = './images/icons/icon_loading.gif';
 var url = "./storage_filer_details_ajax.php?hostid=" + node +"&vol="+vname+"&ajax_call=true";
 document.getElementById(qtree_tr).className = 'show';
 XHttpObject(url,updateQtreeList,id);
 } else {
 document.getElementById(ctrl).src = './images/play_arrow.png';
 document.getElementById(qtree_tr).className = 'hide';
 }
}

function updateQuotaList(xmlResponse,id) {
    var xmldoc = xmlResponse.documentElement;
    var xmlColumns = xmldoc.getElementsByTagName("col");
    var xmllist = xmldoc.getElementsByTagName("list");
    var xmlquotas = xmldoc.getElementsByTagName("qlist");
    var recs = xmllist[0].getAttribute("recs");
    var hostid = xmllist[0].getAttribute("hostid");
    var vid = xmllist[0].getAttribute("vid");
    var qid = xmllist[0].getAttribute("qid");
    var tbl = "<table border='0' width='100%' cellspacing='1' cellpadding='1'><thead><tr>";
    
    for(var i=0;i<xmlColumns.length;i++) {
      var caption = xmlColumns[i].firstChild.data;
      tbl = tbl + "<td nowrap><span>"+caption+"</span></td>";
     }
    tbl = tbl + "</tr></thead><tbody>";
    for(var j=0;j<xmlquotas.length;j++) {
      tbl = tbl + "<tr class='result'>";
      var idx = xmlquotas[j].firstChild.data;
      tbl = tbl + "<td>"+idx+"</td>";
      var utype = xmlquotas[j].getAttribute("utype");
      tbl = tbl + "<td>"+utype+"</td>";
      var ugid = xmlquotas[j].getAttribute("ugid");
      tbl = tbl + "<td>"+ugid+"</td>";
      var blimit = xmlquotas[j].getAttribute("blimit");
      tbl = tbl + "<td>"+blimit+"</td>";
      var bused = xmlquotas[j].getAttribute("bused");
      tbl = tbl + "<td>"+bused+"</td>";
      var slimited = xmlquotas[j].getAttribute("slimited");
      tbl = tbl + "<td>"+slimited+"</td>";
      var flimit = xmlquotas[j].getAttribute("flimit");
      tbl = tbl + "<td>"+flimit+"</td>";
      var fused = xmlquotas[j].getAttribute("fused");
      tbl = tbl + "<td>"+fused+"</td>";
      var sflimit = xmlquotas[j].getAttribute("sflimit");
      tbl = tbl + "<td>"+sflimit+"</td>";
      var pname = xmlquotas[j].getAttribute("pname");
      tbl = tbl + "<td>"+pname+"</td>";
      var mtime = xmlquotas[j].getAttribute("mtime");
      tbl = tbl + "<td>"+mtime+"</td></tr>";
    }
   if(recs == 0) {
      tbl = tbl + '<tr height=20><td colspan=11 align=center>Quota(s) not found!</td></tr>';
    }
    tbl = tbl + "</tbody></table>";

     var quota_div = "quota_div_"+vid+qid+id;
     var img_id = "quota_img_"+vid+qid+id;
    document.getElementById(quota_div).innerHTML = '';
    document.getElementById(quota_div).innerHTML = tbl;
    document.getElementById(img_id).src = './images/down_arrow.png';
}

function getQuota(id,node,vid,qid,qname) {
     var quota_tr = "quota_tr_"+vid+qid+id;
     var quota_div = "quota_div_"+vid+qid+id;
     var ctrl = "quota_img_"+vid+qid+id;
     var imgsrc = document.getElementById(ctrl).src ;
     if(/play_arrow/i.test(imgsrc)) {
     document.getElementById(ctrl).src = './images/icons/icon_loading.gif';
     var url = "./storage_filer_details_ajax.php?hostid=" + node +"&volid="+vid+"&qtreeid="+qid+"&qtree="+qname+"&ajax_call=true";
     document.getElementById(quota_tr).className = 'show';
     XHttpObject(url,updateQuotaList,id);
     } else {
       document.getElementById(ctrl).src = './images/play_arrow.png';
       document.getElementById(quota_tr).className = 'hide';
     }
}

function expandCorpSites(){
  var curr_img = document.getElementById('img_corp_sites').src;
  if(/play_arrow/i.test(curr_img)) {
   document.getElementById('img_corp_sites').src = './images/down_arrow.gif';
   document.getElementById('corp_colos').className='show';
  } else {
   document.getElementById('img_corp_sites').src = './images/play_arrow.gif';
   document.getElementById('corp_colos').className='hide';
  }
}

function updateList(basediv,ctrl,content) {
var rec = content.split("|");  
var trdiv = "tr_site_"+trim(rec[0]);
var tblname = basediv;
var tbl = "<tr id='"+trdiv+"' onMouseOver=\"this.style.backgroundColor='#F7F7F7';\" onMouseOut=\"this.style.backgroundColor='#EEEEEE';\">";
  tbl = tbl + "<td><input type=hidden name='"+ctrl+"' id='"+ctrl+"' value='"+trim(rec[0])+"'></td>";
  tbl = tbl + "<td>"+trim(rec[1])+"</td>";
  tbl = tbl + "<td align=center><img src='./images/delete.png' onClick=\"removeRow('"+trdiv+"')\"></td>";
  tbl = tbl + "</tr>";
  if(!document.getElementById(trdiv)) {
    var tbl_exist = document.getElementById(tblname).innerHTML + tbl;
    document.getElementById(basediv).innerHTML= tbl_exist;
  }
}

/**
 * changes location on SELECT change
 */
function jumpMenu(id) {
  this.location.href = getSelected(id);
}

function showYUIGraph(url,htitle){
myPanel = new YAHOO.widget.Panel("myPanel", {
                                  height:"750px",
                                  width:"1100px", 
                                  fixedcenter: true, 
                                  constraintoviewport: true, 
                                  underlay:"shadow", 
                                  close:true, 
                                  visible:false, 
                                  draggable:true} );
myPanel.setHeader(htitle);
myPanel.setBody("<table cellspacing=0 cellpadding=0 border=0 height=100% width=100%><tr><td align=center valign=middle><img id='exp_graph' src='./images/busbar_1.gif' border=0></td></tr></table>");
myPanel.cfg.setProperty("underlay","matte");
myPanel.render();
myPanel.show();
document.getElementById('exp_graph').src = url;
}

function makeYUIRequest(url,id){
     document.getElementById(id).src = url;
//var request = YAHOO.util.Connect.asyncRequest('GET', url, {success:callbkShowGraph,failure:callbkClearGraph,argument: [id]});
}


var callbkShowGraph = function(obj) {
 var ctrl_id = obj.argument; 
  if(obj.responseText !== undefined) {
    document.getElementById(ctrl_id).src = obj.responseText;
  }
};

var callbkClearGraph = function(obj) {
  var ctrl_id = "td_"+obj.argument; 
  if(obj.responseText !== undefined) {
    document.getElementById(ctrl_id).innerHTML = '<p>error while loading data</p>';
  }
};
function updateSelected() {
var arr_list = Array();
var obj = document.entitySearch;
var is_checked = false;
var int_i = 0;
var i = 0;
var n = 0;
var curr_element = "";
for(i = 0,n = obj.elements.length; i < n;i++) { 
curr_element = obj.elements[i];
  if (curr_element.name == 'listids[]' && curr_element.checked) {
    arr_list[int_i++] = curr_element.value;
  }
}

var divid = window.opener.document.getElementById('divSelectedList');
var hid = window.opener.document.getElementById('filerid');
var eids = hid.value;
var tbl = '';
var arr_ids = Array();
var arr_eids = eids.split(",");
var is_exist = 0;
for(var re in arr_list) {
  var rec = arr_list[re].split("|");
  var tmp_id = rec[0];
  is_exist = 0;
  for(var id in arr_eids) {
  if (arr_eids[id] == tmp_id){
    is_exist =1;
  }
  }
  if(is_exist == 1) { continue; }
  tbl = tbl + rec[1]+"<br>";
  arr_ids[i] = rec[0];
  i=i+1;
}

window.opener.document.getElementById('divSelectedList').innerHTML = window.opener.document.getElementById('divSelectedList').innerHTML + tbl;
if(arr_eids.length>0) {
window.opener.document.getElementById('filerid').value = arr_eids.join(",")+arr_ids.join(",");
} else {
window.opener.document.getElementById('filerid').value = arr_ids.join(",");

}
this.window.close();
}

var isUserSuccess = function(o) {
	var response = o.responseXML;
  var args = o.argument;
	var tblname = args[0];
  var ctrl_id = args[1];
  var xmldoc = response.documentElement; 
  var msg = xmldoc.getElementsByTagName("msg");
  var status = msg[0].getAttribute("isFound");
  if(status == 404) {
  alert(msg[0].firstChild.data);
  } else {
    var id = xmldoc.getElementsByTagName("id")[0].firstChild.data;
    var uname = xmldoc.getElementsByTagName("username")[0].firstChild.data;
    var email = xmldoc.getElementsByTagName("email")[0].firstChild.data;
    var trdiv = 'tr_'+id;
    var tbl = "<tr id='"+trdiv+"' class='result' onMouseOver=\"this.style.backgroundColor='#F7F7F7';\" onMouseOut=\"this.style.backgroundColor='#EEEEEE';\">";
        tbl = tbl + "<td><input type=hidden name='user_id' id='user_id' value='"+id+"'></td>";
        tbl = tbl + "<td>"+uname+"</td>";
        tbl = tbl + "<td>"+email+"</td>";
        tbl = tbl + "<td align=center><img src='./images/delete.png' onClick=\"removeRow('"+trdiv+"')\"></td>";
        tbl = tbl + "</tr>";
   if(!document.getElementById(trdiv)) {
     var tbl_exist = document.getElementById(tblname).innerHTML + tbl;
         document.getElementById(tblname).innerHTML= tbl_exist;
  }
  document.getElementById(ctrl_id).value = '';
  }
  };

var isUserFailure = function(o) {

};

var addValidInfraUser = function(uname,id) {
 var user_name = document.getElementById(uname).value;
 var callback = { 	 
	success:isUserSuccess, failure:isUserFailure, argument: [id,uname] 
 };
 var url = "./assignee.php?action=configinfrauserCheck&ajax_call=1&name="+user_name;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};

var addValidUser = function(uname,id) {
 var user_name = document.getElementById(uname).value;
 var callback = { 	 
	success:isUserSuccess, failure:isUserFailure, argument: [id,uname] 
 };
 var url = "./assignee.php?action=configuserCheck&ajax_call=1&name="+user_name;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};

var addValidDPUser = function(uname,id) {
 var user_name = document.getElementById(uname).value;
 var callback = { 	 
	success:isUserSuccess, failure:isUserFailure, argument: [id,uname] 
 };
 var url = "./backup_assignee.php?action=configuserCheck&ajax_call=1&name="+user_name;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};
function checkAllDays(ctrl,opt) {
var obj = document.getElementsByName(ctrl);
var len = obj.length;
var sel_type = false;
var i = 0;
if(opt == 'all') {
  if(document.getElementById('all').checked) {
    sel_type = true;
  }
for(i=0;i<len;i++) {
  obj[i].checked = sel_type;
}
} else {

if(document.getElementById('weekdays').checked) {
    sel_type = true;
}
for(i=0;i<len;i++) {
  var val = obj[i].value;
  if(val!='sun' && val!='sat') {
  obj[i].checked = sel_type;
  } else {
  obj[i].checked = false;
  }
}
}
}

var isPropSuccess = function(o) {
	var response = o.responseText;
  var id = o.argument;
  var tdname = "td_"+id;
  var img_id = "img_"+id;
  document.getElementById(tdname).innerHTML= "<table border=0 cellspacing=0 cellpadding=0><td>&nbsp;&nbsp;&nbsp;&nbsp;</tD><td>"+response+"</td></tr></table>";
  document.getElementById(img_id).src = './images/icons/icon_minus.gif';
};

var isPropFailure = function(o) {
  var id = o.args;
  var tdname = "td_"+id;
  var response = "<font class='error'>Data error!</font>";
  document.getElementById(tdname).innerHTML= response;

};

var isinfraPOCSuccess = function(o) {
	var response = o.responseText;
  var id = o.argument;
  var tdname = "td_"+id;
  var img_id = "img_"+id;
  document.getElementById(tdname).innerHTML= "<table border=0 cellspacing=0 cellpadding=10>"+response+"</table>";
  document.getElementById(img_id).src = './images/icons/icon_minus.gif';
};

var isinfraPOCFailure = function(o) {
  var id = o.args;
  var tdname = "td_"+id;
  var response = "<font class='error'>Data error!</font>";
  document.getElementById(tdname).innerHTML= response;
};

var showinfraPOC = function(id) {
  var img_id = "img_"+id;
  var tr_id = "tr_"+id;
  var curr_img = document.getElementById(img_id).src;
  if(/icon_plus/i.test(curr_img)) {
   document.getElementById(img_id).src = './images/icons/icon_loading.gif';
   document.getElementById(tr_id).className='show';
   document.getElementById(tr_id).className='result';
  } else {
   document.getElementById(img_id).src = './images/icons/icon_plus.gif';
   document.getElementById(tr_id).className='hide';
   return;
  }
  var callback = { 	 
	success:isinfraPOCSuccess, failure:isinfraPOCFailure, argument: [id] 
  };
  var url = "./assignee.php?action=configinfraProperty&ajax_call=1&aid="+id;
  YAHOO.util.Connect.asyncRequest('GET', url, callback);
  
};
var showPOC = function(id, base_url) {
  var img_id = "img_"+id;
  var tr_id = "tr_"+id;
  var curr_img = document.getElementById(img_id).src;
  if(/icon_plus/i.test(curr_img)) {
   document.getElementById(img_id).src = './images/icons/icon_loading.gif';
   document.getElementById(tr_id).className='show';
   document.getElementById(tr_id).className='result';
  } else {
   document.getElementById(img_id).src = './images/icons/icon_plus.gif';
   document.getElementById(tr_id).className='hide';
   return;
  }

 var callback = { 	 
	success:isPropSuccess, failure:isPropFailure, argument: [id] 
 };
 var url = base_url+id;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};

var isPropNColoSuccess = function(o) {
	var response = o.responseText;
  var id = o.argument;
  var tdname = "td_"+id;
  var img_id = "img_"+id;
  document.getElementById(tdname).innerHTML= "<table border=0 cellspacing=0 cellpadding=0><td>&nbsp;&nbsp;&nbsp;&nbsp;</tD><td>"+response+"</td></tr></table>";
  document.getElementById(img_id).src = './images/icons/icon_minus.gif';
};

var isPropNColoFailure = function(o) {
  var id = o.args;
  var tdname = "td_"+id;
  var response = "<font class='error'>Data error!</font>";
  document.getElementById(tdname).innerHTML= response;

};

var showPropNColoPOC = function(id) {
  var img_id = "img_"+id;
  var tr_id = "tr_"+id;
  var curr_img = document.getElementById(img_id).src;
  if(/icon_plus/i.test(curr_img)) {
   document.getElementById(img_id).src = './images/icons/icon_loading.gif';
   document.getElementById(tr_id).className='show';
   document.getElementById(tr_id).className='result';
  } else {
   document.getElementById(img_id).src = './images/icons/icon_plus.gif';
   document.getElementById(tr_id).className='hide';
   return;
  }

 var callback = { 	 
	success:isPropNColoSuccess, failure:isPropNColoFailure, argument: [id] 
 };
 var url = "./assignee.php?action=configPropertyNColo&ajax_call=1&aid="+id;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};
var showDialog = function(dlg_id,dlg_src,dlg_height,dlg_width,dlg_header) {
var d=new Date();
var t=d.getTime();
var rnd=Math.floor(Math.random()*11);
    dlg_id = dlg_id+(rnd+t);

var dlgDiv = document.createElement("div");
    dlgDiv.setAttribute( "id", 'dlg'+dlg_id );

var p1 = document.createElement("div");
    p1.className = 'hd';

var p2 = document.createElement("div");
    p2.className = 'bd';
    p2.setAttribute( 'align', 'center');

    var if1 = document.createElement("iframe");
        if1.setAttribute( 'name', 'iframe'+dlg_id );
        if1.setAttribute( 'id',   'iframe'+dlg_id );
        if1.src = dlg_src;
        if1.width = dlg_width;
        if1.height = dlg_height;
        if1.marginWidth = '0';
        if1.marginHeight = '0';
        if1.frameBorder = '0';
        if1.scrolling = 'no';
        p2.appendChild(if1);
        dlgDiv.appendChild(p1);
        dlgDiv.appendChild(p2);
   document.body.appendChild(dlgDiv);
   var panel1 = new YAHOO.widget.Panel( 'dlg'+dlg_id, {
                width: dlg_width+"px",
                height:  dlg_height+"px",
                x:"200",
                y:"200",
                constraintoviewport: true,
                underlay:"shadow", close:true, visible:false, draggable:true, fixedcenter: true, modal:true
                } );
     panel1.setHeader(dlg_header);
     panel1.render();
     panel1.show();
};

function showHelp(title,ele,ht,wd){
var rnd=Math.floor(Math.random()*100);
var myPanel = "myPanel_"+rnd;

 myPanel = new YAHOO.widget.Panel("myPanel", {
		                    height:ht,
				    width:wd,
			            fixedcenter: true,
				    constraintoviewport: true,
                                    underlay:"shadow",
			            close:true,
			            visible:false,
			            draggable:true} );
	myPanel.setHeader("Help - "+title);
	myPanel.setBody("<table cellspacing=0 cellpadding=0 border=0 height=100% width=100%><tr><td id='showhelp' valign=top></td></tr></table>");
	myPanel.cfg.setProperty("underlay","matte");
	myPanel.render();
	myPanel.show();
	document.getElementById('showhelp').innerHTML = document.getElementById(ele).innerHTML;
}

function removeElement(rowid) {
      try {
                var nodeTr = document.getElementById(rowid);
                        var pTable = nodeTr.parentNode;
                                             pTable.removeChild(nodeTr);
                                                     }
              catch(e) {
                                alert(e);
              }
}

function updateSelect(src,dest,opt) {
	var swapAll = (opt == 1)?true:false;
	var srcsel = document.getElementById(src);
	var dessel = document.getElementById(dest);
	for (var i = 0; i < srcsel.length; i++) {
	                if (srcsel.options[i].selected || swapAll) {
	                        dessel.options[dessel.options.length] = new Option(srcsel.options[i].text);
	                        dessel.options[dessel.options.length-1].value = srcsel.options[i].value;
	                        srcsel.options[i].selected = false;
	                        srcsel.options[i] = null;
	                        i--;
	                }
	}
}
function submitConfig(ctrl_id, ctrl_id1, ctrl_id2) {
  var i = 0;
	var dessel = document.getElementById(ctrl_id);
	for(i=0;i<dessel.length;i++) {
	dessel.options[i].selected = true;
	}

	var dessel1 = document.getElementById(ctrl_id1);
	for(i=0;i<dessel1.length;i++) {
	dessel1.options[i].selected = true;
	}

	var dessel2 = document.getElementById(ctrl_id2);
	for(i=0;i<dessel2.length;i++) {
	dessel2.options[i].selected = true;
	}
}
var showAvilGraph = function(id,is_cluster) {
  var img_id = "cimage_"+id;
  var tr_id = "tr_"+id;
  var graph_id = "graph_"+id;
  var url = "";
  if(is_cluster==1) {
    url = './availability.php?action=clusterTrend&host_id='+id;
  } else { 
    url = './availability.php?action=nodeTrend&host_id='+id;
  }
  var f_date = 'from_ts_'+id;
  var e_date = 'to_ts_'+id;
  var curr_img = document.getElementById(img_id).src;
  if(/icon_plus/i.test(curr_img)) {
   document.getElementById(img_id).src = './images/icons/icon_minus.gif';
   document.getElementById(tr_id).className='show';
   document.getElementById(tr_id).className='result';
   var sdate = document.getElementById(f_date).value;
   var edate = document.getElementById(e_date).value;
   url=url+"&from_ts="+sdate+"&to_ts="+edate;
   document.getElementById(graph_id).src = url;
  } else {
   document.getElementById(img_id).src = './images/icons/icon_plus.gif';
   document.getElementById(tr_id).className='hide';
   return;
  }
};

var GenerateGraph = function(id) {
   var graph_id = "graph_"+id;
   var f_date = 'from_ts_'+id;
   var e_date = 'to_ts_'+id;
   var shh = 'frm_hh_'+id;
   var smm = 'frm_mm_'+id;
   var ehh = 'to_hh_'+id;
   var emm = 'to_mm_'+id;
   var url = './availability.php?action=nodeTrend&host_id='+id;
   var sdate = document.getElementById(f_date).value;
   var edate = document.getElementById(e_date).value;
   var s_hh = document.getElementById(shh).value;
   var s_mm = document.getElementById(smm).value;
   var e_hh = document.getElementById(ehh).value;
   var e_mm = document.getElementById(emm).value;
       url=url+"&from_ts="+sdate+"&to_ts="+edate+"&s_hh="+s_hh+"&s_mm="+s_mm+"&e_hh="+e_hh+"&e_mm="+e_mm;
       document.getElementById(graph_id).src = url;
};
checkAllItems = function(id,ele){
        var action = false;
        if(document.getElementById('chk_all').checked == true) {
            action = true;
        }
        var id_list = document.getElementById(id).value;
        var arr_id = id_list.split(",");
        var n = arr_id.length;
        var ele_id = "";
        for(var i = 0; i < n; i++) {
            ele_id = ele+arr_id[i];
            document.getElementById(ele_id).checked = action;
       }
};

bulkupdateComments = function (id,ele,nstate) {
        var id_list = document.getElementById(id).value;
        var arr_id = id_list.split(",");
        var n = arr_id.length;
        var arr_selids = new Array();
        var ele_id = "";
        for(var i = 0; i < n; i++) {
            ele_id = ele+arr_id[i];
            if(document.getElementById(ele_id).checked) {
                  var sel_val = document.getElementById(ele_id).value;
                  arr_selids.push(sel_val);
            }
        }
        if(arr_selids.length==0) {
          alert('Pls select filers to provide comments');
          return;
        }
            var sel_ids = arr_selids.join(",");
            var url = "./dashboard.php?action=dbAck&db_ids="+sel_ids+"&nstate="+nstate;
            showDialog('dbAck',url,'250','530','Dashboard');
};
updateComments = function (id,nstate) {
    var url = "./dashboard.php?action=dbAck&db_ids="+id+"&nstate="+nstate;
      showDialog('dbAck',url,'250','530','Dashboard');
};

getTrunkingData = function(host_id,port_id) {	
   var img_id = "img_"+port_id;
   var my_row_id = "tr_"+port_id;
   var my_div_id = "div_"+port_id;
   var curr_img = document.getElementById(img_id).src;
   if(/icon_plus/i.test(curr_img)) {
    document.getElementById(img_id).src = './images/icons/icon_minus.gif';
    document.getElementById(my_row_id).className='show';
    document.getElementById(my_row_id).className='result';
   } else {
    document.getElementById(img_id).src = './images/icons/icon_plus.gif';
    document.getElementById(my_row_id).className='hide';
    return;
   }
   var myColumnDefs = [
		{key:"src_switch", label:"Source&nbsp;Switch"},
		{key:"src_port_name", label:"Source&nbsp;Port"},
		{key:"src_port_speed", label:"Port&nbsp;Speed(Gb)"},
		{key:"src_phy_status", label:"Port&nbsp;Status"},
		{key:"dest_switch", label:"Destination&nbsp;Switch"},
		{key:"dest_port_name", label:"Destination&nbsp;Port"}
	];
	var url = "./san.php?action=getCiscoTrunkDetails&host_id="+host_id+"&port_id="+port_id;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["src_switch","src_port_name","src_port_speed","src_phy_status","dest_switch","dest_port_name"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(my_div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};
getZoneSet = function(zone_id) {	
   var div_id = "zone_group_"+zone_id;
   var tr_id = "tr_zone_group_"+zone_id;
   var inp_id = "inp_"+zone_id;
   var show_val = document.getElementById(inp_id).value;
   if(show_val==0) {
    document.getElementById(tr_id).className='show';
    document.getElementById(tr_id).className='result';
    document.getElementById(inp_id).value = 1;
    } else {
    document.getElementById(tr_id).className='hide';
    document.getElementById(inp_id).value=0;
    return;
    }
   var myColumnDefs = [
		{key:"zoneset_name", label:"Zone"}
	];
	var url = "./san.php?action=getCiscoZoneDetails&zone_id="+zone_id;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["zoneset_name"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};

getSwitchesList = function(stype,col,col_val,pfix) {
   var div_id = "div_"+pfix;
   var tr_id = "tr_"+pfix;
   var show_val = document.getElementById(tr_id).className=='hide'?true:false;
   if(show_val) {
    document.getElementById(tr_id).className='show';
    document.getElementById(tr_id).className='result';
    } else {
    document.getElementById(tr_id).className='hide';
    return;
    }
   var myColumnDefs = [
		{key:"nodename", label:"Switch&nbsp;Name"},
		{key:"uports", label:"Used&nbsp;Ports"},
		{key:"aports", label:"Avil&nbsp;Ports"},
		{key:"nosfp", label:"NoSFP"}
	];
	var url = "./san.php?action=getSwitchesList&stype="+stype+"&"+col+"="+col_val;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["nodename","uports","aports","nosfp"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};


showDriveGroups = function(hostid,portid) {
   var div_id = "div_grp_"+portid;
   var tr_id = "tr_grp_"+portid;
   var other_tr_id = "tr_"+portid;
   var inp_id = "inp_"+portid;
   
   var show_val = document.getElementById(tr_id).className=='hide'?true:false;
   if(show_val) {
    document.getElementById(other_tr_id).className='hide';
    document.getElementById(inp_id).value=0;
    document.getElementById(tr_id).className='show';
    document.getElementById(tr_id).className='result';
    } else {
    document.getElementById(tr_id).className='hide';
    return;
    }
   var myColumnDefs = [
		{key:"drivegroup", label:"Drive&nbsp;Group&nbsp;Member"}
	];
	var url = "./san.php?action=getDriveGroupList&host_id="+hostid+"&port_id="+portid;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["drivegroup"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};

showDrivewwn = function(hostid,portid,wwn) {
   var div_id = "div_grp_"+portid;
   var tr_id = "tr_grp_"+portid;
   var other_tr_id = "tr_"+portid;
   var inp_id = "inp_"+portid;
   
   var show_val = document.getElementById(tr_id).className=='hide'?true:false;
   if(show_val) {
    document.getElementById(other_tr_id).className='hide';
    document.getElementById(inp_id).value=0;
    document.getElementById(tr_id).className='show';
    document.getElementById(tr_id).className='result';
    } else {
    document.getElementById(tr_id).className='hide';
    return;
    }
   var myColumnDefs = [
		{key:"drivegroup", label:"Drive&nbsp;Group&nbsp;Member"}
	];
	var url = "./san.php?action=getDriveGroupwwn&host_id="+hostid+"&wwn="+wwn;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["drivegroup"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};


showGroupMembers = function(hostid,portid) {
   var div_id = "div_grp_"+portid;
   var tr_id = "tr_grp_"+portid;
   var other_tr_id = "tr_"+portid;
   var inp_id = "inp_"+portid;
   
   var show_val = document.getElementById(tr_id).className=='hide'?true:false;
   if(show_val) {
    document.getElementById(other_tr_id).className='hide';
    document.getElementById(inp_id).value=0;
    document.getElementById(tr_id).className='show';
    document.getElementById(tr_id).className='result';
    } else {
    document.getElementById(tr_id).className='hide';
    return;
    }
   var myColumnDefs = [
		{key:"member", label:"Group&nbsp;Member"}
	];
	var url = "./san.php?action=getCiscoGroupList&host_id="+hostid+"&port_id="+portid;
	this.myDataSource = new YAHOO.util.DataSource(url);
	this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	this.myDataSource.connXhrMode = "queueRequests";
	this.myDataSource.responseSchema = {
		resultsList: "Result",
		fields: ["member"]
	};
	this.myDataTable = new YAHOO.widget.DataTable(div_id, myColumnDefs,this.myDataSource);//, {initialRequest:"&db_id="+id});
        var myCallback = function() {
		   this.set("sortedBy", null);
	           this.onDataReturnAppendRows.apply(this,arguments);
	};
        var callback1 = {
		   success : myDataTable.onDataReturnInitializeTable,
	           failure : myCallback,
	           scope : this.myDataTable
	};
	this.myDataSource.sendRequest(null,callback1);
};


var unsetSelect = function(id) {
  var obj = document.getElementById(id);
  for (var i = 1; i < obj.length; i++) {
    obj.options[i] = null;
    i--;
  }
};

var setSelect = function(id,list) {
  var len = list.length;
  var obj = document.getElementById(id);
  for (var i = 0; i < len; i++) {
    obj.options[obj.options.length] = new Option(list[i]);
    obj.options[obj.options.length-1].value = list[i];
  }
};

var updateVersionModel = function(o) {
  var args = o.argument;
  var response = o.responseText;
    try {
      var jsonarr = YAHOO.lang.JSON.parse(response);
      unsetSelect(args[0]);
      unsetSelect(args[1]);
      setSelect(args[0],jsonarr.Result.model);
      setSelect(args[1],jsonarr.Result.version);
    } catch (e) {
      alert("Invalid json data");
    }
};
var failedUpdate = function(o) {
 alert('Failed to populate Model/Version data!');
};

var getModelVersion = function(src1,src2) {
 var stype = document.getElementById('stype').selectedIndex;
 stype = document.getElementById('stype').options[stype].value;
 if(stype=='') {
  unsetSelect(src1);
  unsetSelect(src2);
  return;
 }
 var callback = { 	 
	success:updateVersionModel, failure:failedUpdate, argument: [src1,src2] 
 };
 var url = "./san.php?action=getModelVersion&stype="+stype;
 YAHOO.util.Connect.asyncRequest('GET', url, callback);
};

function checkBCP() {
  if(document.getElementById('bcp_box').value==1){
    alert('Panchang is in read-only mode, Please visit after some time for updating');
    return false;
  }
  return true;
}
/* vim: set et ts=2 sw=2 sts=2 fdm=marker: */
