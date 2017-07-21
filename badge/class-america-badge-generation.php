<?php

// Image generation library - depends on GD and FreeType library being installed
use Intervention\Image\ImageManagerStatic as Image;
Image::configure(array('driver' => 'gd'));

/**
 * Generates images
 */
class America_Badge_Generation {

	// private $font_path =  get_stylesheet_directory() . '/badge/';
	protected $config;

	/**
   * Class contructor
   */
  public function __construct( ) {
  	$this->load_config();
  }

  /**
   * Load configuration file that holds image config for each project
   */
  public function load_config() {
		$this->config = (require plugin_dir_path(__FILE__)  . 'config.php');
  }

  /**
   * Create image using params passed in via form
   * @param  object 	params object containing key used to find image config vars in loaded config file
   * @return string 	path to generated image
   */
  public function create_image( $params ) {
  	$id = $params['key'];
  	$project = $this->config[$id]; // get the image config, i.e. png, field position, etc.
  	$dest_path = '';

		if( isset($project) ) {
	  	$src_path = plugin_dir_path(__FILE__) .  $project['src_path'];
		  $filename = uniqid( $project['prefix'], true ) . '.png';

		  // This should be s3 bucket or save in tmp dir and then run cron job to delete
		  $dest_path = plugin_dir_path(__FILE__) .  $project['save_path'] . $filename;
		  $image = Image::make( $src_path );

		  foreach ( $project['text'] as $text) {
		  	$this->parse_and_add_lines( $image, $project, $params, $text );
		  }

		  $image->save( $dest_path );
		  $image->destroy();  // clear memory
		} else {
			$msg =  'There was no matching configuration for form with key: ' . $id;
			error_log( $msg, 0 );
		}

	  return $dest_path;
  }

  /**
   * Debug utility
   * @param  object $obj object to introspect
   */
  public function debug( $obj ) {
	  echo '<pre>';
	  var_dump( $obj );
	  echo '</pre>';
	  die();
	}

  /**
   * Get value from the config file
   * @param  [type] $project [description]
   * @param  [type] $config  [description]
   * @param  [type] $value   [description]
   *
   * @return string          html encoded text value
   */
  private function getConfigValue( $project, $config, $value ) {
  	return ( empty($config[$value]) ) ? $project[$value] : $config[$value];
  }

  /**
   * Get text value from database using the key id
   * @param  [type] $metas [description]
   * @param  [type] $key   [description]
   *
   * @return [type]        [description]
   */
  private function getFieldValue ( $metas, $key ) {
   global $wpdb;
   $value = '';

   $id = $wpdb->get_var("SELECT * FROM {$wpdb->prefix}frm_fields WHERE field_key='{$key}'");

   if( isset($metas[$id]) )  {
      $value = $metas[$id];
   }

   return htmlspecialchars_decode( $value );
}

 /**
  *  Wraps text to fit graphic if num characters exceeds max limit set in config (line_max_chars)
  * @param  [type] &$image  [description]
  * @param  [type] $project [description]
  * @param  [type] $params  [description]
  * @param  [type] $config  [description]
  */
	private function parse_and_add_lines( &$image, $project, $params, $config ) {
		$text = $config['content'];  	// static content
		if( $text == 'FIELD' ) {  		// indicates dynamic field, get value
			$field_id = $config['field_id'];
			$text = $this->getFieldValue( $params['metas'], $field_id );

			if( $config['uppercase'] == 1 ) {
				$text = strtoupper($text);
			}
		}

		$line_max_chars 	= (int) $project['line_max_chars'];
		$line_height 			= (int) $project['line_height'];
		$x 								= (int) $config['x'];
		$y 								= (int) $config['y'];
		$color 						= $this->getConfigValue( $project, $config, 'color');
		$font 						= $this->getConfigValue( $project, $config, 'font');
		$font_size 				= $this->getConfigValue( $project, $config, 'font_size' );
		$align 						= $this->getConfigValue( $project, $config, 'align');

	  	if( strlen($text) > $line_max_chars ) {
		    $line = '';
		    $line_length = 0;
		    $total = 0;
		    $words = explode( ' ', $text );
		    $ctr =  count( $words );

		    for ( $i = 0; $i < $ctr; $i++ ) {
		      $word = $words[$i];
		      $line_length  = ( $line != '' ) ? strlen($line) : 0;
		      if( ($i + 1) < $ctr ) {
		        $nextword = $words[$i + 1];
		        $total = $line_length + strlen($nextword);
		        $total++;
		      }
		      if( $line_length >= $line_max_chars  || $total >= $line_max_chars ) {
		        $this->add_text( $image, $line, $x, $y, $color, $font, $align, $font_size );
		        $y += $line_height;
		        $line = $word . ' ';
		        $total = 0;
		      } else {
		        $line .= $word . ' ';
		      }
		    }
	    	$this->add_text( $image, $line, $x, $y, $color, $font, $align, $font_size );
	  	} else {
	    	$this->add_text( $image, $text, $x, $y, $color, $font, $align, $font_size );
	  	}
	}

	/**
	 * Add text to image using config params
	 * @param [type]  &$image [description]
	 * @param [type]  $text   [description]
	 * @param [type]  $x      [description]
	 * @param [type]  $y      [description]
	 * @param [type]  $color  [description]
	 * @param string  $family [description]
	 * @param string  $align  [description]
	 * @param integer $size   [description]
	 */
	private function add_text( &$image,
	        $text, $x, $y, $color,
	        $family = 'Futuri Condensed Extra Bold.ttf',  // default font family
	        $align = 'left',
	        $size = 50 ) {

	  $image->text( $text, $x, $y, function( $font ) use ( $family, $color, $align, $size) {
	      $font->file( get_stylesheet_directory() . '/badge/' . $family );
	      $font->size( $size );
	      $font->color( $color );
	      $font->align( $align );
	      $font->valign( 'middle' );
	  });

	}

}
