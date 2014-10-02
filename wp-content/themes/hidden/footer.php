<!--footer-->
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 footer-widget-1">
                <?php dynamic_sidebar("footer-widget-1"); ?>
            </div>
            <div class="col-sm-8 footer-widget-right">
                <div class="row">
                    <div class="col-sm-12 footer-widget-4">
                        <?php dynamic_sidebar("footer-widget-4"); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6 footer-widget-2">
                                <?php dynamic_sidebar("footer-widget-2"); ?>
                            </div>
                            <div class="col-sm-6 footer-widget-3">
                                <?php dynamic_sidebar("footer-widget-3"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>
</div>

<?php if ($code = get_option('afl_counter_code')) { ?>
    <?php print $code ?>
<?php } ?>

<?php
/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */


wp_footer();
?>
</body>
</html>
