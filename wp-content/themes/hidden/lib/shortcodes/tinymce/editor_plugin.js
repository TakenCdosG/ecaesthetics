(function () {
    tinymce.create("tinymce.plugins.ShortcodeNinjaPlugin", {
        init: function (d, e) {
            d.addCommand("scnOpenDialog", function (a, c) {
                scnSelectedShortcodeType = c.identifier;
                jQuery.get(e + "/dialog.php", function (b) {
                    jQuery("#scn-dialog").remove();
                    jQuery("body").append(b);
                    jQuery("#scn-dialog").hide();
                    var f = jQuery(window).width();
                    b = jQuery(window).height();
                    f = 720 < f ? 720 : f;
                    f -= 80;
                    b -= 84;
                    tb_show("Insert Shortcode", "#TB_inline?width=" + f + "&height=" + b + "&inlineId=scn-dialog");
                    jQuery("#scn-options h3:first").text("Customize the " + c.title + " Shortcode")
                })
            });
            d.onNodeChange.add(function (a, c) {
                c.setDisabled("scn_button", a.selection.getContent().length > 0)
            })
        },
        createControl: function (d, e) {
            if (d == "scn_button") {
                d = e.createMenuButton("scn_button", {
                    title: "Insert Shortcode",
                    image: afl_paths.libPath + "shortcodes/tinymce/img/icon.png",
                    icons: false
                });
                var a = this;
                d.onRenderMenu.add(function (c, b) {
                    a.addWithDialog(b, "Button", "button");
                    a.addWithDialog(b, "Icon link", "ilink");
                    a.addWithDialog(b, "Social link", "social");
                    b.addSeparator();
					c = b.addMenu({
					  title: "Elements"
				  	});
                    a.addWithDialog(c, "Icon Box", "iconbox");
                    a.addWithDialog(c, "Info Box", "box");
					a.addWithDialog(c, "Tooltip", "tooltip");
                    a.addWithDialog(c, "Quote", "quote");
					a.addWithDialog(c, "Video", "video");
					c = b.addMenu({
					  title: "Content Grouping"
				 	});
                    a.addWithDialog(c, "Column Layout", "column");
					a.addWithDialog(c, "Content Slider","slider");
					a.addWithDialog(c, "Accordion","accordion");
					a.addWithDialog(c, "Skill Bars","skillbars");
					a.addWithDialog(c, "Tabbed Content","tab");
                    b.addSeparator();
                    c = b.addMenu({
                        title: "Dividers"
                    });
                    a.addImmediate(c, "Horizontal Rule", "[divider]");
                    a.addImmediate(c, "Horizontal Rule (Bold)", "[divider bold]");
                    a.addImmediate(c, "Horizontal Rule (small)", "[divider small]");
                    a.addImmediate(c, "Horizontal Rule (mini)", "[divider mini]");
                    a.addImmediate(c, "Horizontal Rule (bottom)", "[divider bottom]");
                    a.addImmediate(c, "Horizontal Rule with top link", "[divider top]");
                    a.addImmediate(c, "Whitespace", "[divider invisible]");
                    c = b.addMenu({
                        title: "Dropcaps"
                    });
                    a.addImmediate(c, "Dropcap Style 1 (Big Letter)", "[dropcap1]A[/dropcap1]");
                    a.addImmediate(c, "Dropcap Style 2 (Colored Background)", "[dropcap2]A[/dropcap2]");
                    a.addImmediate(c, "Dropcap Style 3 (Dark Background)", "[dropcap3]A[/dropcap3]");
                    b.addSeparator();
                    c = b.addMenu({
                        title: "Widgets"
                    });
					a.addWithDialog(c, "Google Map", "map");
					a.addWithDialog(c, "Posts Strip",	"posts_strip");
					a.addImmediate(c, "Contact Form", "[contact_form][/contact_form]");

                    /*
                    c = b.addMenu({
                        title: "Social Buttons"
                    });
                    a.addWithDialog(c, "Twitter", "twitter");
                    a.addWithDialog(c, "Tweetmeme", "tweetmeme");
                    a.addWithDialog(c, "Digg", "digg");
                    a.addWithDialog(c, "Like on Facebook", "fblike");
                    */
      
                });
                return d
            }
            return null
        },
        addImmediate: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("mceInsertContent", false, a)
                }
            })
        },
        addWithDialog: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("scnOpenDialog", false, {
                        title: e,
                        identifier: a
                    })
                }
            })
        },
        getInfo: function () {
            return {
                longname: "Shortcode Ninja plugin",
                author: "VisualShortcodes.com",
                authorurl: "http://visualshortcodes.com",
                infourl: "http://visualshortcodes.com/shortcode-ninja",
                version: "1.0"
            }
        }
    });
    tinymce.PluginManager.add("ShortcodeNinjaPlugin", tinymce.plugins.ShortcodeNinjaPlugin)
})();
