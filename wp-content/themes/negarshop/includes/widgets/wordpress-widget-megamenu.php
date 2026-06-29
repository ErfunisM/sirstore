<?php
class megamenu_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'megamenu_widget', 
			esc_html( 'فهرست پیشرفته'),
			array( 'description' => esc_html( 'ابزارک اختصاصی قالب نگارشاپ'), 'classname'	=>	'negarshop_wg pro-menus header-main-nav d-none d-xl-block')
		);
	}

	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo '<div class="header-main-menu vertical-menu">';
        wp_nav_menu(
            array(
            'menu_class'     => 'main-menu',
            'mega_menu'      => true,
            'menu'  =>  (int)$instance['menu'],
            'container'      => false,
            )
        );
        echo '</div>';

		echo $args['after_widget'];
		
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$menu = ! empty( $instance['menu'] ) ? $instance['menu'] : 0;
        $menus = negarshop_get_nav_menus_array();
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">عنوان</label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'menu' ) ); ?>">انتخاب فهرست</label>
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'menu' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu' ) ); ?>">
        <?php foreach ($menus as $key => $val):?>
            <option value="<?php echo esc_attr($key); ?>" <?php if($instance['menu']== esc_attr($key)){echo "selected";} ?>><?php echo esc_html($val); ?></option>
        <?php endforeach; ?>
		</select>
		</p>
		
		
		
		<?php
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['menu'] = ( ! empty( $new_instance['menu'] ) ) ? strip_tags( $new_instance['menu'] ) : 0;
 
 

		return $instance;
	}

} 

function register_megamenu_widget() {
    register_widget( 'megamenu_widget' );
}
add_action( 'widgets_init', 'register_megamenu_widget' );