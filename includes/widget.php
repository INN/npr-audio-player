<?php
/**
 * NPR Audio Player Widget.
 *
 * @since   1.0
 * @package NPR_Audio_Player
 */

/**
 * NPR Audio Player Widget class.
 *
 * @since 1.0
 */

 
// Creating the widget 
class npr_audio_widget extends WP_Widget {
 
	function __construct() {
		$this->option_prefix = NPR_Audio_Player_Settings::$options_prefix;

		parent::__construct(
		 
		// Base ID of your widget
		'npr_audio_widget', 
		 
		// Widget name will appear in UI
		__('NPR Audio Player', 'npr_audio_widget_domain'), 
		 
		// Widget description
		array( 'description' => __( 'Plays NPR audio streams', 'npr_audio_widget_domain' ), ) 
		);
	}
	 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {

		wp_enqueue_script( 'triton_player', 'http://widgets.listenlive.co/1.0/tdwidgets.min.js', false );
		wp_enqueue_script( 'npr-audio-js', plugins_url( 'assets/widget.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0', false );
		wp_enqueue_style( 'npr-audio-css', plugins_url( 'assets/widget.css', dirname( __FILE__ ) ), array(), '1.0' );

		$title = apply_filters( 'widget_title', $instance['title'] );
		 
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		echo __( 'Player test:', 'npr_audio_widget_domain' );
		//echo __( '<audio controls><source src="https://peace.streamguys1.com:7075/wskg" type="audio/mpeg"><source src="https://peace.streamguys1.com:7075/wskg" type="audio/ogg"></audio>', 'npr_audio_widget_domain' );

		$listen_label = esc_attr( get_option( $this->option_prefix . 'listen_label', '' ) );

		$streams = array(
			array(
				'desc'	=> esc_attr( get_option( $this->option_prefix . 'stream1_desc', '' ) ),
				'name'	=> 0,
				'url'	=> esc_attr( get_option( $this->option_prefix . 'stream1_url', '' ) ),
				'data'	=> array(
					'type'	=> 'composer2',
					'ucs'	=> esc_attr( get_option( $this->option_prefix . 'stream1_ucs_id', '' ) )
				)
			),
			array(
				'desc'	=> esc_attr( get_option( $this->option_prefix . 'stream2_desc', '' ) ),
				'name'	=> 1,
				'url'	=> esc_attr( get_option( $this->option_prefix . 'stream2_url', '' ) ),
				'data'	=> array(
					'type'	=> 'composer2',
					'ucs'	=> esc_attr( get_option( $this->option_prefix . 'stream2_ucs_id', '' ) )
				)
			),
			array(
				'desc'	=> esc_attr( get_option( $this->option_prefix . 'stream3_desc', '' ) ),
				'name'	=> 2,
				'url'	=> esc_attr( get_option( $this->option_prefix . 'stream3_url', '' ) ),
				'data'	=> array(
					'type'	=> 'composer2',
					'ucs'	=> esc_attr( get_option( $this->option_prefix . 'stream3_ucs_id', '' ) )
				)
			)
		);

		echo '<script type="text/javascript">var streams = ' . json_encode( $streams ) . '</script>';

		echo __( '<div id="npr-audio-player-container"></div>', 'npr_audio_widget_domain' );

		?>


		<div id="temp_container" class="" style="display:none;">
		    <div id="nprap-wrapper" class="played collapse">
		      <div id="player-bar-wrapper" class="player-bar-wrapper">
		        <div id="player-bar" class="player-bar"><div id="nprap" class="nprap-controls"><div class="start-stop">
		  <div class="jp-play player-btn" role="button" title="play" aria-label="Play">
		    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" preserveAspectRatio="xMinYMin" class="btn-play">
		      <circle cx="20" cy="20" r="18" stroke="#7F95A4" stroke-width="3" class="btn-fill"></circle>
		      <path d="m30.50001,20.6l0,0l-16.5,8.3c-0.1,0.1 -0.2,0.1 -0.3,0.2l0,0l0,0c-0.1,0 -0.3,0.1 -0.4,0.1c-0.7,0 -1.3,-0.5 -1.3,-1.2v-16.8c0,-0.7 0.6,-1.2 1.3,-1.2c0.2,0 0.4,0 0.6,0.1l0,0l16.7,8.5l0,0c0.4,0.2 0.6,0.6 0.6,1c-0.1,0.4 -0.3,0.8 -0.7,1z" fill="#FFFFFF" id="btn-object"></path>
		    </svg>
		  </div>
		  <div class="jp-stop player-btn" role="button" title="stop" aria-label="Stop">
		    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" preserveAspectRatio="xMinYMin" class="btn-stop">
		      <circle cx="20" cy="20" r="18" fill="#7F95A4" stroke="#7F95A4" stroke-width="3" class="btn-fill"></circle>
		      <path d="M20 0 A20 20 0 0 1 38 20 L38 20 A16 16 0 0 0 20 4z" class="btn-load" transform="rotate(187.081 20 20)">
		        <animateTransform attributeName="transform" type="rotate" from="360 20 20" to="0 20 20" dur="0.8s" repeatCount="indefinite"></animateTransform>
		      </path>
		      <rect x="10.5" y="10.75" rx="3" ry="3" width="18.5" height="18.5" fill="#FFFFFF" class="btn-object"></rect>
		    </svg>
		  </div>
		</div>
		</div><div class="now-playing" tabindex="0">
		<div class="stream-label">
		  <span class="player-title-text"><?php echo $listen_label;?></span>
		  <span class="stream-title"><!-- streams[0].desc --></span>
		</div>
		<div class="program-name">
		   <!-- data.onNow.program.name -->
		</div>

		<div class="program-next"><span>NEXT:</span> <!-- data.nextUp[0].program.name --> </div>

		</div>
		          <div class="change-volume">
		            <div class="volume-container">
		              <div class="volume-buttons">
		                <div class="jp-mute" style="display: block;">
		                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" preserveAspectRatio="xMinYMin">
		                    <path fill="#7F95A4" d="M10.6 0C10.4 0 10.1 0 10 0.2L5 5.3H5 1.3C0.6 5.3 0 5.9 0 6.6v4.8c0 0.7 0.6 1.4 1.3 1.4H5c0 0 0 0 0.1 0l4.9 5c0.1 0.1 0.2 0.2 0.4 0.2 0.3 0 0.5-0.3 0.5-0.6V0.6C10.9 0.3 10.7 0.1 10.6 0L10.6 0z"></path>
		                    <path fill="#7F95A4" d="M12.2 6.5c1.3 1.4 1.3 3.5 0 5l1.6 1.6c2.2-2.3 2.2-6 0-8.2L12.2 6.5z"></path>
		                    <path fill="#7F95A4" d="M15.4 3.2c3.1 3.2 3.1 8.4 0 11.6l1.6 1.7c4-4.1 4-10.8 0-14.9L15.4 3.2z"></path>
		                  </svg>
		                </div>
		                <div class="jp-unmute" style="display: none;">
		                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" preserveAspectRatio="xMinYMin">
		                    <path fill="#7F95A4" d="M10.6 0C10.4 0 10.1 0 10 0.2L5 5.3H5 1.3C0.6 5.3 0 5.9 0 6.6v4.8c0 0.7 0.6 1.4 1.3 1.4H5c0 0 0 0 0.1 0l4.9 5c0.1 0.1 0.2 0.2 0.4 0.2 0.3 0 0.5-0.3 0.5-0.6V0.6C10.9 0.3 10.7 0.1 10.6 0L10.6 0z"></path>
		                    <path fill="#7F95A4" d="M19.8 11v1.5h-1.5l-2-2 -2 2h-1.5V11l2-2 -2-2V5.5h1.5l2 2 2-2h1.5V7l-2 2L19.8 11z"></path>
		                  </svg>
		                </div>
		              </div>
		              <div class="jp-volume-bar" style="display: block;">
		                <div class="jp-volume-bar-value-bg"></div>
		                <div class="jp-volume-bar-value" style="height: 80%;"></div>
		              </div>
		            </div>
		          </div>
		          <div class="more-toggle">
		            <div class="player-btn" role="button" aria-label="Expand/Collapse">
		              <svg xmlns="http://www.w3.org/2000/svg" id="btn-open" class="toggle-arrow open" width="20px" height="11.7px" viewBox="0 0 20 11.7" preserveAspectRatio="xMinYMin">
		                <path fill="#7F95A4" d="M19.5,3.4c-0.7,0.7-8.1,7.8-8.1,7.8c-0.4,0.4-0.9,0.6-1.4,0.6c-0.5,0-1-0.2-1.4-0.6c0,0-7.4-7-8.1-7.8
		          c-0.7-0.7-0.8-2,0-2.8c0.8-0.8,1.8-0.8,2.7,0L10,7.1l6.7-6.5c0.9-0.8,2-0.8,2.7,0C20.2,1.4,20.2,2.7,19.5,3.4z"></path>
		              </svg>
		            </div>
		          </div>
		        </div>
		      </div>
		      <div class="expanded-player-outer-wrapper">
		        <div class="expanded-player-wrapper">
		          <div id="player-inner-container" class="player-header">
		            <div id="metadata-container" class="current-content"><div class="stream-meta-view"><div class="stream-program-meta-view"><div class="current stream"><!-- streams[0].desc --> </div>
		<div class="current program" id="stream-title"><!-- data.onNow.program.name --></div>
		</div><div class="stream-song-meta-view">
		  <div class="song-meta-view-inner">
				
				<div id="song-view" class="song-info-wrapper">
					<span class="song-trackname">
						<!-- streams[0].data.onNow.song.trackName -->
					</span>
					
					<span class="song-artistname">
					  <!-- streams[0].data.onNow.song.composerName -->
					  <!-- streams[0].data.onNow.song.artistName -->
					</span>
					
					
				</div>
			</div>

		</div></div></div>
		            <div id="player-extras" class="player-extras"><div class="streams-view btn-group"><ul id="streams-wrapper" class="streams-list">
		<li id="stream-0" class="single-stream benched paused"><a class="stream" href="<?php echo $streams[0]['url']; ?>">
			<div class="stream-indicator">
				<div class="stream-inactive" title="not-playing"></div>
				<div class="stream-active" title="playing">
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
				</div>
			</div>
			<div class="stream-name">
		    <div class="stream-label"><?php echo $streams[0]['desc']; ?></div>
		    <div class="program-name"><!-- data.onNow.program.name --></div>
		  </div>
		</a>
		</li>
		<li id="stream-1" class="single-stream current paused"><a class="stream" href="<?php echo $streams[1]['url']; ?>">
			<div class="stream-indicator">
				<div class="stream-inactive" title="not-playing"></div>
				<div class="stream-active" title="playing">
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
			    <span class="stream-activebar"></span>
				</div>
			</div>
			<div class="stream-name">
		    <div class="stream-label"><?php echo $streams[1]['desc']; ?></div>
		    <div class="program-name">Classical Music Through the Night</div>
		  </div>
		</a>
		</li></ul>
		</div></div>
		          </div>
		        </div>
		      </div>
		    </div>
		  </div>




		<?php


		echo $args['after_widget'];
	}
	         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = __( 'New title', 'npr_audio_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php 
	}
	     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class npr_audio_widget ends here


