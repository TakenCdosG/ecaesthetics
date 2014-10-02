jQuery(document).ready(function ($) {
    cart_improvement_functions();
    cart_button_animation();
    cart_dropdown_improvement();
    $('body').bind('added_to_cart', update_cart_dropdown);
    $('ul.products li.product').hover(
        function () {
            $(this).addClass('hover');
        },
        function () {
            $(this).removeClass('hover');
        }
    );
});


function cart_improvement_functions() {
    jQuery('.product_type_downloadable, .product_type_virtual').addClass('product_type_simple');
    jQuery('.woocommerce_tabs .tabs a').addClass('no-scroll');
    jQuery('.prev_image_container>.images a').attr('rel', 'product_images[grouped]');
}

//small function that improves shoping cart button behaviour
function cart_button_animation() {
    var containers = jQuery('.thumbnail_container');

    containers.each(function () {
        var container = jQuery(this), buttons = container.find('.button');

        buttons.css({opacity: 0, visibility: 'visible'});
        container.hover(
            function () {
                buttons.stop().animate({opacity: 1});
            },
            function () {
                buttons.stop().animate({opacity: 0});
            });
    });
}


// small function that improves shoping cart hover behaviour in the menu
function cart_dropdown_improvement() {
    var dropdown = jQuery('.cart_dropdown'), subelement = dropdown.find('.dropdown_widget').css({display: 'none', opacity: 0});

    dropdown.hover(
        function () {
            subelement.css({display: 'block'}).stop().animate({opacity: 1});
        },
        function () {
            subelement.stop().animate({opacity: 0}, function () {
                subelement.css({display: 'none'});
            });
        }
    );
}


//updates the shopping cart in the sidebar, hooks into the added_to_cart event whcih is triggered by woocommerce
function update_cart_dropdown() {
    var menu_cart = jQuery('.cart_dropdown'),
        dropdown_cart = menu_cart.find('.dropdown_widget_cart:eq(0)'),
        dropdown_html = dropdown_cart.html(),
        subtotal = menu_cart.find('.cart_subtotal'),
        sidebarWidget = jQuery('.widget_shopping_cart');

    dropdown_cart.load(window.location + ' .dropdown_widget_cart:eq(0) > *', function () {
        dropdown_cart.html(dropdown_html);
        var subtotal_new = dropdown_cart.find('.total');
        subtotal_new.find('strong').remove();
        subtotal.html(subtotal_new.html());

        jQuery('.widget_shopping_cart, .updating').css('opacity', '1'); //woocommerce script has a racing condition in updating opacity to 1 so it doesnt always happen, this fixes the problem

        //if we are on a page without real cart widget show the dropdown widget for a moment as visual feedback
        if (!sidebarWidget.length) {
            var notification = jQuery('<div class="update_succes woocommerce_message">' + menu_cart.data('success') + '</div>').prependTo(dropdown_cart);
            dropdown_cart.css({display: 'block'}).stop().animate({opacity: 1}, function () {
                notification.delay(500).animate({height: 0, opacity: 0, paddingTop: 0, paddingBottom: 0}, function () {
                    notification.remove();
                });
                dropdown_cart.delay(1000).animate({opacity: 0}, function () {
                    dropdown_cart.css({display: 'none'});
                });
            });
        }
    });
}

//
