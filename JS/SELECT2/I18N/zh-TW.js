/*!
 * jQuery Raty - A Star Rating Plugin
 *
 * Licensed under The MIT License
 *
 * @version        2.4.5
 * @author         Washington Botelho
 * @documentation  wbotelhos.com/raty
 * 
 */

;(function(b){var a={init:function(c){return this.each(function(){var d=this,h=b(d).empty();d.opt=b.extend(true,{},b.fn.raty.defaults,c);h.data("settings",d.opt);d.opt.number=a.between(d.opt.number,0,20);if(d.opt.path.substring(d.opt.path.length-1,d.opt.path.length)!="/"){d.opt.path+="/";}if(typeof d.opt.score=="function"){d.opt.score=d.opt.score.call(d);}if(d.opt.score){d.opt.score=a.between(d.opt.score,0,d.opt.number);}for(var e=1;e<=d.opt.number;e++){b("<img />",{src:d.opt.path+((!d.opt.score||d.opt