/*jshint jquery:true */

jQuery(window).on("load", function() {

	"use strict";

	/*-----------------------------------------
	FlexSlider Init
	-----------------------------------------*/
	jQuery(".flexslider").flexslider();

});

jQuery(document).ready(function($) {

	"use strict";

	/*-----------------------------------------
	Responsive Videos
	-----------------------------------------*/
	$('.post').fitVids();

	/*-----------------------------------------
	Main Navigation Init
	-----------------------------------------*/
	$('ul#navigation').superfish({
		delay:			300,
		animation:		{opacity:'show',height:'show'},
		speed:			'fast',
		dropShadows:	false
	});

	/*-----------------------------------------
	Responsive Menus Init with jPanelMenu
	-----------------------------------------*/
	var jPM = $.jPanelMenu({
		menu: '#navigation',
		trigger: '.menu-trigger',
		excludedPanelContent: "style, script, #wpadminbar"
	});

	var jRes = jRespond([
		{
			label: 'mobile',
			enter: 0,
			exit: 767
		}
	]);

	jRes.addFunc({
		breakpoint: 'mobile',
		enter: function() {
			jPM.on();
		},
		exit: function() {
			jPM.off();
		}
	});
	
	if ($("a[data-rel^='prettyPhoto']").length) {	
		$("a[data-rel^='prettyPhoto']").prettyPhoto();
		$("a[data-rel^='prettyPhoto']").each(function() {
			$(this).attr("rel", $(this).data("rel"));
		});
	}

});