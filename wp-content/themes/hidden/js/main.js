$ = jQuery;
// -------------------------------------------------------------------------------------------
// Tab shortcode javascript
// -------------------------------------------------------------------------------------------
(function ($) {
    $.fn.afl_tabs = function (options) {
        var defaults = {
            heading: '.tab',
            content: '.tab-pane'
        };

        var options = $.extend(defaults, options);

        return this.each(function () {
            var container = $(this),
                tabs = $(options.heading, container),
                content = $(options.content, container),
                tabs_container = $(container.attr('data-parent')),
                initialOpen = container.attr('data-open');

            // sort tabs
            if (tabs.length < 2) return;
            if (!initialOpen || initialOpen > tabs.length) initialOpen = 1;

            tabs.appendTo(tabs_container).each(function (i) {
                var tab = $(this);
                //set default tab to open
                if (initialOpen == (i + 1)) {
                    tab.addClass('active');
                    content.filter(':eq(' + i + ')').addClass('active');
                }
            });
        });
    };
})(jQuery);

function beautifyPortfolio() {
    $('.btn-details').each(function(){
        $(this).on('click', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: myajaxurl,
                type: 'POST',
                data:{
                    'action':'orders_ajax',
                    'fn':'get_portfolio_content',
                    'post_id': id
                },
                dataType: 'JSON',
                success:function(data){
                    if(data) {
                        $('#extended_portfolio_page #portfolio_title').html(data['post_title']);
                        $('#extended_portfolio_page #portfolio_category').html(data['post_category']);
                        $('#extended_portfolio_page #portfolio_author').html(data['post_author']);
                        $('#extended_portfolio_page #portfolio_info').html(data['post_content']);
                        $('#extended_portfolio_page #portfolio_image').html(data['post_image']);
                        $('#extended_portfolio_page').slideDown();
                        $.scrollTo('#extended_portfolio_page', 800, {easing:'easeInSine', offset: {top: -100}});
                    } else {
                        alert('No such portfolio');
                    }
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        });
    });
    $('#close_extended_portfolio').live('click', function(e){
        e.preventDefault();
        $('#extended_portfolio_page').slideUp();
        $.scrollTo('.portfolio_sc', 800, {easing:'easeInSine', offset: {top: -100}});
    });
}

$(document).ready(function(){

    // Activate Superfish Menu
    $('ul.sf-menu').superfish({
        delay: 1000,
        animation: {opacity: 'show', height: 'show'},
        speed: 'fast',
        autoArrows: true
    });

    // Activate UItoTop
    $().UItoTop({easingType: 'easeOutQuart', text: '' });
    $('#toTop').addClass("fa fa-angle-up");

    // Add class to wordpress submit form button
    $(".comment-form input[type='submit']").addClass("btn btn-info");

    // prettyPhoto
    $('a[data-rel]').each(function() {
        $(this).attr('rel', $(this).data('rel'));
    });
    // add prettyPhoto to wp links
    $('div.wp-caption a').each(function() {
        $(this).attr('rel', 'prettyPhoto');
    });
    $("a.p-link").on('click', function(){
        window.location = this.href;
    });

    $("a[rel^='prettyPhoto']").prettyPhoto({theme:'dark_square'});

	// animate hover div
	$('.do-media').live("mouseover", function(){
		//$(this).stop();
		//$(this).animate({opacity: 1}, 200);
        $(this).addClass('hover');
        $(this).find('.do-img-link').addClass('animated fast slideInLeft');
        $(this).find('.do-url-link').addClass('animated fast slideInRight');
        $(this).find('.do-img-link-single').addClass('animated fast slideInDown');
        // products
        $(this).find('.hover-image').removeClass('fadeOut').addClass('animated flipInY');
	});
	$('.do-media').live("mouseleave", function(){
		//$(this).stop();
		//$(this).animate({opacity: 0}, 200);
        $(this).removeClass('hover');
        $(this).find('.do-img-link').removeClass('animated fast slideInLeft');
        $(this).find('.do-url-link').removeClass('animated fast slideInRight');
        $(this).find('.do-img-link-single').removeClass('animated fast slideInDown');
        // products
        $(this).find('.hover-image').removeClass('flipInY').addClass('fadeOut');
	});

    $('.do-img-link').live("mouseover", function () {
        $(this).find('.fa').addClass('animated pulse');
    });
    $('.do-img-link').live("mouseleave", function () {
        $(this).find('.fa').removeClass('animated pulse');
    });

    $('.do-url-link').live("mouseover", function () {
        $(this).find('.fa').addClass('animated pulse');
    });
    $('.do-url-link').live("mouseleave", function () {
        $(this).find('.fa').removeClass('animated pulse');
    });

    $('.do-img-link-single').live("mouseover", function () {
        $(this).find('.fa').addClass('animated pulse');
    });
    $('.do-img-link-single').live("mouseleave", function () {
        $(this).find('.fa').removeClass('animated pulse');
    });

    // Comment Reply link
    // -----------------------------------------------------------------------------
    $('.comments .comment').on('mouseover', function(){
        $(this).addClass('hover');
        $(this).find('.comment-reply-link').addClass('btn-danger');
        $(this).find('.comment-reply-link').removeClass('btn-info');
        $(this).find('.comment-reply-link').addClass('animated fast fadeInRight');
    });
    $('.comments .comment').on('mouseleave', function(){
        $(this).removeClass('hover');
        $(this).find('.comment-reply-link').addClass('btn-info');
        $(this).find('.comment-reply-link').removeClass('btn-danger');
        $(this).find('.comment-reply-link').removeClass('animated fast fadeInRight');
    });

    // Placeholder [ie8]
    // -----------------------------------------------------------------------------
    if ($('html').hasClass('ie8') || $('html').hasClass('ie7') || $('html').hasClass('ie6')) {
        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
                input.removeClass('placeholder');
            }
        }).blur(function() {
                var input = $(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur().parents('form').submit(function() {
                $(this).find('[placeholder]').each(function() {
                    var input = $(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
    }

    // To Top Button
	$('.divider_block').each(function() {
		$(this).find('a.top').click(function(e){
				$('html, body').animate({scrollTop:0}, 500, 'easeOutQuart');
				e.preventDefault();
				return false;
			})
	});

	// Activate tooltips
    if ($("[rel=tooltip]").length) {
        $("[rel=tooltip]").tooltip();
    }

	// activates the tabs shortcode
	if(jQuery.fn.afl_tabs)
		jQuery('.tab-content').afl_tabs();

});


$(window).load(function() {

    // Accordion Settings
    $(function() {
        $('.accordion').on('shown.bs.collapse', function (e) {
            $(e.target).prev('.accordion-heading').find('i').removeClass('fa-plus');
            $(e.target).prev('.accordion-heading').find('i').addClass('fa-minus');
            $(e.target).prev('.accordion-heading').find('.accordion-toggle').removeClass('off');
            $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('on');
        });
        $('.accordion').on('hidden.bs.collapse', function (e) {
            $(e.target).prev('.accordion-heading').find('i').removeClass('fa-minus');
            $(e.target).prev('.accordion-heading').find('i').addClass('fa-plus');
            $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('off');
            $(e.target).prev('.accordion-heading').find('.accordion-toggle').removeClass('on');
        });
    });

});

// -------------------------------------------------------------------------------------------
// Sticky menu
/*
var header = $('#header');
var navigation = $("#navigation");
var container = $("body");
var scrolled = false;
var wpadminbar = '';
if ($('body').hasClass('admin-bar')) {
    wpadminbar = 28;
} else {
    wpadminbar = 0;
}

function sticky_menu(e) {
    // check windows width
    if ($(window).innerWidth() < 992) {
        $(header).addClass('small-size');
    }
    else {
        $(header).removeClass('small-size');
    }
    // upadate menu position on resize if visible
    if (e == 'update') {
        if ($(window).innerWidth() < 992 && $(header).hasClass('visible')) {
            $(header).css('top', 0 + wpadminbar);
        }
        if ($(window).innerWidth() > 991 && $(header).hasClass('visible')) {
            $(header).css('top', -(header.height() - navigation.height()) + wpadminbar);
        }
    }
    // show/hide menu on scroll down/up
    else {
        if (header.height() < $(window).scrollTop() && !scrolled) {
            header.addClass('visible');
            container.css('padding-top', header.height());
            if (header.hasClass('small-size')) {
                header.stop().animate({ top: 0 + wpadminbar, opacity: 0.9 });
            }
            else {
                header.stop().animate({ top: -(header.height() - navigation.height()) + wpadminbar, opacity: 0.9 });
            }
            scrolled = true;
        }
        if (header.height() > $(window).scrollTop() && scrolled) {
            header.stop().animate({ top: -(header.height() + wpadminbar) }, {
                duration: 200,
                complete: function () {
                    header.removeClass('visible').removeAttr('style').css('opacity', 0);
                    container.removeAttr('style');
                    header.animate({opacity: 1}, 200);
                }
            });
            scrolled = false;
        }
    }
}

$(window).resize(function () {
    sticky_menu('update');
});

$(window).scroll(function () {
    sticky_menu();
});
*/
// -------------------------------------------------------------------------------------------
// Isotope

$(window).resize(function () {
    // relayout on window resize
    $('.isotope').isotope('reLayout');
});

$(document).ready(function () {
    // activate isotope
    $('.isotope').isotope({
        // options
        itemSelector: '.isotope-item'
    });
    // Portfolio filtering / cache container
    var $container = $('section.filtrable');
    // filter items when filter link is clicked
    $('#filtrable a').click(function () {
        $("#filtrable li").removeClass("current");
        $(this).parent().addClass("current");
        var selector = $(this).attr('data-filter');
        $container.isotope({ filter: selector }, sizeContent);
        return false;
    });
    // Portfolio SC
    beautifyPortfolio();
});

// -------------------------------------------------------------------------------------------
// create mobile menu from exist superfish menu

$(document).ready(function () {
    var $menu = $('#navigation > ul'),
        optionsList = '<option value="" selected> - - Main Navigation - - </option>';

    $menu.find('li').each(function () {
        var $this = $(this),
            $anchor = $this.children('a'),
            depth = $this.parents('ul').length - 1,
            indent = '';

        if (depth) {
            while (depth > 0) {
                indent += ' ::: ';
                depth--;
            }
        }

        optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
    }).end().parent().parent().find('#res-menu').append('<select class="res-menu">' + optionsList + '</select><div class="res-menu-title">Navigation <i class="fa fa-angle-down"></i></div>');

    var $topmenu = $('#top-menu > ul'),
        optionsListTm = '<option value="" selected></option>';
        optionsListTm += '<option value="" selected> - - Top Navigation - - </option>';

    $topmenu.find('li').each(function () {
        var $this = $(this),
            $anchor = $this.children('a'),
            depth = $this.parents('ul').length - 1,
            indent = '';

        if (depth) {
            while (depth > 0) {
                indent += ' ::: ';
                depth--;
            }
        }
        optionsListTm += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
    }).end().parent().parent().find('#res-menu select').append('' + optionsListTm + '');

    $('.res-menu').on('change', function () {
        window.location = $(this).val();
    });

    // Toggle Sidebar Menu/Widget
    $('.side_menu').css('display', 'block'); // hide
    $('.side_menu_button, .side_menu_close').on('click', function (){
        $('.wrapper').toggleClass('open');
    });

});

// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------

/* UItoTop jQuery Plugin 1.2 | Matt Varone | http://www.mattvarone.com/web-design/uitotop-jquery-plugin */
(function($){$.fn.UItoTop=function(options){var defaults={text:'To Top',min:200,inDelay:600,outDelay:400,containerID:'toTop',containerHoverID:'toTopHover',scrollSpeed:1200,easingType:'linear'},settings=$.extend(defaults,options),containerIDhash='#'+settings.containerID,containerHoverIDHash='#'+settings.containerHoverID;$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');$(containerIDhash).hide().on('click.UItoTop',function(){$('html, body').animate({scrollTop:0},settings.scrollSpeed,settings.easingType);$('#'+settings.containerHoverID,this).stop().animate({'opacity':0},settings.inDelay,settings.easingType);return false;}).prepend('<span id="'+settings.containerHoverID+'"></span>').hover(function(){$(containerHoverIDHash,this).stop().animate({'opacity':1},600,'linear');},function(){$(containerHoverIDHash,this).stop().animate({'opacity':0},700,'linear');});$(window).scroll(function(){var sd=$(window).scrollTop();if(typeof document.body.style.maxHeight==="undefined"){$(containerIDhash).css({'position':'absolute','top':sd+$(window).height()-50});}
    if(sd>settings.min)
        $(containerIDhash).fadeIn(settings.inDelay);else
        $(containerIDhash).fadeOut(settings.Outdelay);});};})(jQuery);

/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
;(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,e,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);

/**
 * jQuery.LocalScroll - Animated scrolling navigation, using anchors.
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 3/11/2009
 * @author Ariel Flesler
 * @version 1.2.7
 **/
;(function($){var l=location.href.replace(/#.*/,'');var g=$.localScroll=function(a){$('body').localScroll(a)};g.defaults={duration:1e3,axis:'y',event:'click',stop:true,target:window,reset:true};g.hash=function(a){if(location.hash){a=$.extend({},g.defaults,a);a.hash=false;if(a.reset){var e=a.duration;delete a.duration;$(a.target).scrollTo(0,a);a.duration=e}i(0,location,a)}};$.fn.localScroll=function(b){b=$.extend({},g.defaults,b);return b.lazy?this.bind(b.event,function(a){var e=$([a.target,a.target.parentNode]).filter(d)[0];if(e)i(a,e,b)}):this.find('a,area').filter(d).bind(b.event,function(a){i(a,this,b)}).end().end();function d(){return!!this.href&&!!this.hash&&this.href.replace(this.hash,'')==l&&(!b.filter||$(this).is(b.filter))}};function i(a,e,b){var d=e.hash.slice(1),f=document.getElementById(d)||document.getElementsByName(d)[0];if(!f)return;if(a)a.preventDefault();var h=$(b.target);if(b.lock&&h.is(':animated')||b.onBefore&&b.onBefore.call(b,a,f,h)===false)return;if(b.stop)h.stop(true);if(b.hash){var j=f.id==d?'id':'name',k=$('<a> </a>').attr(j,d).css({position:'absolute',top:$(window).scrollTop(),left:$(window).scrollLeft()});f[j]='';$('body').prepend(k);location=e.hash;k.remove();f[j]=d}h.scrollTo(f,b).trigger('notify.serialScroll',[f])}})(jQuery);

/*
 * JQuery URL Parser plugin, v2.2.1
 * Developed and maintanined by Mark Perkins, mark@allmarkedup.com
 * Source repository: https://github.com/allmarkedup/jQuery-URL-Parser
 * Licensed under an MIT-style license. See https://github.com/allmarkedup/jQuery-URL-Parser/blob/master/LICENSE for details.
 */
;(function(a){if(typeof define==="function"&&define.amd){if(typeof jQuery!=="undefined"){define(["jquery"],a)}else{define([],a)}}else{if(typeof jQuery!=="undefined"){a(jQuery)}else{a()}}})(function(b,e){var q={a:"href",img:"src",form:"action",base:"href",script:"src",iframe:"src",link:"href"},t=["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","fragment"],p={anchor:"fragment"},a={strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*):?([^:@]*))?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/},l=Object.prototype.toString,s=/^[0-9]+$/;function o(u,x){var z=decodeURI(u),w=a[x||false?"strict":"loose"].exec(z),y={attr:{},param:{},seg:{}},v=14;while(v--){y.attr[t[v]]=w[v]||""}y.param.query=f(y.attr.query);y.param.fragment=f(y.attr.fragment);y.seg.path=y.attr.path.replace(/^\/+|\/+$/g,"").split("/");y.seg.fragment=y.attr.fragment.replace(/^\/+|\/+$/g,"").split("/");y.attr.base=y.attr.host?(y.attr.protocol?y.attr.protocol+"://"+y.attr.host:y.attr.host)+(y.attr.port?":"+y.attr.port:""):"";return y}function m(v){var u=v.tagName;if(typeof u!=="undefined"){return q[u.toLowerCase()]}return u}function c(x,w){if(x[w].length==0){return x[w]={}}var v={};for(var u in x[w]){v[u]=x[w][u]}x[w]=v;return v}function k(y,w,v,z){var u=y.shift();if(!u){if(g(w[v])){w[v].push(z)}else{if("object"==typeof w[v]){w[v]=z}else{if("undefined"==typeof w[v]){w[v]=z}else{w[v]=[w[v],z]}}}}else{var x=w[v]=w[v]||[];if("]"==u){if(g(x)){if(""!=z){x.push(z)}}else{if("object"==typeof x){x[j(x).length]=z}else{x=w[v]=[w[v],z]}}}else{if(~u.indexOf("]")){u=u.substr(0,u.length-1);if(!s.test(u)&&g(x)){x=c(w,v)}k(y,x,u,z)}else{if(!s.test(u)&&g(x)){x=c(w,v)}k(y,x,u,z)}}}}function d(y,x,B){if(~x.indexOf("]")){var A=x.split("["),u=A.length,z=u-1;k(A,y,"base",B)}else{if(!s.test(x)&&g(y.base)){var w={};for(var v in y.base){w[v]=y.base[v]}y.base=w}i(y.base,x,B)}return y}function f(u){return h(String(u).split(/&|;/),function(v,A){try{A=decodeURIComponent(A.replace(/\+/g," "))}catch(x){}var B=A.indexOf("="),z=n(A),w=A.substr(0,z||B),y=A.substr(z||B,A.length),y=y.substr(y.indexOf("=")+1,y.length);if(""==w){w=A,y=""}return d(v,w,y)},{base:{}}).base}function i(x,w,y){var u=x[w];if(e===u){x[w]=y}else{if(g(u)){u.push(y)}else{x[w]=[u,y]}}}function n(x){var u=x.length,w,y;for(var v=0;v<u;++v){y=x[v];if("]"==y){w=false}if("["==y){w=true}if("="==y&&!w){return v}}}function h(y,v){var w=0,u=y.length>>0,x=arguments[2];while(w<u){if(w in y){x=v.call(e,x,y[w],w,y)}++w}return x}function g(u){return Object.prototype.toString.call(u)==="[object Array]"}function j(v){var u=[];for(prop in v){if(v.hasOwnProperty(prop)){u.push(prop)}}return u}function r(u,v){if(arguments.length===1&&u===true){v=true;u=e}v=v||false;u=u||window.location.toString();return{data:o(u,v),attr:function(w){w=p[w]||w;return typeof w!=="undefined"?this.data.attr[w]:this.data.attr},param:function(w){return typeof w!=="undefined"?this.data.param.query[w]:this.data.param.query},fparam:function(w){return typeof w!=="undefined"?this.data.param.fragment[w]:this.data.param.fragment},segment:function(w){if(typeof w==="undefined"){return this.data.seg.path}else{w=w<0?this.data.seg.path.length+w:w-1;return this.data.seg.path[w]}},fsegment:function(w){if(typeof w==="undefined"){return this.data.seg.fragment}else{w=w<0?this.data.seg.fragment.length+w:w-1;return this.data.seg.fragment[w]}}}}if(typeof b!=="undefined"){b.fn.url=function(v){var u="";if(this.length){u=b(this).attr(m(this[0]))||""}return r(u,v)};b.url=r}else{window.purl=r}});

/*
 * jQuery hashchange event - v1.3 - 7/21/2010
 * http://benalman.com/projects/jquery-hashchange-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($,e,b){var c="hashchange",h=document,f,g=$.event.special,i=h.documentMode,d="on"+c in e&&(i===b||i>7);function a(j){j=j||location.href;return"#"+j.replace(/^[^#]*#?(.*)$/,"$1")}$.fn[c]=function(j){return j?this.bind(c,j):this.trigger(c)};$.fn[c].delay=50;g[c]=$.extend(g[c],{setup:function(){if(d){return false}$(f.start)},teardown:function(){if(d){return false}$(f.stop)}});f=(function(){var j={},p,m=a(),k=function(q){return q},l=k,o=k;j.start=function(){p||n()};j.stop=function(){p&&clearTimeout(p);p=b};function n(){var r=a(),q=o(m);if(r!==m){l(m=r,q);$(e).trigger(c)}else{if(q!==m){location.href=location.href.replace(/#.*/,"")+q}}p=setTimeout(n,$.fn[c].delay)}$.browser.msie&&!d&&(function(){var q,r;j.start=function(){if(!q){r=$.fn[c].src;r=r&&r+a();q=$('<iframe tabindex="-1" title="empty"/>').hide().one("load",function(){r||l(a());n()}).attr("src",r||"javascript:0").insertAfter("body")[0].contentWindow;h.onpropertychange=function(){try{if(event.propertyName==="title"){q.document.title=h.title}}catch(s){}}}};j.stop=k;o=function(){return a(q.location.href)};l=function(v,s){var u=q.document,t=$.fn[c].domain;if(v!==s){u.title=h.title;u.open();t&&u.write('<script>document.domain="'+t+'"<\/script>');u.close();q.location.hash=v}}})();return j})()})(jQuery,this);

// -------------------------------------------------------------------------------------------
// Do not modify below unless you know what you are doing
// -------------------------------------------------------------------------------------------

var header = $('#header'); //
var navigation = $("#navigation"); //
var wpadminbar = ''; //

//var header_height = $("#header").outerHeight(); //119;
var header_height = header.height() - navigation.height();

$(document).ready(function () {

    // Scrollspy
    $('body').scrollspy({
        target: '.navbar', //, offset: header_height//+5
        offset: 0 - wpadminbar - header_height
    });

    // SmoothScroll
    $('header.navbar, .localscroll').localScroll({
        easing: 'easeInOutExpo',
        hash: true, //, offset : -header_height
        offset: 0 - wpadminbar - header_height
    });

    update_page_height('section.page');
    $(window).resize(function (e) {
        update_page_height('section.page');
        update_scrollspy();
    });

    // URI Listener
    uri();
    $(window).hashchange(function () {
        uri();
    });

    // Start Google Maps
    if ($('#contact_map').length > 0) startGmap();
});


// History
function uri()
{
    var url = $.url();
    hash_param = url.fsegment(1);

    category = '*';
    portfolio_curent_page = 1;
    portfolio_scroll = false;
    blog_scroll = false;

    if (hash_param == 'portfolio')
    {

        category = url.fsegment(2);

        if (url.fsegment(2) != '*')
        {
            category = '.category-' + url.fsegment(2);
        }

        portfolio_curent_page = url.fsegment(3);
        portfolio_scroll = true;

        portfolio_items(portfolio_items_page, portfolio_curent_page, portfolio_total_items, category, portfolio_scroll);
    }

    else if (hash_param == 'posts')
    {

        blog_curent_page = url.fsegment(2);
        blog_scroll = true;

        blog_items(blog_items_page, blog_curent_page, blog_total_items, blog_scroll);
    }


}

// Update Scrollspy
function update_scrollspy() {
    $('[data-spy="scroll"]').each(function () {
        var $spy = $(this).scrollspy('refresh');
    });
    $('body').scrollspy('refresh');
}

function update_page_height(element) {
    $(element).each(function (index) {
        padding = ($(this).outerHeight(true) - $(this).height());
        if ($(this).hasClass('home')) {
            padding -= 120;
        }
        $(this).css({ 'min-height': $(window).height() - (padding + header_height) });
    });
}

// Dynamically assign height
$(document).ready(sizeContent);
$(window).resize(sizeContent);
function sizeContent() {

    // check for wp-admin bar
    var adminBar = 0;
    if ($("body").hasClass("admin-bar")) {
        adminBar = $("#wpadminbar").outerHeight();
    }

    if ($(window).height() > $("html").height()) {
        //var newHeight = $(window).height() - 88 - adminBar - $("#footer").outerHeight() - $("#footer-menu").outerHeight() + "px";
        var newHeight = $(window).height() - 0 - adminBar - $("#footer").outerHeight() - $("#footer-menu").outerHeight() - header.outerHeight() + "px";
        $("#container").css("min-height", newHeight);
    } else {
        var newHeight = $(window).height() - 0 - adminBar - $("#footer").outerHeight() - $("#footer-menu").outerHeight() - header.outerHeight() + "px";
        $("#container").css("min-height", newHeight);
    }
}

// -------------------------------------------------------------------------------------------
// Google Maps
// -------------------------------------------------------------------------------------------

// Point 1
var google_maps_latitude = 34.381979;
var google_maps_longitude = -118.251343;

// Point 2 (Set to null if you want to disable)
var google_maps_latitude_2 = null;
var google_maps_longitude_2 = null;

// Circle color
var google_maps_circle_color = '#FB5642';

// Landscape color
var google_maps_landscape_color = '#C0EDF5';

// Water color
var google_maps_water_color = '#94E1EE';

// Google Maps
function startGmap(){var n={zoom:4,center:new google.maps.LatLng(google_maps_latitude,google_maps_longitude),navigationControlOptions:{style:google.maps.NavigationControlStyle.NORMAL,position:google.maps.ControlPosition.RIGHT_TOP},streetViewControl:false,scrollwheel:false,zoomControl:true,zoomControlOptions:{style:google.maps.ZoomControlStyle.DEFAULT,position:google.maps.ControlPosition.RIGHT_TOP},mapTypeControl:false,mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU,position:google.maps.ControlPosition.TOP_RIGHT,mapTypeIds:["ptMap"]}};map=new google.maps.Map(document.getElementById("contact_map"),n);var j=[{featureType:"administrative",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"landscape",elementType:"all",stylers:[{color:google_maps_landscape_color},{visibility:"on"}]},{featureType:"poi",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"all",stylers:[{visibility:"on"},{lightness:-30}]},{featureType:"transit",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"water",elementType:"all",stylers:[{color:google_maps_water_color}]}];var m={name:"Map"};var l=new google.maps.StyledMapType(j,m);map.mapTypes.set("ptMap",l);map.setMapTypeId("ptMap");var k={path:google.maps.SymbolPath.CIRCLE,fillOpacity:0.75,fillColor:google_maps_circle_color,strokeOpacity:1,strokeColor:google_maps_circle_color,strokeWeight:1,scale:10};var q=new google.maps.LatLng(google_maps_latitude,google_maps_longitude);var p=new google.maps.Marker({position:q,map:map,zIndex:99999,optimized:false,icon:k});if(google_maps_latitude_2&&google_maps_longitude_2){var i={path:google.maps.SymbolPath.CIRCLE,fillOpacity:0.75,fillColor:google_maps_circle_color,strokeOpacity:1,strokeColor:google_maps_circle_color,strokeWeight:1,scale:10};var h=new google.maps.LatLng(google_maps_latitude_2,google_maps_longitude_2);var o=new google.maps.Marker({position:h,map:map,zIndex:99999,optimized:false,icon:i})}};
