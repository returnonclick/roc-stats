<?php
/**
 * ROC Icon Box Widget
 */

if ( ! class_exists( 'ROC_Icon_Box' ) ) {
	class ROC_Icon_Box extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			parent::__construct(
				false, // ID, auto generate when false
				_x( 'ROC: Icon Box' , 'backend', 'rocstat_wp'), // Name
				array(
					'description' => _x( 'Icon Box for the Header of the page.', 'backend', 'rocstat_wp'),
					'classname'   => 'widget-icon-box',
				)
			);
		}

		/**
		 * Enqueue the JS and CSS files with the right action
		 * @see admin_enqueue_scripts
		 * @return void
		 */
		public static function enqueue_js_css() {
			wp_register_style( 'fontawesome-icons' , plugins_url( '/components/fontawesome/css/font-awesome.min.css',  dirname( __FILE__ ) ) );
			//wp_enqueue_style( 'fontawesome-icons', get_template_directory_uri() . '/bower_components/fontawesome/css/font-awesome.min.css' );
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];

			$hide = ($instance['hide'] == 'on') ? 'true' : 'false';
			
			$numberToShow = ($hide == 'true') ? substr($instance['phone'], 0, -3) . '...' : $instance['phone'];
			$content = ($instance['content'] == '') ? $numberToShow : $instance['content'];

			$justNumbers=preg_replace('/\s+/', '', $instance['phone']);
					?>
			<a data-phone-number= "<?php echo $instance['phone']; ?>" 
				data-hidden="<?php echo $hide; ?>" 
				data-tag="<?php echo $instance['tag']; ?>" 
				class="icon-box phone-call-link" 
				href="tel:<?php echo $justNumbers; ?>" >
				<i class="fa  <?php echo $instance['icon']; ?>  fa-3x"></i>
				<div class="icon-box__text">
					<h4 class="icon-box__title phone-call-content"><?php echo $content; ?></h4>
					<span class="icon-box__subtitle"><?php echo $instance['text']; ?></span>
				</div>
			</a>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();

			$instance['phone']		= wp_kses_post( $new_instance['phone'] );
			$instance['hide']  		= sanitize_key( $new_instance['hide'] );
			$instance['tag']		= wp_kses_post( $new_instance['tag'] );
			$instance['content']	= wp_kses_post( $new_instance['content'] );
			$instance['text'] 		= wp_kses_post( $new_instance['text'] );
			$instance['icon']		= sanitize_key( $new_instance['icon'] );
			
			return $instance;
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$phone 		= empty( $instance['phone'] ) ? '' : $instance['phone'];
			$hide 		= empty( $instance['hide'] ) ? '' : $instance['hide'];
			$tag 		= empty( $instance['tag'] ) ? '' : $instance['tag'];
			$content 	= empty( $instance['content'] ) ? '' : $instance['content'];
			$text     = empty( $instance['text'] ) ? '' : $instance['text'];
			$icon 		= empty( $instance['icon'] ) ? '' : $instance['icon'];

			?>

			<p>
				<label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _ex( 'Phone Number', 'backend', 'rocstat_wp'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $hide, 'on' ); ?> id="<?php echo $this->get_field_id( 'hide' ); ?>" name="<?php echo $this->get_field_name( 'hide' ); ?>" value="on" />
				<label for="<?php echo $this->get_field_id( 'hide' ); ?>"><?php _ex('Hide last 3 digits', 'backend', 'rocstat_wp'); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _ex( 'Content', 'backend', 'rocstat_wp'); ?>:</label> <br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" type="text" value="<?php echo $content; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'tag' ); ?>"><?php _ex( 'Tag for reports', 'backend', 'rocstat_wp'); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" type="text" value="<?php echo esc_attr( $tag ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _ex( 'Text', 'backend', 'buildpress_wp'); ?>:</label> <br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo $text; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'icon' ); ?>"><?php _ex( 'Icon', 'backend', 'rocstat_wp'); ?>:</label> <br />
				<small><?php printf( _x( 'Click on the icon below or manually select from the %s website', 'backend', 'rocstat_wp'), '<a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a>' ); ?>.</small>
				<input id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="text" value="<?php echo $icon; ?>" class="widefat  js-icon-input" /> <br><br>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-home"><i class="fa fa-lg fa-home"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-phone"><i class="fa fa-lg fa-phone"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-clock-o"><i class="fa fa-lg fa-clock-o"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-beer"><i class="fa fa-lg fa-beer"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-camera-retro"><i class="fa fa-lg fa-camera-retro"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-check-circle-o"><i class="fa fa-lg fa-check-circle-o"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-cog"><i class="fa fa-lg fa-cog"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-cogs"><i class="fa fa-lg fa-cogs"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-comments-o"><i class="fa fa-lg fa-comments-o"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-compass"><i class="fa fa-lg fa-compass"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-dashboard"><i class="fa fa-lg fa-dashboard"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-download"><i class="fa fa-lg fa-download"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-exclamation-circle"><i class="fa fa-lg fa-exclamation-circle"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-male"><i class="fa fa-lg fa-male"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-female"><i class="fa fa-lg fa-female"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-fire"><i class="fa fa-lg fa-fire"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-flag"><i class="fa fa-lg fa-flag"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-folder-open-o"><i class="fa fa-lg fa-folder-open-o"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-heart"><i class="fa fa-lg fa-heart"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-inbox"><i class="fa fa-lg fa-inbox"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-info-circle"><i class="fa fa-lg fa-info-circle"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-key"><i class="fa fa-lg fa-key"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-laptop"><i class="fa fa-lg fa-laptop"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-leaf"><i class="fa fa-lg fa-leaf"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-map-marker"><i class="fa fa-lg fa-map-marker"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-money"><i class="fa fa-lg fa-money"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-plus-circle"><i class="fa fa-lg fa-plus-circle"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-print"><i class="fa fa-lg fa-print"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-quote-right"><i class="fa fa-lg fa-quote-right"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-quote-left"><i class="fa fa-lg fa-quote-left"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-shopping-cart"><i class="fa fa-lg fa-shopping-cart"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-sitemap"><i class="fa fa-lg fa-sitemap"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-star-o"><i class="fa fa-lg fa-star-o"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-suitcase"><i class="fa fa-lg fa-suitcase"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-thumbs-up"><i class="fa fa-lg fa-thumbs-up"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-tint"><i class="fa fa-lg fa-tint"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-truck"><i class="fa fa-lg fa-truck"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-users"><i class="fa fa-lg fa-users"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-warning"><i class="fa fa-lg fa-warning"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-wrench"><i class="fa fa-lg fa-wrench"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-chevron-right"><i class="fa fa-lg fa-chevron-right"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-chevron-circle-right"><i class="fa fa-lg fa-chevron-circle-right"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-chevron-down"><i class="fa fa-lg fa-chevron-down"></i></a>
				<a class="js-selectable-icon  icon-widget" href="#" data-iconname="fa-chevron-circle-down"><i class="fa fa-lg fa-chevron-circle-down"></i></a>
			</p>

			<?php
		}

	}
	add_action( 'widgets_init', create_function( '', 'register_widget( "ROC_Icon_Box" );' ) );
	add_action( 'admin_enqueue_scripts', array( 'ROC_Icon_Box', 'enqueue_js_css' ), 20 );
}