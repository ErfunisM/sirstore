<?php
/**
 * Header menu widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_menu($opts = array(), $classes = array('element-menu-widget'))
{
    $menuType = $opts['menu_type'] ?? "normal";
    $isUberMenu = $menuType === 'ubermenu';
    if (!isset($GLOBALS['header_main_nav'])) {
        $GLOBALS['header_main_nav'] = 1;
    } else {
        ++$GLOBALS['header_main_nav'];
    }
    $wg_class = "header_main_nav_" . $GLOBALS['header_main_nav'] . ' header_menu_type_' . $menuType;
    $class_attr = implode(' ', $classes);
    $menuID = $opts['menu_source'] ?? false;
    echo '<div class="' . $class_attr . '">';
    ?>
    <nav class="<?php echo $isUberMenu ? "header-main-nav-uber" : "header-main-nav"; ?> <?php echo $wg_class; ?>">
        <?php if ($menuType === 'dropdown' || $menuType === 'dropdown-show'): ?>
            <div class="header-main-menu vertical-menu">
                <?php
                if (has_nav_menu('category') or $menuID !== false) : ?>
                    <?php if ($menuType === 'dropdown') : ?>
                        <button class="vertical-menu-toggle">
                            <i class="<?php echo esc_attr(negarshop_fontawesome_425($opts['menu_icon']['value'])); ?>"></i>
                            <?php
                            if ($opts['show_menu_title'] === 'yes') {
                                echo esc_html($opts['menu_title']);
                            }
                            ?>
                        </button>
                    <?php
                    endif;
                    $can_display = true;

                    if ((is_front_page() || is_home()) && \Negarshop\Negarshop_Helper::is_checked($opts['hide_in_homepage'] ?? false)) {
                        $can_display = false;
                    }

                    if ($can_display) {
                        wp_nav_menu(
                            array(
                                'theme_location' => 'category',
                                'menu_class' => 'main-menu category-menu',
                                'mega_menu' => true,
                                'menu' => $menuID,
                                'container' => false,
                            )
                        );
                    }
                    ?>
                <?php endif; ?>
            </div>
        <?php elseif ($menuType === 'normal' || $menuType === 'ubermenu'): ?>
            <div class="header-main-menu-col <?php echo $isUberMenu ? "header-main-menu-uber" : "header-main-menu"; ?>">
                <?php
                if (has_nav_menu('main') or $menuID !== false) {
                    wp_nav_menu(
                        array(
                            'theme_location' => 'main',
                            'menu_class' => $isUberMenu ? "main-menu-uber" : 'main-menu',
                            'mega_menu' => true,
                            'menu' => $menuID,
                            'container' => false,
                        )
                    );
                }
                ?>
            </div>
        <?php elseif ($menuType === 'sidebar'): ?>
            <div class="responsive-menu">
                <button aria-label="<?php echo esc_attr($opts['menu_title']); ?>" type="button"
                        title="<?php echo esc_attr($opts['menu_title']); ?>" class="btn toggle-menu">
                    <i class="<?php echo esc_attr(negarshop_fontawesome_425($opts['menu_icon']['value'])); ?>"></i>
                    <?php
                    if ($opts['show_menu_title'] === 'yes') {
                        echo esc_html($opts['menu_title']);
                    }
                    ?>
                </button>
                <div class="menu-popup<?php echo $opts['sidebar_align'] === 'left' ? ' to-right' : ''; ?>">
                    <?php
                    if (has_nav_menu('main') or $menuID !== false) {
                        ?>
                        <nav class="responsive-navbar">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'main',
                                'menu_class' => 'categories-menu',
                                'container' => false,
                                'menu' => $menuID
                            ));
                            ?>
                        </nav>
                    <?php } ?>
                </div>
                <div class="overlay"></div>
            </div>
        <?php endif; ?>
    </nav>
    <?php
    echo '</div>';
}