<?php
/**
 * Affiliates hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_add_affiliates_endpoint() {
    add_rewrite_endpoint('affiliates', EP_ROOT | EP_PAGES);
}

function negarshop_affiliates_query_vars($vars) {
    $vars[] = 'affiliates';

    return $vars;
}

function negarshop_affiliates_content() {
    get_template_part('woocommerce/myaccount/affiliates');
}

add_action('init', 'negarshop_add_affiliates_endpoint');
add_filter('query_vars', 'negarshop_affiliates_query_vars', 0);
add_action('woocommerce_account_affiliates_endpoint', 'negarshop_affiliates_content');