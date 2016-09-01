/**
 * jQuery WebMIS 2016
 * Copyright (c) www.ksphp.com. All rights reserved.
 * Date: 2016-08-30
 */

var $base_url;		// Web site URL
var $webmis_root;	// WebMIS Root
var $webmis_src;		// WebMIS Src
var $webmis_plugin;	// WebMIS Plugin

$(function(){

	 /* Public */
	$base_url = $('#base_url').text();
	$webmis_root = $base_url+'../webmis/';
	$webmis_src = $webmis_root+'src/';
	$webmis_plugin = $webmis_root+'plugin/';

	/* Version */
	var D = new Date();
	$.fn.webmisVersion = function (options) {
		var defaults = {version: 'WebMIS '+D.getFullYear()}
		var options = $.extend(defaults, options);
		this.text(options.version);
	}
	
	/* Plugin */
	$.webmis={
		// Load CSS or JS
		inc: function (options) {
			var defaults = {files: '', doc: 'body'}
			var options = $.extend(defaults, options);
			var files = options.files;
			for (var i=0; i<files.length; i++) {
				if(files[i]){
					var att = files[i].replace(/^\s|\s$/g, "").split('.');
					var ext = att[att.length - 1].toLowerCase();
					var isCSS = ext == "css";
					var tag = isCSS ? "link" : "script";
					var attr = isCSS ? " type='text/css' rel='stylesheet' " : " language='javascript' type='text/javascript' ";
					var link = (isCSS ? "href" : "src") + "='" + files[i] + "'";
					var f = "<" + tag + attr + link + "></" + tag + ">";
					if ($('script[src="'+files[i]+'"]').length == 0 && $('link[href="'+files[i]+'"]').length == 0) {$(options.doc).append(f);}
				}
			}
		},
		// Win
		win: function (effect,options,path) {
			if(!path){path='';}
			var file = path + $webmis_src + 'jquery.window.js';
			if ($('script[src="'+file+'"]').length == 0) {$.webmis.inc({files:[file]});}
			//APP
			switch (effect){
				case 'open':
					openWin(options);
				break;
				case 'load':
					loadWin(options);
				break;
				case 'close':
					closeWin(options);
				break;
				case 'menu':
					addWinMenu(options);
				break;
			}
		},
		// VOD
		vod: function (options) {
			var file = $webmis_src + 'jquery.vod.js';
			if ($('script[src="'+file+'"]').length == 0) {$.webmis.inc({files:[file]});}
			//APP
			openVod(options);
		}
	};
	
	/* Effect */
	$.fn.webmis = function (effect,options) {
		var effect = effect.toLowerCase();
		var file = $webmis_src + 'jquery.'+effect+'.js';
		if ($('script[src="'+file+'"]').length == 0) {$.webmis.inc({files:[file]});}
		//APP
		switch (effect){
			case 'msg':
				msgCreate(options,this);
			break;
			case 'menu':
				menuCreate(options,this);
			break;
			case 'subclass':
				SubClass(options,this);
			break;
			case 'tableoddcolor':
				TableOddColor(options,this);
			break;
			case 'tableadjust':
				TableAdjust(options,this);
			break;
			case 'autoselect':
				AutoSelect(options,this);
			break;
			case 'getinputid':
				return GetInputID(options,this);
			break;
		}
	};
});
