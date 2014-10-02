// The toggle
jQuery(document).ready(function () {
    jQuery("#grid").click(function () {
        jQuery(this).addClass("active");
        jQuery("#list").removeClass("active");
        jQuery.cookie("gridcookie", "grid", {path: "/"});
        jQuery("ul.products").fadeOut(300, function () {
            jQuery(this).addClass("grid").removeClass("list").fadeIn(300)
        });
        return!1
    });
    jQuery("#list").click(function () {
        jQuery(this).addClass("active");
        jQuery("#grid").removeClass("active");
        jQuery.cookie("gridcookie", "list", {path: "/"});
        jQuery("ul.products").fadeOut(300, function () {
            jQuery(this).removeClass("grid").addClass("list").fadeIn(300)
        });
        return!1
    });
    jQuery.cookie("gridcookie") && jQuery("ul.products, #gridlist-toggle").addClass(jQuery.cookie("gridcookie"));
    if (jQuery.cookie("gridcookie") == "grid") {
        jQuery(".gridlist-toggle #grid").addClass("active");
        jQuery(".gridlist-toggle #list").removeClass("active")
    }
    if (jQuery.cookie("gridcookie") == "list") {
        jQuery(".gridlist-toggle #list").addClass("active");
        jQuery(".gridlist-toggle #grid").removeClass("active")
    }
    jQuery("#gridlist-toggle a").click(function (e) {
        e.preventDefault()
    })
});
