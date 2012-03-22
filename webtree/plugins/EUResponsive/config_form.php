<h2>Admin Interface</h2>

<script type="text/javascript">

	window.onload = function(e){ 
		initConfig();
	}


	function initConfig(){

		disableSubmit();

		document.getElementsByTagName("form")[0].onsubmit = function(){}
	
		var definedBreakpoints = [];
		var definedImagewidths = [];
	
		
		<?php
			// load data into js
			$BREAKPOINTS	= get_option('euresponsive_breakpoints');
			$IMAGEWIDTHS	= get_option('euresponsive_imagewidths');
			$ZOOMIT			= get_option('euresponsive_zoomit');
			if($BREAKPOINTS){
				$BREAKPOINTS = explode("~", $BREAKPOINTS);
				echo("definedBreakpoints = [".implode(",",$BREAKPOINTS)."];");
			}			
			if($IMAGEWIDTHS){
				$IMAGEWIDTHS = explode("~", $IMAGEWIDTHS);
				echo("definedImagewidths = [".implode(",",$IMAGEWIDTHS)."];");
			}
			if($ZOOMIT){
				echo("zoomit = true;");
			}
			else{
				echo("zoomit = false;");
			}
		?>
		
		addBreakpoint();
		
		for(var i=0; i<definedBreakpoints.length; i++){
			document.getElementById("breakpoint_" + i).value = definedBreakpoints[i];
			if(i+1<definedBreakpoints.length){
				addBreakpoint();
			}
		}
		
		for(var i=0; i<definedImagewidths.length; i++){
			document.getElementById("imagewidth_" + i).value = definedImagewidths[i];
		}

		if(zoomit){
			document.getElementById("zoomit").checked = true;
		}
		
		// add key listener for enabling/disabling of submit button
		
		var inputs = document.getElementsByClassName("euresponsive_input");
		document.onkeyup = function(evt){
			var evt  = (evt) ? evt : ((event) ? event : null);
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
			enableSubmit();			
		}
		enableSubmit();
	}

	function addBreakpoint(){
	
		// remove "add" option from bottom
		if(document.getElementById("add_link")){
			document.getElementById("breakpoints").removeChild(document.getElementById("add_link"));
		}

		var breakpoints = getElementsByClassName("breakpoint");
		var number = breakpoints.length;
		
		var elBreakpoint = document.createElement("div");
		elBreakpoint.setAttribute("class", "breakpoint");
		elBreakpoint.setAttribute("style", "margin-bottom:8px;");
		
		var elLabel = document.createElement("label");
		configLabel(elLabel, number);
		elBreakpoint.appendChild(elLabel);
		
		var elInputSW = document.createElement("input");
		configInput(elInputSW, "breakpoint_" + number);
		elBreakpoint.appendChild(elInputSW);

		var elInputIW = document.createElement("input");
		configInput(elInputIW, "imagewidth_" + number);
		elBreakpoint.appendChild(elInputIW);

		if(breakpoints.length>0){
			var elRemove = document.createElement("a");
			configRemoveLink(elRemove, number);
			elBreakpoint.appendChild(elRemove);
		}
		
		document.getElementById("breakpoints").appendChild(elBreakpoint);

		// restore "add" option to bottom
		var elAddLink = document.createElement("a");
		elAddLink.setAttribute("id",	"add_link");
		elAddLink.setAttribute("href",	"javascript:addBreakpoint()");
		elAddLink.setAttribute("style",	"display:block;margin-left:274px;");
		
		elAddLink.appendChild(document.createTextNode("add"));
		document.getElementById("breakpoints").appendChild(elAddLink);
		
		// add "zoomit" checkbox
		configZoomit(elBreakpoint);
		enableSubmit();
	}

	function configLabel(elLabel, number){
		elLabel.setAttribute("for", "breakpoint_" + number);
		while(elLabel.childNodes.length>0){
			elLabel.removeChild(elLabel.childNodes[0]);
		}
		elLabel.appendChild(document.createTextNode("breakpoint " + (number + 1)));
	}

	function configInput(elInput, name){
		elInput.setAttribute("name",	name);
		elInput.setAttribute("id",		name);
		elInput.setAttribute("class",	"euresponsive_input");
		elInput.setAttribute("style",	"width:35px; margin-left:8px;");
	}

	function configRemoveLink(elRemove, number){
		while(elRemove.childNodes.length>0){
			elRemove.removeChild(elRemove.childNodes[0]);
		}
		elRemove.setAttribute("href",	"javascript:removeBreakpoint(" + number + ")");
		elRemove.setAttribute("style",	"margin-left:8px;");
		elRemove.appendChild(document.createTextNode("remove"));
	}


	// add "zoomit" checkbox
	function configZoomit(elBreakpoint){
		var elZoomitOld = getElementsByClassName("euresponsive_zoomit");
		var elZoomitCheckVal = false;
		//var elZoomitNumVal = 0;
		
		for(var i=0; i<elZoomitOld.length; i++){
			if(elZoomitOld[i].checked){
				elZoomitCheckVal = true;
				//elZoomitNumVal	 = elZoomitOld[i].name;
			}
			var parentNode = elZoomitOld[i].parentNode;
			var oldLabels = parentNode.getElementsByClassName("zoomit_label");
			for(var j=0; j<oldLabels.length; j++){
				parentNode.removeChild(oldLabels[j]);			
			}
			parentNode.removeChild(elZoomitOld[i]);
		}		

		var breakpoints = getElementsByClassName("breakpoint");
		var elBreakpoint = breakpoints[breakpoints.length-1];
		
		var elZoomit		= document.createElement("input");
		var elZoomitLabel	= document.createElement("label");
		elZoomit.setAttribute		("id",		"zoomit");
		elZoomit.setAttribute		("name",	"zoomit");
		elZoomit.setAttribute		("type",	"checkbox");
		elZoomit.setAttribute		("class",	"euresponsive_zoomit");
		elZoomit.setAttribute		("style",	"vertical-align:top;");
		elZoomitLabel.setAttribute	("for",		"zoomit");
		elZoomitLabel.setAttribute	("class",	"zoomit_label");
		elZoomitLabel.setAttribute	("style",	"display:inline; float:none; font-size:9px !important; vertical-align:super;");
		elZoomitLabel.appendChild	(document.createTextNode("apply zoomit"));

		elBreakpoint.appendChild(elZoomit);
		elBreakpoint.appendChild(elZoomitLabel);
		elZoomit.checked = elZoomitCheckVal;
	}

	function removeBreakpoint(number){
		var breakpoints = getElementsByClassName("breakpoint");
		breakpoints[number].parentNode.removeChild(breakpoints[number]);
		breakpoints = getElementsByClassName("breakpoint");
		
		// now reindex:
		//   label text
		//   label for
		//   input ids
		//   input names
		//   a href
		for(var i=0; i<breakpoints.length; i++){
			var elLabel = breakpoints[i].getElementsByTagName("label")[0];
			configLabel(elLabel, i);
			
			var elInputSW = breakpoints[i].getElementsByTagName("input")[0];
			configInput(elInputSW, "breakpoint_" + i);
			
			var elInputIW = breakpoints[i].getElementsByTagName("input")[1];
			configInput(elInputIW, "imagewidth_" + i);
			
			var elRemove = breakpoints[i].getElementsByTagName("a")[0];
			if(elRemove){
				configRemoveLink(elRemove, i);
			}
		}		
		configZoomit();
		enableSubmit();
	}


	function disableSubmit(){
		document.getElementsByClassName("submit")[0].disabled = true;
	}
	
	function enableSubmit(){
		var breakpoints = getElementsByClassName("breakpoint");
		var allFieldsFilled = true;
		
		var checkField = function(fieldVal, allowZero){
			var result = true;
			if(!fieldVal || fieldVal.length==0 || (parseInt(fieldVal) != fieldVal)  || (parseInt(fieldVal) < 0 && !allowZero) ){
				result = false;
			}
			return result;
		}
		
		for(var i=0; i<breakpoints.length; i++){
			
			var elInputSW = breakpoints[i].getElementsByTagName("input")[0];
			var elInputIW = breakpoints[i].getElementsByTagName("input")[1];

			if(!checkField(elInputSW.value) || !checkField(elInputIW.value, i==breakpoints.length-1) ){
				allFieldsFilled = false;
			}
			
			if(parseInt(elInputSW.value) < parseInt(elInputIW.value) ){
				elInputIW.style.border = "solid #F00 1px";
				allFieldsFilled = false;
			}
			else{
				elInputIW.style.border = "solid #F0F0F0 1px";
			}
		}
		if(allFieldsFilled){
			document.getElementsByClassName("submit")[0].disabled = false;
		}
		else{
			disableSubmit();
		}
	}
	
	function getElementsByClassName(classname, node) {
		if(!node) node = document.getElementsByTagName("body")[0];
		var a = [];
		var re = new RegExp('\\b' + classname + '\\b');
		var els = node.getElementsByTagName("*");
		for(var i=0,j=els.length; i<j; i++){
			if(re.test(els[i].className)){
				a.push(els[i]);
			}
		}
		return a;
	}

</script>
<p>
A single breakpoint is configured with two values:
</p>
<ul style="list-style: disc inside">
  <li>The screen or viewport width of the breakpoint</li>
  <li>The optimal image width for that screen width</li>
</ul>
<p>
The former should be greater than the latter, and multiple breakpoints should be listed in ascending order.
Checking the "zoomit" checkbox will override the image width property for that breakpoint, and will instead load the zoomit plugin.
</p>
<br><br>
<label style="margin-left:187px;">Screen W | Image W</label>
<br><br>
<div id="breakpoints"></div>
<p>
Note: some omeka themes seem to impose a minimum width on the page: make sure your break points fit within the available viewport width range.
</p>
