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

function createTable(tbl_name,cspace,cpad,bdr,bgclr,wide,src) {
	try {
	var tbl = document.createElement('table');
		tbl.setAttribute('name',tbl_name);
		tbl.setAttribute('id',tbl_name);
		tbl.setAttribute('border',bdr);
		tbl.setAttribute('cellspacing',cspace);
		tbl.setAttribute('cellpadding',cpad);
		tbl.setAttribute('bgcolor',bgclr);
		tbl.setAttribute('width',wide);
		if(src !== '') {
		src.appendChild(tbl);
		}
		return tbl;
	}
	catch(e) {
   		alert(e);
	}
}
function appendRow(srcTbl,rowID,onOver,onOut) {
	try {
		var tr = document.createElement('tr');
			 tr.setAttribute('id',rowID);
			 if(onOver !== '') {
			 tr.setAttribute('onMouseOver',onOver);
			 }
			 if(onOut !== '') {
			 tr.setAttribute('onMouseOut',onOut);
			 }
			 srcTbl.appendChild(tr);
			 return tr;
	} catch(e) {
		alert(e);
	}

}

function appendBody(srcTbl) {
	try {
		var tbody = document.createElement('tbody');
	  		    srcTbl.appendChild(tbody);
			    return tbody;
	} catch(e) {
		alert(e);
	}

}

function appendCell(srcRow,element1,element2) {
	try {
		var td = document.createElement('td');
			 td.appendChild(element1);
			 if(element2 !== '') {
			 td.appendChild(element2);
			 }
			 srcRow.appendChild(td);
	} catch(e) {
		alert(e);
	}


}

function createText(txt) {
	try {
	var txtnode = document.createTextNode(txt);
	return txtnode;
	} catch(e) {
		alert(e);
	}
}

function createHiddenText(id,val) {
	try {
	var ctrl = document.createElement('input');
		ctrl.setAttribute("type","hidden");
		ctrl.setAttribute("value",val);
		ctrl.setAttribute("name",id);
	return ctrl;
	}
	catch(e) {
		alert(e);
	}
}

function createImageCtrl(imgID,rmElement) {
	try {
  var iele = document.createElement("input");
  	iele.setAttribute("type","image");
  	iele.setAttribute("name",imgID);
  	iele.setAttribute("src","images/delete.png");
  	iele.setAttribute("border","0");
 	iele.setAttribute("onClick","removeRow('"+rmElement+"')");
	return iele;

	} catch(e) {
		alert(e);
	}
}

function removeRow(rowID) {
	try {
	var nodeTr = document.getElementById(rowID);
	var pTable = nodeTr.parentNode;
		     pTable.removeChild(nodeTr);
	}
	catch(e) {
		alert(e);
	}
}

