
var switchSpecialEditors = {

    mode : '',

    I : function(e) {
        return document.getElementById(e);
    },

    _wp_Nop : function(content) {
        var blocklist1, blocklist2;

        // Protect pre|script tags
        content = content.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
            a = a.replace(/<br ?\/?>[\r\n]*/g, '<wp_temp>');
            return a.replace(/<\/?p( [^>]*)?>[\r\n]*/g, '<wp_temp>');
        });

        // Pretty it up for the source editor
        blocklist1 = 'blockquote|ul|ol|li|table|thead|tbody|tfoot|tr|th|td|div|h[1-6]|p|fieldset';
        content = content.replace(new RegExp('\\s*</('+blocklist1+')>\\s*', 'g'), '</$1>\n');
        content = content.replace(new RegExp('\\s*<(('+blocklist1+')[^>]*)>', 'g'), '\n<$1>');

        // Mark </p> if it has any attributes.
        content = content.replace(/(<p [^>]+>.*?)<\/p>/g, '$1</p#>');

        // Sepatate <div> containing <p>
        content = content.replace(/<div([^>]*)>\s*<p>/gi, '<div$1>\n\n');

        // Remove <p> and <br />
        content = content.replace(/\s*<p>/gi, '');
        content = content.replace(/\s*<\/p>\s*/gi, '\n\n');
        content = content.replace(/\n[\s\u00a0]+\n/g, '\n\n');
        content = content.replace(/\s*<br ?\/?>\s*/gi, '\n');

        // Fix some block element newline issues
        content = content.replace(/\s*<div/g, '\n<div');
        content = content.replace(/<\/div>\s*/g, '</div>\n');
        content = content.replace(/\s*\[caption([^\[]+)\[\/caption\]\s*/gi, '\n\n[caption$1[/caption]\n\n');
        content = content.replace(/caption\]\n\n+\[caption/g, 'caption]\n\n[caption');

        blocklist2 = 'blockquote|ul|ol|li|table|thead|tbody|tfoot|tr|th|td|h[1-6]|pre|fieldset';
        content = content.replace(new RegExp('\\s*<(('+blocklist2+') ?[^>]*)\\s*>', 'g'), '\n<$1>');
        content = content.replace(new RegExp('\\s*</('+blocklist2+')>\\s*', 'g'), '</$1>\n');
        content = content.replace(/<li([^>]*)>/g, '\t<li$1>');

        if ( content.indexOf('<object') != -1 ) {
            content = content.replace(/<object[\s\S]+?<\/object>/g, function(a){
                return a.replace(/[\r\n]+/g, '');
            });
        }

        // Unmark special paragraph closing tags
        content = content.replace(/<\/p#>/g, '</p>\n');
        content = content.replace(/\s*(<p [^>]+>[\s\S]*?<\/p>)/g, '\n$1');

        // Trim whitespace
        content = content.replace(/^\s+/, '');
        content = content.replace(/[\s\u00a0]+$/, '');

        // put back the line breaks in pre|script
        content = content.replace(/<wp_temp>/g, '\n');

        return content;
    },

    go : function(id, mode) {
        id = id;
        mode = mode || this.mode || '';

        var ed, H = this.I('edSideButtonHTML'), P = this.I('edSideButtonPreview'), ta = this.I(id);

        try {
            ed = tinyMCE.get(id);
        }
        catch(e) {
            ed = false;
        }

        if ( 'tinymce' == mode ) {
            if ( ed && ! ed.isHidden() )
                return false;

            //setUserSetting( 'editor', 'tinymce' );
            this.mode = 'html';

            P.className = 'alignright active';
            H.className = 'alignright';
            edCloseAllTags(); // :-(

            ta.style.color = '#FFF';
            ta.value = this.wpautop(ta.value);

            try {
                if ( ed )
                    ed.show();
                else
                    tinyMCE.execCommand("mceAddControl", false, id);
            } catch(e) {}

            ta.style.color = '#000';
        } else {
            //setUserSetting( 'editor', 'html' );
            ta.style.color = '#000';
            this.mode = 'tinymce';
            H.className = 'alignright active';
            P.className = 'alignright';

            if ( ed && !ed.isHidden() ) {
                ta.style.height = ed.getContentAreaContainer().offsetHeight + 24 + 'px';
                ed.hide();
            }

        }
        return false;
    },

    _wp_Autop : function(pee) {
        var blocklist = 'table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|blockquote|address|math|p|h[1-6]|fieldset|legend';

        if ( pee.indexOf('<object') != -1 ) {
            pee = pee.replace(/<object[\s\S]+?<\/object>/g, function(a){
                return a.replace(/[\r\n]+/g, '');
            });
        }

        pee = pee.replace(/<[^<>]+>/g, function(a){
            return a.replace(/[\r\n]+/g, ' ');
        });

        pee = pee + '\n\n';
        pee = pee.replace(/<br \/>\s*<br \/>/gi, '\n\n');
        pee = pee.replace(new RegExp('(<(?:'+blocklist+')[^>]*>)', 'gi'), '\n$1');
        pee = pee.replace(new RegExp('(</(?:'+blocklist+')>)', 'gi'), '$1\n\n');
        pee = pee.replace(/\r\n|\r/g, '\n');
        pee = pee.replace(/\n\s*\n+/g, '\n\n');
        pee = pee.replace(/([\s\S]+?)\n\n/g, '<p>$1</p>\n');
        pee = pee.replace(/<p>\s*?<\/p>/gi, '');
        pee = pee.replace(new RegExp('<p>\\s*(</?(?:'+blocklist+')[^>]*>)\\s*</p>', 'gi'), "$1");
        pee = pee.replace(/<p>(<li.+?)<\/p>/gi, '$1');
        pee = pee.replace(/<p>\s*<blockquote([^>]*)>/gi, '<blockquote$1><p>');
        pee = pee.replace(/<\/blockquote>\s*<\/p>/gi, '</p></blockquote>');
        pee = pee.replace(new RegExp('<p>\\s*(</?(?:'+blocklist+')[^>]*>)', 'gi'), "$1");
        pee = pee.replace(new RegExp('(</?(?:'+blocklist+')[^>]*>)\\s*</p>', 'gi'), "$1");
        pee = pee.replace(/\s*\n/gi, '<br />\n');
        pee = pee.replace(new RegExp('(</?(?:'+blocklist+')[^>]*>)\\s*<br />', 'gi'), "$1");
        pee = pee.replace(/<br \/>(\s*<\/?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)>)/gi, '$1');
        pee = pee.replace(/(?:<p>|<br ?\/?>)*\s*\[caption([^\[]+)\[\/caption\]\s*(?:<\/p>|<br ?\/?>)*/gi, '[caption$1[/caption]');

        pee = pee.replace(/(<(?:div|th|td|form|fieldset|dd)[^>]*>)(.*?)<\/p>/g, function(a, b, c) {
            if ( c.match(/<p( [^>]+)?>/) )
                return a;

            return b + '<p>' + c + '</p>';
        });

        // Fix the pre|script tags
        pee = pee.replace(/<(pre|script)[^>]*>[\s\S]+?<\/\1>/g, function(a) {
            a = a.replace(/<br ?\/?>[\r\n]*/g, '\n');
            return a.replace(/<\/?p( [^>]*)?>[\r\n]*/g, '\n');
        });

        return pee;
    },

    pre_wpautop : function(content) {
        var t = this, o = {
            o: t, 
            data: content, 
            unfiltered: content
        };

        jQuery('body').trigger('beforePreWpautop', [o]);
        o.data = t._wp_Nop(o.data);
        jQuery('body').trigger('afterPreWpautop', [o]);
        return o.data;
    },

    wpautop : function(pee) {
        var t = this, o = {
            o: t, 
            data: pee, 
            unfiltered: pee
        };

        jQuery('body').trigger('beforeWpautop', [o]);
        o.data = t._wp_Autop(o.data);
        jQuery('body').trigger('afterWpautop', [o]);
        return o.data;
    }
};

function afl_theme_base($){
    return $('#afl_metabox_composer_base').find('input[name=afl_theme_base]').val() + '/lib';
}

function afl_uploader(el){
    var elid = el.attr('id');
    var withthumbs = false;
    if(el.hasClass('with_thumbs')){
        withthumbs = 'true';
    }

    new AjaxUpload(elid, {
        action: ajaxurl,
        name: elid,
        data: {
            action: 'afl_ajax_upload_action', 
            type: 'image_upload', 
            id: elid, 
            dothumbs:withthumbs
        },
        autoSubmit: true,
        responseType: 'json',
        onChange: function(file, extension){},
        onSubmit: function(file, extension){
            this.disable();
            el.parent().parent().append('<div class="file-preloader"></div>');
        },
        onComplete: function(file, response) {
            this.enable();
            el.parent().parent().find('.file-preloader').remove();
            if(response.status == 0){
                el.prevAll('input').first().css('border', '1px solid red');
                el.prevAll('input').first().attr('title', response.data);
            }
            else{
                el.prevAll('input').first().val(response.data);
                if(withthumbs){
                    var preview = el.parents('.afl-section:first').next();
                    preview.find(':hidden').val(response.thumb);
                    var img = preview.find('img');
                    var link = preview.find('a[rel="prettyPhoto"]');
                    if(img.length == 0){
                        jQuery('<img>').attr('src', response.thumb).attr('height', 35).appendTo(preview.find(".afl-style-wrap"));
                    }else{
                        img.attr('src', response.thumb);
                    }
                    if(link.length != 0)
                        link.attr('href', response.data);
                }
            }
        }
    });
}

function afl_refresh_composer($){
    $('#afl-composer-base-items li').each(function(index,element){
        $(element).find('input:hidden, textarea').each(function(){
            var name = $(this).attr('name');
            $(this).attr('name', name.replace(/\d+/, index));
            if(name.search('itemattached') != -1){
                if($(element).parent('ul.composer-sidebar-items').length!=0){
                    $(this).val('true');
                }
                else{
                    $(this).val('');
                }
            }
        });
    });
    
}

jQuery(document).ready(function($){
    $('.afl_link_controller').afl_prefill_options();

    $("a[rel^='prettyPhoto']").prettyPhoto();

    if($('#afl_metabox_composer_base input[name=afl_composer]').length){
        $('#titlediv').after($('#afl_metabox_composer_base div.logo-container'));
    }
    var vv = parseInt($('#afl-theme-tab').val());
    $('#afl-theme-options').tabs().tabs("option", "active" ,(vv!=Number.NaN?vv:0)).tabs({
        select:function(event, ui){
            $('#afl-theme-tab').val($(ui).get(0).index)
        }
    });
    $('.afl-uploader').each(function(){
        afl_uploader($(this));
    });
    $('.image_upload_wthb_button').each(function(){
        afl_uploader($(this));
    });


    $('#afl-composer-base-items').sortable({
        connectWith:'ul.composer-sidebar-items',
        update: function(event, ui) {
            afl_refresh_composer($);
        },
        stop: function(event, ui) {
            if($(ui.item).hasClass('sidebar')&&$(ui.item).parent().hasClass('composer-sidebar-items')){
                $(this).sortable('cancel');
            }
        }/*, stop: function(event, ui) {$(this).sortable('cancel')}*/
    });
    $('ul.composer-sidebar-items').sortable({
        connectWith:'#afl-composer-base-items', 
        update: function(event, ui) {
            afl_refresh_composer($);
        },
        placeholder: 'ui-state-highlight'
    });//if($(ui.item).hasClass('sidebar')){$(this).sortable('disable');console.log('disabled')}
    $('#afl-composer-base-items').find('.afl-with-itrash').live('click',function(e){
        e.preventDefault();
        if(window.confirm('Are you sure?')){
            $(this).parents('li:first').remove();
            afl_refresh_composer($);
        }
    });
    $('#afl-composer-base-items .afl-advance').live('click',function(e){
        $('#afl-composer-base-items').hide();
        $('.right-side-cell').hide();
        $('.left-side-cell').css({
            'border-width':'0'
        });
        var index = $('#afl-composer-base-items .afl-advance').index($(this));
        var src = $('#afl-composer-base-items li:nth-child('+(index+1)+')');
        $('#afl-composer-base-items').after('<div id="afl-wrapping-setup"><h4>Wrapping</h4>'+
            '<div class="ui-widget"><div class="ui-state-error ui-corner-all"><p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span><strong>Alert:</strong> Just for advanced users.</p></div></div>' +
            '<label><h5>Before code:</h5><textarea name="tempprefix['+index+']" cols="50" rows="5">'+src.find('textarea[name^=itemprefix]').val()+'</textarea></label>' +
            '<label><h5>After code:</h5><textarea name="tempsuffix['+index+']" cols="50" rows="5">'+src.find('textarea[name^=itemsuffix]').val()+'</textarea></label>' +
            '<div style="padding-top:20px;"><span><a href="#" class="button-primary afl-wrap-save" style="margin-right:10px;">Save</a></span><span><a href="#" class="button afl-wrap-cancel">Cancel</a></span></div></div>');
    });
    $('#afl-wrapping-setup a.afl-wrap-save').live('click',function(e){
        e.preventDefault();
        var index = parseInt($('#afl-wrapping-setup textarea:first').attr('name').match(/\d+/));
        var trg = $('#afl-composer-base-items li:nth-child('+(index+1)+')');
        trg.find('textarea[name^=itemprefix]').val($('#afl-wrapping-setup textarea[name="tempprefix['+index+']"]').val());
        trg.find('textarea[name^=itemsuffix]').val($('#afl-wrapping-setup textarea[name="tempsuffix['+index+']"]').val());
        $('#afl-wrapping-setup').remove();
        $('#afl-composer-base-items').show();
        $('.right-side-cell').show()
        $('.left-side-cell').css({
            'border-width':'1px'
        });
    });
    $('#afl-wrapping-setup a.afl-wrap-cancel').live('click',function(e){
        e.preventDefault();
        $('#afl-wrapping-setup').remove();
        $('#afl-composer-base-items').show();
        $('.right-side-cell').show();
        $('.left-side-cell').css({
            'border-width':'1px'
        });
    });
    $('#afl-composer-base-items').find('.afl-with-ipencil').live('click',function(e){

        $('html, body').animate({
            scrollTop: '0px'
        }, 'fast');
        var data = $(this).parents('li').find(':hidden').serialize();
        $('#afl-composer-base-items').hide();
        $('.right-side-cell').hide();
        $('.left-side-cell').css({
            'border-width':'0'
        });
        $('#afl-loader').show();
        $.post(    afl_theme_base($) + '/edit-composer-item.php',
            data,
            function(data){
                var i = Math.round(Math.random()*1000000);
                $('#afl-loader').hide();
                $('#afl-composer-base-items').after(data);
                $('#afl-edit-composer-item-tabs').tabs().tabs("option", "active" ,0);
                $('#afl-edit-composer-item-slides').tabs({
                    cache: true,
                    add: function(event, ui) {
                        aflLastSlideId++;
                        $('#afl-edit-composer-item-slides a.afl-delete-slide').removeClass('button-disabled');
                        $('#afl-edit-composer-item-slides').tabs( "option", "active" , $('#afl-edit-composer-item-slides').tabs("length")-1 );
                    },
                    load: function(event, ui){
                        $(ui.panel.children).find('textarea.afl-wysiwyg').each(function(){

                            var id = $(this).attr('id');
                            if (!id){
                                id = 'customEditor-' + i;
                                $(this).attr('id',id);
                            }
                            tinyMCE.execCommand('mceAddControl', false, id);
                            i++;
                        });
                    }
                });
                if(typeof aflLastSlideId !== "undefined"){
                    $('#afl-edit-composer-item-slides').tabs("option", "active" ,jQuery('#afl-content-types').val()==''?0:aflLastSlideId);
                }
                            
                $('#afl-edit-composer-item-form textarea.afl-wysiwyg').each(function(){

                    var id = $(this).attr('id');
                    if (!id){
                        id = 'customEditor-' + i;
                        $(this).attr('id',id);
                    }
                    tinyMCE.execCommand('mceAddControl', false, id);
                    i++;
                    $("span.mceEditor table.mceLayout").css("height", "").css("min-height", "203px");
                });
                $('#afl-edit-composer-item-form a.afl-wysiwyg-add-image').attr('href', userSettings.url+'wp-admin/media-upload.php?post_id='+$('#post_ID').val()+'&type=image&TB_iframe=1&width=640&height=774');
                $('#afl-edit-composer-item-form .afl-uploader').each(function(){
                    afl_uploader($(this));
                });
            },
            'html');
    });

    $('#afl-composer-toolbox-items').accordion({
        header: "strong", 
        active:false, 
        collapsible: true
    }).find('div>a').bind('click', function (event){
        event.preventDefault();
        var next_id = $('#afl-composer-base-items li').length;
        var type = $(this).parent().attr('id').replace('afl_','');
        var ul = '';
        if(type=='sidebar'){
            ul = '<ul class="composer-sidebar-items"></ul>';
        }
        $('#afl-composer-base-items').append('<li class="editor-item '+$(this).parent().attr('id').replace('afl_','')+'"><span></span><div class="left-side"><strong>'+$(this).html()+' <a href="#" class="text-name">Block Name</a></strong></div>'+
            '<input type="hidden" name="itemattached[' + next_id + ']">'+
            '<input type="hidden" name="itemdata[' + next_id + ']">'+
            '<input type="hidden" name="itemtype[' + next_id + ']" value="'+ type +'">'+
            '<input type="text" name="itemname[' + next_id + ']" style="display:none" value="Type element name..."/><a class="name-apply" style="display:none;">Yes</a>'+
            '<div class="right-side"><a href="#" class="wrapit afl-advance" title="Wrap It">Your Code</a><a href="#" title="Edit" class="edit afl-with-ipencil"></a><a href="#" class="delete afl-with-itrash" title="Delete"></a></div>'+ul+'</li>');
        $('#afl-composer-base-items ul.composer-sidebar-items').sortable({
            connectWith:'#afl-composer-base-items', 
            update: function(event, ui) {
                afl_refresh_composer($);
            },
            placeholder: 'ui-state-highlight'
        });
    });
	
	
    $('#afl-composer-base-items>li.editor-item a.name-apply').live('click',
        function(e){
            e.preventDefault();
            $(this).hide();
            var v = $(this).parents('li.editor-item').find('input[name^=itemname]').hide().val();
            if ( (v != 'Type element name...') && (v != '')){
                $(this).parents('li.editor-item').find('a.text-name').show().html(v);
            }
            else{
                $(this).parents('li.editor-item').find('a.text-name').show().html('Block Name');
            }
        }
        )
    //id-editor hide/show
    $('#afl-composer-base-items a.text-name').live('click', 
        function(e){
            e.preventDefault();
            $(this).hide();
            $(this).parents('li.editor-item').find('input[name^=itemname]').show().select().focus();
            $(this).parents('li.editor-item').find('a.name-apply').show();
        }
        )
    //switcher
    if($('#afl_metabox_composer_base')){
        function afl_composer_view(){
            //do init of wp editor
            if(getUserSetting( 'editor', 'tinymce' ) == 'html'){
                switchEditors.switchto(jQuery('#content-tmce').get(0));
            }
            $('.postarea').hide();
            $('#afl_metabox_composer_base').show();
            //$('#afl_metabox_composer_toolbox').show();
            $('p#composer-switch a:first').html('Switch to classic').removeClass('off').addClass('on');
            $('div.swich-button-container strong').html('Turbo Editor enabled. You can switch to classic editor');
            $('a#refresh-content').hide();
        }

        function afl_classic_view(){
            $('.postarea').show();
            $('#afl_metabox_composer_base').hide();
            //$('#afl_metabox_composer_toolbox').hide();
            //$('#titlediv').after('<div class="swich-button-container"></div>')
            $('div.logo-container div.swich-button-container strong').html('Turbo Editor disabled. You can switch to it');
            $('p#composer-switch a:first').html('Switch to TurboEditor').removeClass('on').addClass('off');
            $('a#refresh-content').show();
        }
        if($('#afl_metabox_composer_base input[name=afl_composer]').length){
            $('.swich-button-container').append('<p id="composer-switch"><a href="#" class="button-primary switch">Switch to TurboEditor</a></p>');
            $('.swich-button-container').parents('.logo-container').after('<p class="refresh-content"><a id="refresh-content" href="#" class="button-primary">Refresh TurboEditor</a></p>');
        }
        if( $('#afl_metabox_composer_base input[name=afl_composer]').val()=='on' ){
            afl_composer_view();
        }
        else{
            afl_classic_view();
        }
        $('p#composer-switch a:first').live('click', function(e){
            e.preventDefault();
            if ($('#afl_metabox_composer_base input[name=afl_composer]').val()=='on' ){
                afl_classic_view();
                $('#afl_metabox_composer_base input[name=afl_composer]').val('off');
            }
            else{
                afl_composer_view();
                $('#afl_metabox_composer_base input[name=afl_composer]').val('on');
            }
        });
        $('a#refresh-content').live('click', function(e){
            e.preventDefault();
            $.post( ajaxurl,
            {
                'action': 'afl_ajax_upload_action',
                'type':'get_composer_data',
                'post_ID':$('input#post_ID').val()
            },
            function(data){
                if ( typeof tinyMCE.getInstanceById != 'undefined' ) {
                    if(tinyMCE.getInstanceById('content')){
                        tinyMCE.execInstanceCommand('content', 'mceSetContent', false, data);
                    }
                }
                $('textarea#content').val(data);
            },
            'json'
            );
        });
    }

    //composer items

    $('#afl-edit-composer-item-form a.afl-cancel').live('click', function(e){
        e.preventDefault();
        $('#afl-edit-composer-item-form textarea.afl-wysiwyg').each(function(){
            if ( typeof tinyMCE.getInstanceById != 'undefined' ) {
                var ed = tinyMCE.getInstanceById($(this).attr('id'));
                if(ed){
                    tinyMCE.remove(ed);
                }
            }
        });
        $(this).parents('#afl-edit-composer-item-form').remove();

        $('#afl-composer-base-items').show();
        $('.right-side-cell').show()
        $('.left-side-cell').css({
            'border-width':'1px'
        });
    });

    $('#afl-edit-composer-item-form a.afl-save').live('click', function(e){
        e.preventDefault();
        $('#afl-composer-base-items').hide();
        $('.right-side-cell').hide()
        $('.left-side-cell').css({
            'border-width':'0'
        });
        $('#publish').hide();
        $('#afl-loader').show();
        var eds = $('#afl-edit-composer-item-form textarea.afl-wysiwyg');
        if(eds.length>0){
            tinyMCE.triggerSave();
        }
        eds.each(function(){
            if ( typeof tinyMCE.getInstanceById != 'undefined' ) {
                var ed = tinyMCE.getInstanceById("'"+$(this).attr('id')+"'");
                if(ed){
                    tinyMCE.remove(ed);
                }
            }
        });
        $.post( afl_theme_base($) + '/save-composer-item.php',
            $('#afl-edit-composer-item-form').find(':hidden,:text,:checkbox,textarea,select').serialize(),
            function(data){
                $('#afl-loader').hide();
                $('#publish').show();
                $('#afl-composer-base-items').show();
                $('.right-side-cell').show();
                $('.left-side-cell').css({
                    'border-width':'1px'
                });

                $('#afl_metabox_composer_base li:eq('+data.index+') > input[name^=itemdata]').val(data.data);
            },
            'json');
        $(this).parents('#afl-edit-composer-item-form').remove();
        $('#afl-composer-base-items').show();
        $('.right-side-cell').show();
        $('.left-side-cell').css({
            'border-width':'1px'
        });
    });

    //socials and images
    $('#afl-tab-social a.afl-social-add').bind('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.before(parent.clone(true));
        var prev = parent.prev();
        prev.find('a.afl-social-add').unbind('click').removeClass('afl-social-add').removeClass('afl-clone-set').addClass('afl-social-delete').addClass('afl-remove-set').html('Delete');
        
        parent.find(':text, select').each(function(){
            var re = /\d+/;
            var name = $(this).attr('name');
            var id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
        });

        parent.find(':text').each(function(){
            $(this).val('');
        });
    });

    // FONT REPLACE
    $('#afl-tab-fonts a.afl-font-add').live('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.after(parent.clone(false, false));
        var next = parent.next();
        parent.find('a.afl-font-add').unbind('click').removeClass('afl-font-add').removeClass('afl-clone-set').addClass('afl-font-delete').addClass('afl-remove-set').html('Delete');
        next.find('.afl-select-fake-val').css({
            'color' : '#000000'
        });
        var re = /\d+/;
        var new_id = '';

        next.find(':text, select').each(function(){
            var name = $(this).attr('name');
            id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            new_id = $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            if(name.indexOf('color')!= -1){
                $(this).val('#000000');
            }
            else{
                $(this).val('');
            }
        });
        $('.afl-colorpicker-style-wrap').afl_color_picker_activation();
    });

    //custom sidebars
    $('#afl-tab-sidebar a.afl-social-add').bind('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.before(parent.clone(true));
        var prev = parent.prev();
        prev.find('a.afl-social-add').unbind('click').removeClass('afl-social-add').removeClass('afl-clone-set').addClass('afl-social-delete').addClass('afl-remove-set').html('Delete');

        parent.find(':text').each(function(){
            var re = /\d+/;
            var name = $(this).attr('name');
            var id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            $(this).val('');
        });
    });

    // Background slides
    $('#afl-background-slides a.afl-social-add').bind('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('.afl-single-set:first');
        parent.before(parent.clone(true));
        var prev = parent.prev();
        prev.find('a.afl-social-add').unbind('click').removeClass('afl-social-add').removeClass('afl-clone-set').addClass('afl-social-delete').addClass('afl-remove-set').html('Delete');


        parent.find(':text,:hidden').each(function(){
            var re = /\d+/;
            var name = $(this).attr('name');
            var id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            if(id != undefined){
                $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            }
            $(this).val('');
        });
        parent.find('img').attr('src','http://dxthemes.com/images/noimage.png');
        parent.find('a').attr('href','http://dxthemes.com/images/noimage.png');
        afl_uploader(prev.find('.afl-uploader'));
    });

    $('div.slider a.afl-slider-image-add').live('click', function(e){
        e.preventDefault();
        var parent = $(this).parents('div:first');
        parent.before(parent.clone(true));
        var prev = parent.prev();
        prev.find('a.afl-slider-image-add').die('click').removeClass('afl-slider-image-add').removeClass('afl-clone-set').addClass('afl-slider-image-delete').addClass('afl-remove-set').html('Delete');
        

        parent.find(':text').each(function(){
            var re = /\d+/;
            var name = $(this).attr('name');
            var id = $(this).attr('id');
            $(this).attr('name', name.replace(re, parseInt(re.exec(name))+1));
            $(this).attr('id', id.replace(re, parseInt(re.exec(id))+1));
            $(this).val('');
        });
        afl_uploader(prev.find('.afl-uploader'));
    });
    $('#afl-tab-social a.afl-social-delete, .slider a.afl-slider-image-delete, #afl-tab-fonts a.afl-font-delete, #afl-tab-sidebar a.afl-social-delete, #custom-page-slides a.afl-social-delete').live('click', function(e){
        e.preventDefault();
        if(confirm('Are you sure?')){
            $(this).parents('.afl-single-set:first').remove();
        }
    });

    $('#afl-edit-composer-item-form a.afl-wysiwyg-add-image').live('click',function(){
        var aId = $(this).parent().next('textarea').attr('id');
        tinyMCE.execCommand('mceAddControl', false, aId);
        if ( typeof tinyMCE != 'undefined' && tinyMCE.activeEditor ) {
            tinyMCE.get(aId).focus();
            tinyMCE.activeEditor.windowManager.bookmark = tinyMCE.activeEditor.selection.getBookmark('simple');
        }
    })

    $('#afl-edit-composer-item-slides a.afl-add-slide').live('click',function(e){
        e.preventDefault();

        var type = $('#afl-edit-composer-item-form input:hidden[name=type]').val();
        $('#afl-edit-composer-item-slides').tabs( "add" , afl_theme_base($) + '/items/'+type+'.php?col_id=' + aflLastSlideId , 'Slide');
    });
    $('#afl-edit-composer-item-slides a.afl-delete-slide').live('click',function(e){
        e.preventDefault();
        var len = $('#afl-edit-composer-item-slides').tabs( "length" );
        if( len > 1 ){
            if(confirm('Are you sure?')){
                var cursel = $('#afl-edit-composer-item-slides').tabs( "option", "selected" );
                $('#afl-edit-item-tabs-content'+cursel).find('textarea.afl-wysiwyg').each(function(){
                    if ( typeof tinyMCE.getInstanceById != 'undefined' ) {
                        var ed = tinyMCE.getInstanceById($(this).attr('id'));
                        if(ed){
                            tinyMCE.remove(ed);
                        }
                    }
                });
                $('#afl-edit-composer-item-slides').tabs( "remove" , cursel );
            }
            if( --len > 0 ){
                $(this).addClass('button-disabled');
            }
        }
    });

    // Theme Options Navigation
    $(".afl-sidebar-content .afl-section-header").on('click', function($e){
        $this = $(this);
        $goto = "#afl-" + $(this).attr("id");
        if(!$($goto).hasClass("afl-active-container")){
            $(".afl-sidebar-content > div").each(function(i){
                if($(this).hasClass("afl-active-nav")) $(this).removeClass("afl-active-nav");
            });
            $(".afl-options-container > div").each(function(i){
                if($(this).hasClass("afl-active-container")) $(this).removeClass("afl-active-container");
            });
            $this.addClass("afl-active-nav");
            $($goto).addClass("afl-active-container");
        }
    });

    $(".afl-submit").on('click',function(i){
        i.preventDefault();
        $('#afl-form-options').submit();
    });

    $(".afl-background-submit").on('click',function(i){
        i.preventDefault();
        $(this).parents("form:first").submit();
    });

    $(".afl-remove-background").on('click',function(i){
        i.preventDefault();
        $(this).parents("form:first").submit();
    });

    $(".afl-reset-background").on('click',function(i){
        i.preventDefault();
        $(this).parents("form:first").submit();
    });

    //select dropdowns
    $('.afl-select-unify select').live('change', function()
    {
        var el = $(this);
        el.next('.afl-select-fake-val').text(el.find('option:selected').text());
    });

    $('.afl-select-unify.font-select select').live('change', function()
    {
        var el = $(this);
        el.next('.afl-select-fake-val').text(el.find('option:selected').text());
        el.next('.afl-select-fake-val').css({
            'font-family':el.find('option:selected').text()
        });
    });

    $('.afl-select-unify select').not('.afl-multiple-select select').each(function()
    {
        var el = $(this);
        el.css('opacity',0).next('.afl-select-fake-val').text(el.find('option:selected').text());
    });



});
