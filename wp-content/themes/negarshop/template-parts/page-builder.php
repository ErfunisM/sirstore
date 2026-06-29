<?php
/* Template Name: صفحه ساز بونیزون */
get_header();
echo '<main id="main">';
if ( have_posts() ) {
    the_post();
    $output = do_shortcode(get_the_content());
	if(strpos($output,'fw-container')>0) {
		$output = str_replace('fw-container', 'container', $output);
		echo $output;
	}else{
		the_content();
	}
}
echo '</main>';
get_footer();