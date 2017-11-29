<?php
/**
 * NPR Audio Player Settings.
 *
 * @since   1.0
 * @package NPR_Audio_Player
 */

/**
 * NPR Audio Player Settings class.
 *
 * @since 1.0
 */

/**
 * Register and populate a settings page for the NPR Audio Player Plugin:
 */
class NPR_Audio_Player_Settings {
	/**
	 * The slug of the settings page
	 *
	 * @var string $settings_page The settings page slug
	 */
	private $settings_page = 'npraudio';

	/**
	 * The slug of the settings group
	 *
	 * @var string $settings_group The settings group slug
	 */
	private $settings_group = 'npraudio_group';

	/**
	 * The slug of the settings section
	 *
	 * @var string $settings_section The slug of the settings section
	 */
	//private $settings_section = 'npraudio_section';
	private $stream1_section = 'npraudio_stream1';
	private $stream2_section = 'npraudio_stream2';
	private $stream3_section = 'npraudio_stream3';
	private $general_settings_section = 'npraudio_general_settings';

	/**
	 * The prefix used for this plugin's options saved in the options table
	 *
	 * @var string $options_prefix The prefix for this plugin's options saved in the options table
	 */
	public static $options_prefix = 'nprap_';

	

	/**
	 * Constructor for the settings class
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_submenu_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Register the settings page
	 */
	public function register_submenu_page() {
		add_submenu_page(
			'options-general.php',
			esc_html__( 'NPR Audio Player', 'npraudio' ),
			esc_html__( 'NPR Audio Player', 'npraudio' ),
			'manage_options', // permissions level is this because that seems right for site-wide config options.
			$this->settings_page,
			array( $this, 'settings_page_output' )
		);
	}

	/**
	 * The settings page output
	 *
	 * Should output a bunch of HTML
	 */
	public function settings_page_output() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'npraudio' ) );
		}
		?>
		<div class="wrap npraudio-admin">
			<h1><?php esc_html_e( 'NPR Audio Player Options', 'npraudio' ); ?></h1>
			<form method="post" action="options.php">
				<?php
					settings_fields( $this->settings_group );
					do_settings_sections( $this->settings_page );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * All the settings
	 */
	public function register_settings() {
		// General Settings
		add_settings_section(
			$this->general_settings_section,
			esc_html__( 'General Settings', 'npraudio' ),
			array( $this, 'general_settings_section_callback' ),
			$this->settings_page
		);

		register_setting( $this->settings_group, self::$options_prefix . 'listen_label', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'listen_label',
			__( 'Description', 'npraudio' ),
			array( $this, 'field_listen_label' ),
			$this->settings_page,
			$this->general_settings_section
		);

		// Stream 1
		add_settings_section(
			$this->stream1_section,
			esc_html__( 'Stream 1', 'npraudio' ),
			array( $this, 'stream1_section_callback' ),
			$this->settings_page
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream1_desc', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream1_desc',
			__( 'Description', 'npraudio' ),
			array( $this, 'field_stream1_desc' ),
			$this->settings_page,
			$this->stream1_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream1_url', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream1_url',
			__( 'URL', 'npraudio' ),
			array( $this, 'field_stream1_url' ),
			$this->settings_page,
			$this->stream1_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream1_ucs_id', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream1_ucs_id',
			__( 'UCS ID', 'npraudio' ),
			array( $this, 'field_stream1_ucs_id' ),
			$this->settings_page,
			$this->stream1_section
		);

		// Stream 2
		add_settings_section(
			$this->stream2_section,
			esc_html__( 'Stream 2', 'npraudio' ),
			array( $this, 'stream2_section_callback' ),
			$this->settings_page
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream2_desc', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream2_desc',
			__( 'Description', 'npraudio' ),
			array( $this, 'field_stream2_desc' ),
			$this->settings_page,
			$this->stream2_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream2_url', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream2_url',
			__( 'URL', 'npraudio' ),
			array( $this, 'field_stream2_url' ),
			$this->settings_page,
			$this->stream2_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream2_ucs_id', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream2_ucs_id',
			__( 'UCS ID', 'npraudio' ),
			array( $this, 'field_stream2_ucs_id' ),
			$this->settings_page,
			$this->stream2_section
		);

		// Stream 3
		add_settings_section(
			$this->stream3_section,
			esc_html__( 'Stream 3', 'npraudio' ),
			array( $this, 'stream3_section_callback' ),
			$this->settings_page
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream3_desc', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream3_desc',
			__( 'Description', 'npraudio' ),
			array( $this, 'field_stream3_desc' ),
			$this->settings_page,
			$this->stream3_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream3_url', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream3_url',
			__( 'URL', 'npraudio' ),
			array( $this, 'field_stream3_url' ),
			$this->settings_page,
			$this->stream3_section
		);

		register_setting( $this->settings_group, self::$options_prefix . 'stream3_ucs_id', 'sanitize_text_field' );
		add_settings_field(
			self::$options_prefix . 'stream3_ucs_id',
			__( 'UCS ID', 'npraudio' ),
			array( $this, 'field_stream3_ucs_id' ),
			$this->settings_page,
			$this->stream3_section
		);
	}

	/**
	 * Settings section description
	 */
	public function stream1_section_callback() {
		//echo wp_kses_post( __( 'For more information about these settings, and about the plugin, please see the <a href="https://wordpress.org/plugins/news-match-donation-shortcode">plugin page on WordPress.org</a>.', 'npraudio' ) );
	}

	public function stream2_section_callback() {
		//echo wp_kses_post( __( 'For more information about these settings, and about the plugin, please see the <a href="https://wordpress.org/plugins/news-match-donation-shortcode">plugin page on WordPress.org</a>.', 'npraudio' ) );
	}

	public function stream3_section_callback() {
		//echo wp_kses_post( __( 'For more information about these settings, and about the plugin, please see the <a href="https://wordpress.org/plugins/news-match-donation-shortcode">plugin page on WordPress.org</a>.', 'npraudio' ) );
	}

	/**
	 * Output the input field for the Stream 1 Description
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_listen_label( $args ) {
		$option = self::$options_prefix . 'listen_label';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 1 Description
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream1_desc( $args ) {
		$option = self::$options_prefix . 'stream1_desc';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 1 URL
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream1_url( $args ) {
		$option = self::$options_prefix . 'stream1_url';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 1 UCS ID
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream1_ucs_id( $args ) {
		$option = self::$options_prefix . 'stream1_ucs_id';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 2 Description
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream2_desc( $args ) {
		$option = self::$options_prefix . 'stream2_desc';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 2 URL
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream2_url( $args ) {
		$option = self::$options_prefix . 'stream2_url';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 2 UCS ID
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream2_ucs_id( $args ) {
		$option = self::$options_prefix . 'stream2_ucs_id';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 3 Description
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream3_desc( $args ) {
		$option = self::$options_prefix . 'stream3_desc';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 3 URL
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream3_url( $args ) {
		$option = self::$options_prefix . 'stream3_url';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	/**
	 * Output the input field for the Stream 3 UCS ID
	 *
	 * @param array $args Optional arguments passed to callbacks registered with add_settings_field.
	 */
	public function field_stream3_ucs_id( $args ) {
		$option = self::$options_prefix . 'stream3_ucs_id';
		$value = get_option( $option, '' );
		echo sprintf(
			'<input name="%1$s" id="%1$s" type="text" value="%2$s">',
			esc_attr( $option ),
			esc_attr( $value )
		);
	}

	
}
