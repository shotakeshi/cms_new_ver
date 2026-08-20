$(function () {
	"use strict";

	// Default
	$('#jstree').jstree();
	
	//Check Box
	$('#jstree-checkbox').jstree({
		"checkbox" : {
			"keep_selected_style" : false
		  },
		  "plugins" : [ "checkbox" ]
	});
});