<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$base = str_replace('administrator/','',JURI::base()). 'components/com_arkeditor/views/typography/tmpl/';

?>
<link rel="stylesheet" href="<?php echo $base; ?>js/typography/lib/codemirror.css">
<script src="<?php echo $base; ?>js/typography/lib/codemirror.js" type="text/javascript"></script>
<script src="<?php echo $base; ?>js/typography/lib/foldcode.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $base; ?>js/typography/theme/default.css">
<script src="<?php echo $base; ?>js/typography/lib/searchcodemirror.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo $base; ?>js/typography/lib/dialog.css">
<!--[if IE]>
 <link rel="stylesheet" href="<?php echo $base; ?>css/typography/modal_ie.css" type="text/css" />
<![endif]-->
<style type="text/css">
       body, body.contentpane {margin: 0px; padding:0px}
      .CodeMirror {border:1px solid silver;}
      .activeline {background: #f0fcff !important;}
	  .CodeMirror-gutter {
		min-width: 3em; 
		cursor: pointer;	
		background-image: url("js/typography/images/line.png");
		background-repeat: repeat-y;
		background-position: 25px 50%;
		}
	  .CodeMirror-gutter-text { padding:0px; padding-top: 0.4em;text-align: right;}
	  .CodeMirror-gutter-text pre { 
		display: block;
		background-repeat: no-repeat;
		background-position: 25px 50%
		}
	 .CodeMirror-gutter-text pre.openfold {	background-image: url("<?php echo $base; ?>js/typography/images/open.png");}
	 .CodeMirror-gutter-text pre.closefold {	background-image: url("<?php echo $base; ?>js/typography/images/close.png");}
	 .CodeMirror-gutter-text pre span{padding-right:5px;}
	 .CodeMirror-searching { background: none repeat scroll 0 0 #FFFFAA;}
	
</style>

<!--[if IE]>
<style>
 .CodeMirror-gutter,.CodeMirror-gutter-text pre {background-position: 32px 50%;}
</style>	   
<![endif]-->
<textarea id="editarea" style="width:640px;height:478px;border:1px solid silver;overflow:auto"> </textarea>
<script type="text/javascript">
		var parentDoc =  window.parent.document,
			parentWin =	 window.parent;
			textarea =  parentDoc.getElementById('<?php echo JFactory::getApplication()->input->get('e_id');?>'),
			editibleArea = document.getElementById('editarea');
			editibleArea.value =  textarea && textarea.value || '';
			
		function onclose()
		{
			codemirror.toTextArea() //copy content back to textarea
			textarea.value = editibleArea.value;
			parentWin.SqueezeBox.removeEvent('onClose',this);
		}
		parentWin && parentWin.SqueezeBox.addEvent('onClose',onclose);
		
		 var foldFunc = CodeMirror.newFoldFunction(CodeMirror.braceRangeFinder);
		  function keyEvent(cm, e) {
			if (e.keyCode == 81 && (e.ctrlKey || e.metaKey) ) {
			  if (e.type == "keydown") {
				e.stop();
				setTimeout(function() {foldFunc(cm, cm.getCursor().line);}, 50);
			  }
			  return true;
			}
			
			if (e.keyCode == 70 && (e.ctrlKey || e.metaKey) ) { //'ctrl-f'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.find(cm);
			  }
			  return true;
			}
			
			
			if (e.keyCode == 71 && (e.ctrlKey || e.metaKey) ) { //'ctrl-g'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.findNext(cm);
			  }
			  return true;
			}
			
			if (e.keyCode == 71 && (e.ctrlKey  || e.metaKey) && e.shiftKey) { //'ctrl-shft-g'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.findPrev(cm);
			  }
			  return true;
			}
			
			if (e.keyCode == 82 && (e.ctrlKey  || e.metaKey)) { //'ctrl-r'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.replace(cm);
			  }
			  return true;
			}
					
			if (e.keyCode == 82 && (e.ctrlKey  || e.metaKey) && e.shiftKey) { //'ctrl-shft-r'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.replaceAll(cm);
			  }
			  return true;
			}
			
			if (e.keyCode == 27) { //'Esc'
			  if (e.type == "keydown") {
				e.stop();
				CodeMirror.commands.clearSearch(cm);
			  }
			  return true;
			}
			
		
		  }
		
		var codemirror = CodeMirror.fromTextArea(document.getElementById("editarea"),
		{
			lineNumbers: true,
			matchBrackets: true,
			lineWrapping: true,
			firstLineNumber : '<span>&nbsp;</span>',
			onGutterClick: foldFunc,
			onKeyEvent: keyEvent,
			onCursorActivity: function() 
			{
				codemirror.setLineClass(hlLine, null);
				hlLine = codemirror.setLineClass(codemirror.getCursor().line, "activeline");
			}	
		});
		var hlLine = 0;
		(function(codemirror) 
		{
			lineTotal = codemirror.lineCount();
			for(i = 0; i < lineTotal;i++)
			{
				
				if(CodeMirror.braceRangeFinder(codemirror,i))
				{
					codemirror.setMarker(i,'%N%','closefold');
				}
			}	
		}
		)(codemirror);
		
</script>