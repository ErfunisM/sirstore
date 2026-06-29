<?php
class posts_widget extends WP_Widget {
	
	function __construct() {
		parent::__construct(
			'posts_widget', 
			esc_html( 'مطالب وبلاگ'),
			array( 'description' => esc_html( 'ابزارک اختصاصی قالب نگارشاپ'), 'classname'	=>	'negarmag_wg')
		);
	}

	
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}?>
		<?php
    $query_args = array();
    $query_args['posts_per_page'] =  (int)$instance['count'];
    if($instance['type'] == "2"){
        $query_args['cat']   =   $instance['category'];
    }
    if($instance['type'] == "3"){
        $query_args['orderby']   =   'rand';
    }
    $the_query = new WP_Query( $query_args );
	
    ?>

    <?php if ( $the_query->have_posts() ) : ?>
<div class="blog-posts">
<ul>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
<li><a href="<?php the_permalink(); ?>" target="_blank">
<?php if(has_post_thumbnail()): ?>
	<figure><img class="lazy" data-src="<?php the_post_thumbnail_url(array(50,50)); ?>" alt="<?php the_title(); ?>"></figure>
	<?php endif; ?>
	<h3><?php the_title(); ?></h3>
	<time><?php echo get_the_date(); ?></time>
</a></li>
<?php endwhile; ?>
</ul>		
</div>		
		<?php
		endif; wp_reset_query(); 
		echo $args['after_widget'];
		
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html( 'اخبار جدید' );
		$count = ! empty( $instance['count'] ) ? $instance['count'] : esc_html( 5 );
		$style = ! empty( $instance['style'] ) ? $instance['style'] : esc_html( "1" );
		$type = ! empty( $instance['type'] ) ? $instance['type'] : esc_html( "1" );
		$category = ! empty( $instance['category'] ) ? $instance['category'] : esc_html( 0 );
		
		
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">عنوان</label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">تعداد جهت نمایش</label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">نمایش بر اساس</label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
			<option value="1" <?php if($instance['type']=="1"){echo "selected";} ?>>تاریخ انتشار</option>
			<option value="2" <?php if($instance['type']=="2"){echo "selected";} ?>>دسته بندی</option>
			<option value="3" <?php if($instance['type']=="3"){echo "selected";} ?>>تصادفی</option>
		</select>
		</p>
		<p class="category-tag" style="display: none">
		<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">دسته بندی</label> 
		<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
			<?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
			<option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
			<?php } ?>      
		</select>
		</p>
		
		
		
		<?php  
		echo '<script>';
		echo '
			jQuery(function($) {
				if($("#'. $this->get_field_id('type'). '").val() == "2") {
					$("#'. $this->get_field_id('type'). '").parent("p").next(".category-tag").show();
				}
				$("#'. $this->get_field_id('type'). '").change(function(){
					if($(this).val() == "2") {
						$(this).parent("p").next(".category-tag").show();
					} else {
						$(this).parent("p").next(".category-tag").hide();
					} 
				});
			});
		</script>';
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
 
 

		return $instance;
	}

} 

function register_posts_widget() {
    register_widget( 'posts_widget' );
}
add_action( 'widgets_init', 'register_posts_widget' );