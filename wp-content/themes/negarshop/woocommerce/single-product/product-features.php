<?php
$features = negarshop_option('product_features');
if(!empty($features)) {
    echo '<div class="product-footer-features">';
        echo '<div class="row justify-content-center">';
	$ipf = 1;
            foreach ($features as $feature) {
                $slug = (!isset($feature['slug']) || empty($feature['slug'])) ? $feature['title'] : $feature['slug'];
                if(negarshop_option(base64_encode($slug), 'posts') === true) {
                    echo '<div class="col-auto mb-1">';

                    echo '<div class="pff-item"'. ((isset($feature['content']) and !empty($feature['content']))?'data-toggle="modal" data-target="#product-modal-'.$ipf.'"':'').'>';
                    if (isset($feature['icon_type']) and $feature['icon_type'] !== "false") {
                        $icon = '';
                        if ($feature['icon_type'] == "upload") {
                            $icon = $feature['icon_picker']['upload']['image']['url'];
                        } else {
                            $icon = get_template_directory_uri() . '/statics/images/svg/' . $feature['icon_picker']['select']['image'] . '.svg';
                        }
                        echo '<span class="icon" style="background-image: url(' . $icon . ');"></span>';
                    }
                    if (isset($feature['title']) and !empty($feature['title'])) {
                        echo '<span class="title">' . $feature['title'] . '</span>';
                    }
                    if (isset($feature['desc']) and !empty($feature['desc'])) {
                        echo '<span class="desc">' . $feature['desc'] . '</span>';
                    }
                    echo '</div>';
                    echo '</div>';
                }$ipf++;
            }
        echo '</div>';
    echo '</div>';
}