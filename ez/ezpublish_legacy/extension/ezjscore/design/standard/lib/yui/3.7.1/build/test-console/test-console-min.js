/*
YUI 3.7.1 (build 5627)
Copyright 2012 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/
YUI.add("test-console",function(e,t){function n(){n.superclass.constructor.apply(this,arguments)}e.namespace("Test").Console=e.extend(n,e.Console,{initializer:function(t){this.on("entry",this._onEntry),this.plug(e.Plugin.ConsoleFilters,{category:e.merge({info:!0,pass:!1,fail:!0,status:!1},t&&t.filters||{}),defaultVisibility:!1,source:{TestRunner:!0}}),e.Test.Runner.on("complete",e.bind(this._parseCoverage,this))},_parseCoverage:function(){var t=e.Test.Runner.getCoverage();if(!t)return;var n={lines:{hit:0,miss:0,total:0,percent:0},functions:{hit:0,miss:0,total:0,percent:0}};e.Object.each(t,function(e){n.lines.total+=e.coveredLines,n.lines.hit+=e.calledLines,n.lines.miss+=e.coveredLines-e.calledLines,n.lines.percent=Math.floor(n.lines.hit/n.lines.total*100),n.functions.total+=e.coveredFunctions,n.functions.hit+=e.calledFunctions,n.functions.miss+=e.coveredFunctions-e.calledFunctions,n.functions.percent=Math.floor(n.functions.hit/n.functions.total*100)});var r="Lines: Hit:"+n.lines.hit+" Missed:"+n.lines.miss+" Total:"+n.lines.total+" Percent:"+n.lines.percent+"%\n";r+="Functions: Hit:"+n.functions.hit+" Missed:"+n.functions.miss+" Total:"+n.functions.total+" Percent:"+n.functions.percent+"%",this.log("Coverage: "+r,"info","TestRunner")},_onEntry:function(e){var t=e.message;t.category==="info"&&/\s(?:case|suite)\s|yuitests\d+|began/.test(t.message)?t.category="status":t.category==="fail"&&this.printBuffer()}},{NAME:"testConsole",ATTRS:{entryTemplate:{value:'<div class="{entry_class} {cat_class} {src_class}"><div class="{entry_content_class}">{message}</div></div>'},height:{value:"350px"},newestOnTop:{value:!1},style:{value:"block"},width:{value:e.UA.ie&&e.UA.ie<9?"100%":"inherit"}}})},"3.7.1",{requires:["console-filters","test"],skinnable:!0});
