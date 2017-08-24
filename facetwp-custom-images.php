<?php
/*
Plugin Name: FacetWP - Dropdown Images
Description: 
Version: 1.0.0
*/

define( 'FDI_VERSION', '1.0.0' );
define( 'FDI_URL', plugins_url( '', __FILE__ ) );

/**
 * enqueues
 */
function fdi_enqueue_scripts() {

	// register assets
	wp_enqueue_script( 'fdi-front', FDI_URL . '/assets/js/msdropdown/jquery.dd.min.js', array( 'jquery' ), FDI_VERSION, true );
	wp_enqueue_style( 'fdi-front', FDI_URL . '/assets/css/msdropdown/dd.css', array(), FDI_VERSION );

}
add_action( 'wp_enqueue_scripts', 'fdi_enqueue_scripts' );

/**
 * inline scripts and styles
 */
function fdi_add_inline() { ?>
    <style>
        .dd img { width: 20px; display: inline-block; }
        .dd { width: 100% !important; }
    </style>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                $("body .facetwp-facet-categories select").msDropDown();
            });
        })(jQuery);
    </script>
<?php }
add_action( 'wp_footer', 'fdi_add_inline' );

/**
 * filters facetwp_facet_html output to add data-value="" for image to add to dropdown
 *
 * @param $output
 * @param $params
 *
 * @return mixed
 */
function fdi_filter_html( $output, $params ) {
	if ( 'categories' == $params['facet']['name']  ) {

		$search = array(
			'value="post-formats"',
			'value="media-2"',
        );
		$replace = array(
			'value="post-formats" data-image="' . FDI_URL . '/assets/icons/pencil.png"',
			'value="media-2" data-image="' . FDI_URL . '/assets/icons/images.png"',
        );

		$output = str_replace( $search, $replace, $output );
	}
	return $output;
}
add_filter( 'facetwp_facet_html', 'fdi_filter_html', 10, 2 );