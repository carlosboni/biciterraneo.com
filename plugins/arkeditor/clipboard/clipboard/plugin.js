"use strict";
/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
(function(){function t(n,t,i){if((t.type||(t.type="auto"),i&&n.fire("beforePaste",t)===!1)||!t.dataValue&&t.dataTransfer.isEmpty())return!1;if(t.dataValue||(t.dataValue=""),CKEDITOR.env.gecko&&t.method=="drop"&&n.toolbox)n.once("afterPaste",function(){n.toolbox.focus()});return n.fire("paste",t)}function r(n){function y(){function t(t,i,r,u,f){var e=n.lang.clipboard[i];n.addCommand(i,r);n.ui.addButton&&n.ui.addButton(t,{label:e,command:i,toolbar:"clipboard,"+u});n.addMenuItems&&n.addMenuItem(i,{label:e,command:i,group:"clipboard",order:f})}t("Cut","cut",c("cut"),10,1);t("Copy","copy",c("copy"),20,4);t("Paste","paste",b(),30,8)}function p(){n.on("key",g);n.on("contentDom",w);n.on("selectionChange",function(n){e=n.data.selection.getRanges()[0].checkReadOnly();h()});n.contextMenu&&n.contextMenu.addListener(function(n,t){return e=t.getRanges()[0].checkReadOnly(),{cut:r("cut"),copy:r("copy"),paste:r("paste")}})}function w(){var t=n.editable(),r,e;if(CKEDITOR.plugins.clipboard.isCustomCopyCutSupported){r=function(t){n.readOnly&&t.name=="cut"||i.initPasteDataTransfer(t,n);t.data.preventDefault()};t.on("copy",r);t.on("cut",r);t.on("cut",function(){n.readOnly||n.extractSelectedHtml()},null,null,999)}t.on(i.mainPasteEvent,function(n){i.mainPasteEvent=="beforepaste"&&u||v(n)});if(i.mainPasteEvent=="beforepaste"){t.on("paste",function(t){f||(o(),t.data.preventDefault(),v(t),s("paste")||n.openDialog("paste"))});t.on("contextmenu",l,null,null,0);t.on("beforepaste",function(n){!n.data||n.data.$.ctrlKey||n.data.$.shiftKey||l()},null,null,0)}t.on("beforecut",function(){u||a(n)});t.attachListener(CKEDITOR.env.ie?t:n.document.getDocumentElement(),"mouseup",function(){e=setTimeout(function(){h()},0)});n.on("destroy",function(){clearTimeout(e)});t.on("keyup",h)}function c(t){return{type:t,canUndo:t=="cut",startDisabled:!0,exec:function(){function i(t){if(CKEDITOR.env.ie)return s(t);try{return n.document.$.execCommand(t,!1,null)}catch(i){return!1}}this.type=="cut"&&a();var t=i(this.type);return t||n.showNotification(n.lang.clipboard[this.type+"Error"]),t}}}function b(){return{canUndo:!1,async:!0,exec:function(n,r){var f=this,u=function(i,r){i&&t(n,i,!!r);n.fire("afterCommandExec",{name:"paste",command:f,returnValue:!!i})};typeof r=="string"?u({dataValue:r,method:"paste",dataTransfer:i.initPasteDataTransfer()},1):n.getClipboardData(u)}}}function o(){f=1;setTimeout(function(){f=0},100)}function l(){u=1;setTimeout(function(){u=0},10)}function s(t){var i=n.document,r=i.getBody(),u=!1,f=function(){u=!0};r.on(t,f);return CKEDITOR.env.version>7?i.$.execCommand(t):i.$.selection.createRange().execCommand(t),r.removeListener(t,f),u}function a(){if(CKEDITOR.env.ie&&!CKEDITOR.env.quirks){var t=n.getSelection(),i,r,u;t.getType()==CKEDITOR.SELECTION_ELEMENT&&(i=t.getSelectedElement())&&(r=t.getRanges()[0],u=n.document.createText(""),u.insertBefore(i),r.setStartBefore(u),r.setEndAfter(i),t.selectRanges([r]),setTimeout(function(){i.getParent()&&(u.remove(),t.selectElement(i))},0))}}function k(t,i){var o=n.document,u=n.editable(),s=function(n){n.cancel()},f,e,v,r,h,y,c,l,a,p,w;if(!o.getById("cke_pastebin")){e=n.getSelection();v=e.createBookmarks();CKEDITOR.env.ie&&e.root.fire("selectionchange");r=new CKEDITOR.dom.element((CKEDITOR.env.webkit||u.is("body"))&&!CKEDITOR.env.ie?"body":"div",o);r.setAttributes({id:"cke_pastebin","data-cke-temp":"1"});h=0;c=o.getWindow();CKEDITOR.env.webkit?(u.append(r),r.addClass("cke_editable"),u.is("body")||(y=u.getComputedStyle("position")!="static"?u:CKEDITOR.dom.element.get(u.$.offsetParent),h=y.getDocumentPosition().y)):u.getAscendant(CKEDITOR.env.ie?"body":"html",1).append(r);r.setStyles({position:"absolute",top:c.getScrollPosition().y-h+10+"px",width:"1px",height:Math.max(1,c.getViewPaneSize().height-20)+"px",overflow:"hidden",margin:0,padding:0});CKEDITOR.env.safari&&r.setStyles(CKEDITOR.tools.cssVendorPrefix("user-select","text"));l=r.getParent().isReadOnly();l?(r.setOpacity(0),r.setAttribute("contenteditable",!0)):r.setStyle(n.config.contentsLangDirection=="ltr"?"left":"right","-10000px");n.on("selectionChange",s,null,null,0);(CKEDITOR.env.webkit||CKEDITOR.env.gecko)&&(f=u.once("blur",s,null,null,-100));l&&r.focus();a=new CKEDITOR.dom.range(r);a.selectNodeContents(r);p=a.select();CKEDITOR.env.ie&&(f=u.once("blur",function(){n.lockSelection(p)}));w=CKEDITOR.document.getWindow().getScrollPosition().y;setTimeout(function(){CKEDITOR.env.webkit&&(CKEDITOR.document.getBody().$.scrollTop=w);f&&f.removeListener();CKEDITOR.env.ie&&u.focus();e.selectBookmarks(v);r.remove();var t;CKEDITOR.env.webkit&&(t=r.getFirst())&&t.is&&t.hasClass("Apple-style-span")&&(r=t);n.removeListener("selectionChange",s);i(r.getHtml())},0)}}function d(){if(i.mainPasteEvent=="paste")return n.fire("beforePaste",{type:"auto",method:"paste"}),!1;n.focus();o();var t=n.focusManager;return(t.lock(),n.editable().fire(i.mainPasteEvent)&&!s("paste"))?(t.unlock(),!1):(t.unlock(),!0)}function g(t){if(n.mode=="wysiwyg")switch(t.data.keyCode){case CKEDITOR.CTRL+86:case CKEDITOR.SHIFT+45:var r=n.editable();o();i.mainPasteEvent=="paste"&&r.fire("beforepaste");return;case CKEDITOR.CTRL+88:case CKEDITOR.SHIFT+46:n.fire("saveSnapshot");setTimeout(function(){n.fire("saveSnapshot")},50)}}function v(r){var u={type:"auto",method:"paste",dataTransfer:i.initPasteDataTransfer(r)},f;u.dataTransfer.cacheData();f=n.fire("beforePaste",u)!==!1;f&&i.canClipboardApiBeTrusted(u.dataTransfer,n)?(r.data.preventDefault(),setTimeout(function(){t(n,u)},0)):k(r,function(i){u.dataValue=i.replace(/<span[^>]+data-cke-bookmark[^<]*?<\/span>/ig,"");f&&t(n,u)})}function h(){if(n.mode=="wysiwyg"){var t=r("paste");n.getCommand("cut").setState(r("cut"));n.getCommand("copy").setState(r("copy"));n.getCommand("paste").setState(t);n.fire("pasteState",t)}}function r(t){if(e&&t in{paste:1,cut:1})return CKEDITOR.TRISTATE_DISABLED;if(t=="paste")return CKEDITOR.TRISTATE_OFF;var i=n.getSelection(),r=i.getRanges(),u=i.getType()==CKEDITOR.SELECTION_NONE||r.length==1&&r[0].collapsed;return u?CKEDITOR.TRISTATE_DISABLED:CKEDITOR.TRISTATE_OFF}var i=CKEDITOR.plugins.clipboard,u=0,f=0,e=0;p();y();n.getClipboardData=function(t,i){function e(n){n.removeListener();n.cancel();i(n.data)}function s(n){n.removeListener();r=!0;u=n.data.type}function o(n){n.removeListener();n.cancel();f=!0;i({type:u,dataValue:n.data.dataValue,dataTransfer:n.data.dataTransfer,method:"paste"})}function h(){this.customTitle=t&&t.title}var r=!1,u="auto",f=!1;i||(i=t,t=null);n.on("paste",e,null,null,0);n.on("beforePaste",s,null,null,1e3);if(d()===!1)if(n.removeListener("paste",e),r&&n.fire("pasteDialog",h)){n.on("pasteDialogCommit",o);n.on("dialogHide",function(n){n.removeListener();n.data.removeListener("pasteDialogCommit",o);setTimeout(function(){f||i(null)},10)})}else i(null)}}function u(n){if(CKEDITOR.env.webkit){if(!n.match(/^[^<]*$/g)&&!n.match(/^(<div><br( ?\/)?><\/div>|<div>[^<]*<\/div>)*$/gi))return"html"}else if(CKEDITOR.env.ie){if(!n.match(/^([^<]|<br( ?\/)?>)*$/gi)&&!n.match(/^(<p>([^<]|<br( ?\/)?>)*<\/p>|(\r\n))*$/gi))return"html"}else if(CKEDITOR.env.gecko){if(!n.match(/^([^<]|<br( ?\/)?>)*$/gi))return"html"}else return"html";return"htmlifiedtext"}function f(n,t){function i(n){return CKEDITOR.tools.repeat("<\/p><p>",~~(n/2))+(n%2==1?"<br>":"")}return(t=t.replace(/\s+/g," ").replace(/> +</g,"><").replace(/<br ?\/>/gi,"<br>"),t=t.replace(/<\/?[A-Z]+>/g,function(n){return n.toLowerCase()}),t.match(/^[^<]$/))?t:(CKEDITOR.env.webkit&&t.indexOf("<div>")>-1&&(t=t.replace(/^(<div>(<br>|)<\/div>)(?!$|(<div>(<br>|)<\/div>))/g,"<br>").replace(/^(<div>(<br>|)<\/div>){2}(?!$)/g,"<div><\/div>"),t.match(/<div>(<br>|)<\/div>/)&&(t="<p>"+t.replace(/(<div>(<br>|)<\/div>)+/g,function(n){return i(n.split("<\/div><div>").length+1)})+"<\/p>"),t=t.replace(/<\/div><div>/g,"<br>"),t=t.replace(/<\/?div>/g,"")),CKEDITOR.env.gecko&&n.enterMode!=CKEDITOR.ENTER_BR&&(CKEDITOR.env.gecko&&(t=t.replace(/^<br><br>$/,"<br>")),t.indexOf("<br><br>")>-1&&(t="<p>"+t.replace(/(<br>){2,}/g,function(n){return i(n.length/4)})+"<\/p>")),o(n,t))}function e(){function t(){var t={};for(var n in CKEDITOR.dtd)n.charAt(0)!="$"&&n!="div"&&n!="span"&&(t[n]=1);return t}function i(){var n=new CKEDITOR.filter;return n.allow({$1:{elements:t(),attributes:!0,styles:!1,classes:!1}}),n}var n={};return{get:function(t){return t=="plain-text"?n.plainText||(n.plainText=new CKEDITOR.filter("br")):t=="semantic-content"?n.semanticContent||(n.semanticContent=i()):t?new CKEDITOR.filter(t):null}}}function i(n,t,i){var r=CKEDITOR.htmlParser.fragment.fromHtml(t),u=new CKEDITOR.htmlParser.basicWriter;return i.applyTo(r,!0,!1,n.activeEnterMode),r.writeHtml(u),u.getHtml()}function o(n,t){return n.enterMode==CKEDITOR.ENTER_BR?t=t.replace(/(<\/p><p>)+/g,function(n){return CKEDITOR.tools.repeat("<br>",n.length/7*2)}).replace(/<\/?p>/g,""):n.enterMode==CKEDITOR.ENTER_DIV&&(t=t.replace(/<(\/)?p>/g,"<$1div>")),t}function s(n){n.data.preventDefault();n.data.$.dataTransfer.dropEffect="none"}function h(n){var i=CKEDITOR.plugins.clipboard;n.on("contentDom",function(){function h(i,r,u){r.select();t(n,{dataTransfer:u,method:"drop"},1);u.sourceEditor.fire("saveSnapshot");u.sourceEditor.editable().extractHtmlFromRange(i);u.sourceEditor.getSelection().selectRanges([i]);u.sourceEditor.fire("saveSnapshot")}function c(r,u){r.select();t(n,{dataTransfer:u,method:"drop"},1);i.resetDragDataTransfer()}function f(t,i,r){var u={$:t.data.$,target:t.data.getTarget()};i&&(u.dragRange=i);r&&(u.dropRange=r);n.fire(t.name,u)===!1&&t.data.preventDefault()}function e(n){return n.type!=CKEDITOR.NODE_ELEMENT&&(n=n.getParent()),n.getChildCount()}var r=n.editable(),u=CKEDITOR.plugins.clipboard.getDropTarget(n),o=n.ui.space("top"),s=n.ui.space("bottom");i.preventDefaultDropOnElement(o);i.preventDefaultDropOnElement(s);r.attachListener(u,"dragstart",f);r.attachListener(n,"dragstart",i.resetDragDataTransfer,i,null,1);r.attachListener(n,"dragstart",function(t){i.initDragDataTransfer(t,n)},null,null,2);r.attachListener(n,"dragstart",function(){var t=i.dragRange=n.getSelection().getRanges()[0];CKEDITOR.env.ie&&CKEDITOR.env.version<10&&(i.dragStartContainerChildCount=t?e(t.startContainer):null,i.dragEndContainerChildCount=t?e(t.endContainer):null)},null,null,100);r.attachListener(u,"dragend",f);r.attachListener(n,"dragend",i.initDragDataTransfer,i,null,1);r.attachListener(n,"dragend",i.resetDragDataTransfer,i,null,100);r.attachListener(u,"dragover",function(n){var t=n.data.getTarget();if(t&&t.is&&t.is("html")){n.data.preventDefault();return}CKEDITOR.env.ie&&CKEDITOR.plugins.clipboard.isFileApiSupported&&n.data.$.dataTransfer.types.contains("Files")&&n.data.preventDefault()});r.attachListener(u,"drop",function(t){var r,e,u,o;t.data.$.defaultPrevented||(t.data.preventDefault(),r=t.data.getTarget(),e=r.isReadOnly(),!e||r.type==CKEDITOR.NODE_ELEMENT&&r.is("html"))&&(u=i.getRangeAtDropPosition(t,n),o=i.dragRange,u)&&f(t,o,u)},null,null,9999);r.attachListener(n,"drop",i.initDragDataTransfer,i,null,1);r.attachListener(n,"drop",function(t){var u=t.data;if(u){var f=u.dropRange,e=u.dragRange,r=u.dataTransfer;r.getTransferType(n)==CKEDITOR.DATA_TRANSFER_INTERNAL?setTimeout(function(){i.internalDrop(e,f,r,n)},0):r.getTransferType(n)==CKEDITOR.DATA_TRANSFER_CROSS_EDITORS?h(e,f,r):c(f,r)}},null,null,9999)})}CKEDITOR.plugins.add("clipboard",{requires:"dialog",lang:"en, en-gb,de,es,fi,fr,he,hu,it,pt,nl,ru,zh-cn",icons:"copy,copy-rtl,cut,cut-rtl,paste,paste-rtl",hidpi:!0,init:function(n){var t,o=e();n.config.forcePasteAsPlainText?t="plain-text":n.config.pasteFilter?t=n.config.pasteFilter:!CKEDITOR.env.webkit||"pasteFilter"in n.config||(t="semantic-content");n.pasteFilter=o.get(t);r(n);h(n);CKEDITOR.dialog.add("paste",CKEDITOR.getUrl(this.path+"dialogs/paste.js"));n.on("paste",function(t){if(t.data.dataTransfer||(t.data.dataTransfer=new CKEDITOR.plugins.clipboard.dataTransfer),!t.data.dataValue){var r=t.data.dataTransfer,i=r.getData("text/html");i?(t.data.dataValue=i,t.data.type="html"):(i=r.getData("text/plain"),i&&(t.data.dataValue=n.editable().transformPlainTextToHtml(i),t.data.type="text"))}},null,null,1);n.on("paste",function(n){var t=n.data.dataValue,f=CKEDITOR.dtd.$block,i,u,r;if(t.indexOf("Apple-")>-1&&(t=t.replace(/<span class="Apple-converted-space">&nbsp;<\/span>/gi," "),n.data.type!="html"&&(t=t.replace(/<span class="Apple-tab-span"[^>]*>([^<]*)<\/span>/gi,function(n,t){return t.replace(/\t/g,"&nbsp;&nbsp; &nbsp;")})),t.indexOf('<br class="Apple-interchange-newline">')>-1&&(n.data.startsWithEOL=1,n.data.preSniffing="html",t=t.replace(/<br class="Apple-interchange-newline">/,"")),t=t.replace(/(<[^>]+) class="Apple-[^"]*"/gi,"$1")),t.match(/^<[^<]+cke_(editable|contents)/i)){for(r=new CKEDITOR.dom.element("div"),r.setHtml(t);r.getChildCount()==1&&(i=r.getFirst())&&i.type==CKEDITOR.NODE_ELEMENT&&(i.hasClass("cke_editable")||i.hasClass("cke_contents"));)r=u=i;u&&(t=u.getHtml().replace(/<br>$/i,""))}CKEDITOR.env.ie?t=t.replace(/^&nbsp;(?: |\r\n)?<(\w+)/g,function(t,i){return i.toLowerCase()in f?(n.data.preSniffing="html","<"+i):t}):CKEDITOR.env.webkit?t=t.replace(/<\/(\w+)><div><br><\/div>$/,function(t,i){return i in f?(n.data.endsWithEOL=1,"<\/"+i+">"):t}):CKEDITOR.env.gecko&&(t=t.replace(/(\s)<br>$/,"$1"));n.data.dataValue=t},null,null,3);n.on("paste",function(t){var r=t.data,s=r.type,e=r.dataValue,h,c=n.config.clipboard_defaultContentType||"html",l=r.dataTransfer.getTransferType(n);h=s=="html"||r.preSniffing=="html"?"html":u(e);h=="htmlifiedtext"&&(e=f(n.config,e));s=="text"&&h=="html"?e=i(n,e,o.get("plain-text")):l==CKEDITOR.DATA_TRANSFER_EXTERNAL&&n.pasteFilter&&!r.dontFilter&&(e=i(n,e,n.pasteFilter));r.startsWithEOL&&(e='<br data-cke-eol="1">'+e);r.endsWithEOL&&(e+='<br data-cke-eol="1">');s=="auto"&&(s=h=="html"||c=="html"?"html":"text");r.type=s;r.dataValue=e;delete r.preSniffing;delete r.startsWithEOL;delete r.endsWithEOL},null,null,6);n.on("paste",function(t){var i=t.data;i.dataValue&&(n.insertHtml(i.dataValue,i.type,i.range),setTimeout(function(){n.fire("afterPaste")},0))},null,null,1e3);n.on("pasteDialog",function(t){setTimeout(function(){n.openDialog("paste",t.data)},0)})}});CKEDITOR.plugins.clipboard={isCustomCopyCutSupported:!CKEDITOR.env.ie&&!CKEDITOR.env.iOS,isCustomDataTypesSupported:!CKEDITOR.env.ie,isFileApiSupported:!CKEDITOR.env.ie||CKEDITOR.env.version>9,mainPasteEvent:CKEDITOR.env.ie&&!CKEDITOR.env.edge?"beforepaste":"paste",canClipboardApiBeTrusted:function(n,t){return n.getTransferType(t)!=CKEDITOR.DATA_TRANSFER_EXTERNAL?!0:CKEDITOR.env.chrome&&!n.isEmpty()?!0:CKEDITOR.env.gecko&&(n.getData("text/html")||n.getFilesCount())?!0:!1},getDropTarget:function(n){var t=n.editable();return CKEDITOR.env.ie&&CKEDITOR.env.version<9||t.isInline()?t:n.document},fixSplitNodesAfterDrop:function(n,t,i,r){function f(n,i,r){var u=n;return u.type==CKEDITOR.NODE_TEXT&&(u=n.getParent()),u.equals(i)&&r!=i.getChildCount()?(e(t),!0):void 0}function e(n){var t=n.startContainer.getChild(n.startOffset-1),i=n.startContainer.getChild(n.startOffset),r;t&&t.type==CKEDITOR.NODE_TEXT&&i&&i.type==CKEDITOR.NODE_TEXT&&(r=t.getLength(),t.setText(t.getText()+i.getText()),i.remove(),n.setStart(t,r),n.collapse(!0))}var u=t.startContainer;typeof r=="number"&&typeof i=="number"&&u.type==CKEDITOR.NODE_ELEMENT&&(f(n.startContainer,u,i)||f(n.endContainer,u,r))},isDropRangeAffectedByDragRange:function(n,t){var i=t.startContainer,r=t.endOffset;return n.endContainer.equals(i)&&n.endOffset<=r?!0:n.startContainer.getParent().equals(i)&&n.startContainer.getIndex()<r?!0:n.endContainer.getParent().equals(i)&&n.endContainer.getIndex()<r?!0:!1},internalDrop:function(n,i,r,u){var h=CKEDITOR.plugins.clipboard,a=u.editable(),f,e,o;u.fire("saveSnapshot");u.fire("lockSnapshot",{dontUpdate:1});CKEDITOR.env.ie&&CKEDITOR.env.version<10&&this.fixSplitNodesAfterDrop(n,i,h.dragStartContainerChildCount,h.dragEndContainerChildCount);o=this.isDropRangeAffectedByDragRange(n,i);o||(f=n.createBookmark(!1));e=i.clone().createBookmark(!1);o&&(f=n.createBookmark(!1));var c=f.startNode,l=f.endNode,s=e.startNode,v=l&&c.getPosition(s)&CKEDITOR.POSITION_PRECEDING&&l.getPosition(s)&CKEDITOR.POSITION_FOLLOWING;v&&s.insertBefore(c);n=u.createRange();n.moveToBookmark(f);a.extractHtmlFromRange(n,1);i=u.createRange();i.moveToBookmark(e);t(u,{dataTransfer:r,method:"drop",range:i},1);u.fire("unlockSnapshot")},getRangeAtDropPosition:function(n,t){var o=n.data.$,s=o.clientX,c=o.clientY,r,f=t.getSelection(!0).getRanges()[0],i=t.createRange(),u,h,l,a,v,e,y;if(n.data.testRange)return n.data.testRange;if(document.caretRangeFromPoint)r=t.document.$.caretRangeFromPoint(s,c),i.setStart(CKEDITOR.dom.node(r.startContainer),r.startOffset),i.collapse(!0);else if(o.rangeParent)i.setStart(CKEDITOR.dom.node(o.rangeParent),o.rangeOffset),i.collapse(!0);else{if(CKEDITOR.env.ie&&CKEDITOR.env.version>8&&f&&t.editable().hasFocus)return f;if(document.body.createTextRange){t.focus();r=t.document.getBody().$.createTextRange();try{for(u=!1,h=0;h<20&&!u;h++){if(!u)try{r.moveToPoint(s,c-h);u=!0}catch(p){}if(!u)try{r.moveToPoint(s,c+h);u=!0}catch(p){}}if(u)l="cke-temp-"+(new Date).getTime(),r.pasteHTML('<span id="'+l+'">​<\/span>'),a=t.document.getById(l),i.moveToPosition(a,CKEDITOR.POSITION_BEFORE_START),a.remove();else{if(v=t.document.$.elementFromPoint(s,c),e=new CKEDITOR.dom.element(v),e.equals(t.editable())||e.getName()=="html")return f&&f.startContainer&&!f.startContainer.equals(t.editable())?f:null;y=e.getClientRect();s<y.left?(i.setStartAt(e,CKEDITOR.POSITION_AFTER_START),i.collapse(!0)):(i.setStartAt(e,CKEDITOR.POSITION_BEFORE_END),i.collapse(!0))}}catch(p){return null}}else return null}return i},initDragDataTransfer:function(n,t){var r=n.data.$?n.data.$.dataTransfer:null,i=new this.dataTransfer(r,t);r?this.dragData&&i.id==this.dragData.id?i=this.dragData:this.dragData=i:this.dragData?i=this.dragData:this.dragData=i;n.data.dataTransfer=i},resetDragDataTransfer:function(){this.dragData=null},initPasteDataTransfer:function(n,t){if(this.isCustomCopyCutSupported){if(n&&n.data&&n.data.$){var i=new this.dataTransfer(n.data.$.clipboardData,t);return this.copyCutData&&i.id==this.copyCutData.id?(i=this.copyCutData,i.$=n.data.$.clipboardData):this.copyCutData=i,i}return new this.dataTransfer(null,t)}return new this.dataTransfer(CKEDITOR.env.edge&&n&&n.data.$&&n.data.$.clipboardData||null,t)},preventDefaultDropOnElement:function(n){n&&n.on("dragover",s)}};var n=CKEDITOR.plugins.clipboard.isCustomDataTypesSupported?"cke/id":"Text";CKEDITOR.plugins.clipboard.dataTransfer=function(t,i){if(t&&(this.$=t),this._={metaRegExp:/^<meta.*?>/i,bodyRegExp:/<body(?:[\s\S]*?)>([\s\S]*)<\/body>/i,fragmentRegExp:/<!--(?:Start|End)Fragment-->/g,data:{},files:[],normalizeType:function(n){return n=n.toLowerCase(),n=="text"||n=="text/plain"?"Text":n=="url"?"URL":n}},this.id=this.getData(n),this.id||(this.id=n=="Text"?"":"cke-"+CKEDITOR.tools.getUniqueId()),n!="Text")try{this.$.setData(n,this.id)}catch(r){}i&&(this.sourceEditor=i,this.setData("text/html",i.getSelectedHtml(1)),n=="Text"||this.getData("text/plain")||this.setData("text/plain",i.getSelection().getSelectedText()))};CKEDITOR.DATA_TRANSFER_INTERNAL=1;CKEDITOR.DATA_TRANSFER_CROSS_EDITORS=2;CKEDITOR.DATA_TRANSFER_EXTERNAL=3;CKEDITOR.plugins.clipboard.dataTransfer.prototype={getData:function(n){function r(n){return n===undefined||n===null||n===""}n=this._.normalizeType(n);var t=this._.data[n],i;if(r(t))try{t=this.$.getData(n)}catch(u){}return r(t)&&(t=""),n=="text/html"?(t=t.replace(this._.metaRegExp,""),i=this._.bodyRegExp.exec(t),i&&i.length&&(t=i[1],t=t.replace(this._.fragmentRegExp,""))):n=="Text"&&CKEDITOR.env.gecko&&this.getFilesCount()&&t.substring(0,7)=="file://"&&(t=""),t},setData:function(t,i){if(t=this._.normalizeType(t),this._.data[t]=i,CKEDITOR.plugins.clipboard.isCustomDataTypesSupported||t=="URL"||t=="Text"){n=="Text"&&t=="Text"&&(this.id=i);try{this.$.setData(t,i)}catch(r){}}},getTransferType:function(n){return this.sourceEditor?this.sourceEditor==n?CKEDITOR.DATA_TRANSFER_INTERNAL:CKEDITOR.DATA_TRANSFER_CROSS_EDITORS:CKEDITOR.DATA_TRANSFER_EXTERNAL},cacheData:function(){function r(n){n=i._.normalizeType(n);var t=i.getData(n);t&&(i._.data[n]=t)}if(this.$){var i=this,n,t;if(CKEDITOR.plugins.clipboard.isCustomDataTypesSupported){if(this.$.types)for(n=0;n<this.$.types.length;n++)r(this.$.types[n])}else r("Text"),r("URL");if(t=this._getImageFromClipboard(),this.$&&this.$.files||t){if(this._.files=[],this.$.files&&this.$.files.length)for(n=0;n<this.$.files.length;n++)this._.files.push(this.$.files[n]);this._.files.length===0&&t&&this._.files.push(t)}}},getFilesCount:function(){return this._.files.length?this._.files.length:this.$&&this.$.files&&this.$.files.length?this.$.files.length:this._getImageFromClipboard()?1:0},getFile:function(n){return this._.files.length?this._.files[n]:this.$&&this.$.files&&this.$.files.length?this.$.files[n]:n===0?this._getImageFromClipboard():undefined},isEmpty:function(){var t={},i,r;if(this.getFilesCount())return!1;for(i in this._.data)t[i]=1;if(this.$)if(CKEDITOR.plugins.clipboard.isCustomDataTypesSupported){if(this.$.types)for(r=0;r<this.$.types.length;r++)t[this.$.types[r]]=1}else t.Text=1,t.URL=1;n!="Text"&&(t[n]=0);for(i in t)if(t[i]&&this.getData(i)!=="")return!1;return!0},_getImageFromClipboard:function(){var n;if(this.$&&this.$.items&&this.$.items[0])try{if(n=this.$.items[0].getAsFile(),n&&n.type)return n}catch(t){}return undefined}}})()