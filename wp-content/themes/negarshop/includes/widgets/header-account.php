<?php
/**
 * Header account widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_account($opts = array(), $classes = array())
{
    if (!function_exists('WC')) {
        return;
    }
    $mm_menus = (isset($opts['member_items'])) ? $opts['member_items'] : [];
    $us_menus = (isset($opts['user_items'])) ? $opts['user_items'] : [];

    $current_user = wp_get_current_user();
    $accountWelcomeText = ($current_user->exists()) ? $current_user->display_name . __(' عزیز، خوش آمدید!', 'negarshop') : __('لطفا وارد حساب خود شوید!', 'negarshop');

    $showAvatar = isset($opts['show_account_avatar']) && $opts['show_account_avatar'] === 'yes';
    $showTitle = isset($opts['show_account_title']) && $opts['show_account_title'] === 'yes';
    $showSubTitle = isset($opts['show_account_sub_title']) && $opts['show_account_sub_title'] === 'yes';
    $showIcon = isset($opts['show_account_icon']) && $opts['show_account_icon'] === 'yes';
    $showItems = isset($opts['show_account_items']) && $opts['show_account_items'] === 'yes';

    $accountTitle = $opts['account_title'] ?? __('حساب کاربری', 'negarshop');

    $accountHasLink = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('myaccount') : false;
    ?>
    <div class="header-account <?php echo esc_attr($opts['account_items_align'] ?? '') ?>">
        <div class="account-box">
            <?php if ($accountHasLink): ?>
            <a href="<?php echo esc_attr($accountHasLink); ?>" class="box-inner" data-toggle="modal"
               data-target="#login-popup-modal">
                <?php endif; ?>
                <?php if ($showIcon): ?>
                    <span class="icon">
                        <?php
                        if ($current_user->exists() && $showAvatar) {
                            echo get_avatar($current_user->ID, 48);
                        } else {
                            echo '<i class="' . (isset($opts['account_icon']) ? esc_attr(negarshop_fontawesome_425($opts['account_icon']['value'])) : 'far fa-user') . '"></i>';
                        }
                        ?>
                    </span>
                <?php endif; ?>
                <?php if ($showTitle || $showSubTitle): ?>
                    <div class="account-details">
                        <?php if ($showTitle): ?>
                            <span class="title"><?php echo esc_html($accountTitle); ?></span>
                        <?php endif; ?>

                        <?php if ($showSubTitle): ?>
                            <span class="subtitle"><?php echo esc_html($accountWelcomeText); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($accountHasLink): ?>
            </a>
        <?php endif; ?>
            <?php if ($showItems):
                $account_link = wc_get_page_permalink('myaccount');
                ?>
                <ul class="account-links"><?php if (is_user_logged_in()): ?>
                        <li class="summary">
                            <a href="<?php echo esc_url($account_link); ?>">
                                <?php echo get_avatar($current_user); ?>
                                <span>
                                    <span class="profile-name"><?php echo $current_user->display_name; ?></span>
                                    <span class="profile-details"><?php echo human_time_diff(strtotime($current_user->user_registered), date_i18n('U')); ?> پیش</span>
                                </span>
                            </a>
                        </li>
                    <?php
                    endif;
                    $store_user = null;
                    if (function_exists('dokan')) {
                        $store_user = dokan()->vendor->get($current_user->ID);
                    }
                    if (!empty($account_link)) {
                        if ($current_user->exists()) {
                            $setts_link = wc_get_account_endpoint_url('edit-account');
                            $orders_link = wc_get_account_endpoint_url('orders');
                            $logout_link = wp_logout_url(wc_get_page_permalink('myaccount'));
                            $seller_pages = get_option('dokan_pages');
                            $is_vendor = (!empty($store_user) and ($store_user->data->roles[0] == "administrator" or $store_user->data->roles[0] == "seller"));
                            if ($is_vendor and !empty($seller_pages)) {
                                echo '<li class="is-primary"><a href="' . get_the_permalink($seller_pages['dashboard']) . '">' . __('پنل فروشندگان', 'negarshop') . '</a></li>';
                            }
                            ?>

                            <li><a href="<?php echo $account_link; ?>"><?php _e('پنل کاربری', 'negarshop'); ?></a></li>
                            <li><a href="<?php echo $orders_link; ?>"><?php _e('سفارشات من', 'negarshop'); ?></a></li>
                            <?php
                            if (!empty($us_menus)) {
                                foreach ($us_menus as $item) {
                                    if ($item['roles'] == 'all') {
                                        echo '<li><a href="' . esc_attr($item['link']) . '">' . esc_html($item['title']) . '</a></li>';
                                    } else if ($item['roles'] == 'vendor' and $is_vendor) {
                                        echo '<li><a href="' . esc_attr($item['link']) . '">' . esc_html($item['title']) . '</a></li>';
                                    } else if ($item['roles'] == 'user' and !$is_vendor) {
                                        echo '<li><a href="' . esc_attr($item['link']) . '">' . esc_html($item['title']) . '</a></li>';
                                    }
                                }
                            }
                            ?>
                            <li><a href="<?php echo $setts_link; ?>"><?php _e('تنظیمات', 'negarshop'); ?></a></li>
                            <li><a href="<?php echo $logout_link; ?>" title="<?php _e('خروج', 'negarshop'); ?>"
                                   class="logout"><i
                                            class="far fa-sign-out"></i></a></li>
                        <?php } else {
                            if (!empty($mm_menus)) {
                                foreach ($mm_menus as $item) {
                                    echo '<li><a href="' . esc_attr($item['link']) . '">' . esc_html($item['title']) . '</a></li>';
                                }
                            }
                        }
                    }
                    ?></ul>
            <?php endif; ?>
        </div>
    </div>

    <?php
}