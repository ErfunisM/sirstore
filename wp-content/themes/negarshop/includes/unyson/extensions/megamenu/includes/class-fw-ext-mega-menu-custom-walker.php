<?php

class FW_Ext_Mega_Menu_Custom_Walker extends FW_Ext_Mega_Menu_Walker {
	public function start_lvl (&$output, $depth = 0, $args = [], $class = 'sub-menu') {
		$output = str_replace('<div class="mega-menu" >', '', $output);
		parent::start_lvl($output, $depth, $args, $class);
	}

	public function end_el (&$output, $item, $depth = 0, $args = [], $id = 0) {
		$output  = str_replace('</div>', '', $output);
		$item_id = $item->ID;
		$atts    = 'false';
		if ( $item_type = fw_ext_mega_menu_get_db_item_option($item_id, 'type') ) {
			$atts = fw_ext_mega_menu_get_db_item_option($item_id, $item_type);
		}
		if ( isset($atts['mega_menu_type']) ) {
			if ( isset($atts['mega_menu_ajax']) && $atts['mega_menu_ajax'] === "false" ) {
				$sub_menus_out = "";
				$sub_menus     = negarshop_mega_menu_contents($item_id);
				if ( $sub_menus['status'] === true ) {
					$sub_menus_out = $sub_menus['data'];
				}
				$output = str_replace('menu-item-' . $item_id . '">', 'menu-item-' . $item_id . ' loaded" data-col="' . $atts['multi-picker']['menu']['col'] . '" data-id="' . $item_id . '">' . $sub_menus_out, $output);

			} else {
				$col_tmp = $atts['multi-picker']['menu']['col'] ?? 4;
				$output  = str_replace('menu-item-' . $item_id . '"', 'menu-item-' . $item_id . '" data-col="' . $col_tmp . '" data-id="' . $item_id . '"', $output);
			}
		}

		parent::end_el($output, $item, $depth, $args, $id);
	}

}