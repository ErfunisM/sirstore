<?php
if (function_exists('get_header')) {
    get_header();
}
?>
    <main id="main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="page-error mt-5">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="error-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/statics/images/error.svg"
                                         alt="404">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="error-code mb-2">404 Page not found!</div>
                                <h1 class="error-title mb-4"><?php echo negarshop_option('404_title'); ?></h1>

                                <div class="error-description mb-5">
                                    <?php echo negarshop_option('404_description'); ?>
                                </div>
                                <div class="error-action text-left pt-5">
                                    <a href="<?php echo site_url() ?>" class="btn btn-primary">بازگشت به صفحه اصلی</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
if (function_exists('get_footer')) {
    get_footer();
}