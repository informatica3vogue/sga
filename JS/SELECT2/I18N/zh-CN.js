/**
* noty - jQuery Notification Plugin v1.2.1
* Contributors: https://github.com/needim/noty/graphs/contributors
*
* Examples and Documentation - http://needim.github.com/noty/
*
* Licensed under the MIT licenses:
* http://www.opensource.org/licenses/mit-license.php
*
**/
(function($) {
	$.noty = function(options, customContainer) {

		var base = {};
		var $noty = null;
		var isCustom = false;

		base.init = function(options) {
			base.options = $.extend({}, $.noty.defaultOptions, options);
			base.options.type = base.options.cssPrefix+base.options.type;
			base.options.id = base.options.type+'_'+new Date().getTime();
			base.options.layout = base.options.cssPrefix+'layout_'+base.options.layout;

			if (base.options.custom.container) cus