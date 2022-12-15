<?php
/**
 * ABE Theme functions file
 *
 * @package VRPConnector
 * @since 1.3.5
 */

/**
 * Class abe
 *
 * Abe theme class
 */

class abe  {

	/**
	 * Theme actions - Enqueue scripts and styles.
	 */
	function actions() {
		add_action( 'wp_enqueue_scripts', [ $this, 'my_scripts_method' ] );
		add_action( 'wp_print_styles', [ $this, 'add_my_stylesheet' ] );
		add_filter( 'body_class', [$this, 'abe_body_classes'] );
		add_filter( 'request', [$this, 'alter_query_params'] );
	}

	/**
	 * Enqueuing Scripts.
	 */
	function my_scripts_method() {
        if (file_exists(get_stylesheet_directory() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.js')) {
			wp_register_script(
				'VRPjQueryUI',
				get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.js',
				[ 'jquery' ]
			);
		} else {
			wp_register_script(
				'VRPjQueryUI',
				plugins_url( '/abe/css/jquery-ui-1.12.1.custom/jquery-ui.js', dirname( __FILE__ ) ),
				[ 'jquery' ]
			);
		}
		wp_enqueue_script( 'VRPjQueryUI' );

		$this->enqueue_theme_script('vrpNamespace','vrp.namespace.js',['jquery']);
		$this->enqueue_theme_script( 'vrpMRespondModule', 'vrp.mRespond.js', [ 'jquery' ] );
		$this->enqueue_theme_script( 'vrpUIModule', 'vrp.ui.js', [ 'jquery' ] );
		$this->enqueue_theme_script( 'vrpQueryStringModule', 'vrp.queryString.js', [ 'jquery' ] );

        //Google Map Key must be replaced with generated key
		$vrpMapKey_default='';
        $vrpMapKey=get_option( 'vrpMapKey', $vrpMapKey_default );

        wp_enqueue_script( 'googleMap', 'https://maps.googleapis.com/maps/api/js?key='.$vrpMapKey);
        wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?render='.get_option( 'vrpRecaptchaSiteKey', '' ), false, false, true);

		$this->enqueue_theme_script( 'VRPthemeJS', 'js.js', [ 'jquery' ] );

		$tracking = get_option('vrpConfirmation');
		if ($tracking == 'ga4' || $tracking == 'ga4gtag') {
			$this->enqueue_theme_script( 'VRPAnalyticsJS', 'analytics.js', [ 'jquery' ] );
		}

		// Result List Map
		$this->enqueue_theme_script( 'VRPResultMap', 'vrp.resultListMap.js', [ 'jquery', 'googleMap' ] );
        // Results JS
        $this->enqueue_theme_script( 'VRPResults', 'vrp.results.js', [ 'jquery' ] );

		// Unit Page
		$this->enqueue_theme_script( 'VRPUnitPage', 'vrp.unit.js', [ 'jquery', 'googleMap' ] );

		$this->enqueue_theme_script( 'LightSlider', 'lightslider.min.js', [ 'jquery'] );

		$this->enqueue_theme_script( 'select2-js', 'select2.min.js', [ 'jquery'] );

		$this->enqueue_theme_script( 'VRPCheckoutBarefoot', 'vrp.checkout.barefoot.js', [ 'jquery' ] );

		$this->enqueue_theme_script( 'SlickJS', 'slick/slick.min.js', [ 'jquery' ] );

		$script_vars = [
			'site_url'           => site_url(),
			'stylesheet_dir_url' => get_stylesheet_directory_uri(),
			'plugin_url'         => plugins_url( '', dirname( dirname( __FILE__ ) ) ),
			'ajaxurl'            => admin_url( 'admin-ajax.php' ),
			'nonce'              => wp_create_nonce( 'vrp-xsrf-prevention' ),
			'recaptcha_site_key' => get_option( 'vrpRecaptchaSiteKey', '' )
		];
		wp_localize_script( 'VRPthemeJS', 'url_paths', $script_vars );
	}

	/**
	 * Abe body classes
	 */
	public function abe_body_classes( $classes ) {
		global $vrp;
		global $post;
		if (
			($vrp->is_vrp_page() && ($vrp->action == 'search' || $vrp->action == 'unit')) ||
			!empty($post->post_content) && has_shortcode($post->post_content, 'vrpSearch')
		) {
		    $classes[] = 'full-width';
		    return $classes;
		}
	    return [];
	}

	/**
	 * Local theme script enqueue helper.
	 *
	 * @param $handle
	 * @param $script
	 * @param $deps
	 */
	private function enqueue_theme_script( $handle, $script, $deps ) {
		if ( file_exists( get_stylesheet_directory() . '/vrp/js/' . $script ) ) {
			wp_enqueue_script(
				$handle,
				get_stylesheet_directory_uri() . '/vrp/js/' . $script,
				$deps
			);
		} else {
			wp_enqueue_script(
				$handle,
				plugins_url( '/abe/js/' . $script, dirname( __FILE__ ) ),
				$deps
			);
		}
	}

	/**
	 * Disable reserved page term for pagination
	 */
	public function alter_query_params( $request ) {
		$param_query = new WP_Query();
		$param_query->parse_query( $request );    
		unset($request['page']);
		return $request;
	}

	/**
	 * Enqueuing Stylesheets.
	 */
	public function add_my_stylesheet() {
		if ( file_exists( get_stylesheet_directory() . '/vrp/css/font-awesome.min.css' ) ) {
			wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/vrp/css/font-awesome.min.css' );
		} else {
			wp_enqueue_style( 'FontAwesome',
				plugins_url( '/abe/css/font-awesome.min.css', dirname( __FILE__ ) ) );
		}
       
        if ( file_exists( get_stylesheet_directory() . '/vrp/css/lightslider.min.css' ) ) {
            wp_enqueue_style( 'LightSlider', get_stylesheet_directory_uri() . '/vrp/css/lightslider.min.css' );
        } else {
            wp_enqueue_style( 'LightSlider',
                plugins_url( '/abe/css/lightslider.min.css', dirname( __FILE__ ) ) );
		}
		
		if ( file_exists( get_stylesheet_directory() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.css' ) ) {
			wp_enqueue_style( 'VRPjQueryUISmoothness',
				get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.css' );
		} else {
			wp_enqueue_style( 'VRPjQueryUISmoothness',
				plugins_url( '/abe/css/jquery-ui-1.12.1.custom/jquery-ui.css', dirname( __FILE__ ) ) );
		}

		if ( ! file_exists( get_stylesheet_directory() . '/vrp/css/css.css' ) ) {
			$myStyleUrl = plugins_url(
				'/abe/css/css.css', dirname( __FILE__ )
			);
		} else {
			$myStyleUrl = get_stylesheet_directory_uri() . '/vrp/css/css.css';
		}

		wp_enqueue_style( 'select2-css', get_stylesheet_directory_uri() . '/vrp/css/select2.min.css' );

		wp_enqueue_style( 'SlickCss', get_stylesheet_directory_uri() . '/vrp/css/slick.css' );

		wp_register_style( 'themeCSS', $myStyleUrl );
		wp_enqueue_style( 'themeCSS' );
	}
}

/**
 * Load miligram css for plugin settings page
 */
function abe_plugin_settings_scripts() {
	wp_register_style( 'abe_miligram_style', get_stylesheet_directory_uri() . '/vrp/css/admin/style.css', false, '1.0.0' );
	wp_enqueue_style( 'abe_miligram_style' );
	wp_enqueue_style( 'FontAwesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_script('AbejQueryUI', get_stylesheet_directory_uri() . '/vrp/css/jquery-ui-1.12.1.custom/jquery-ui.js',	[ 'jquery' ]);
	wp_enqueue_script('AbeMarked', get_stylesheet_directory_uri() . '/vrp/js/admin/commonmark.js', ['jquery']);
}

add_action( 'admin_enqueue_scripts', 'abe_plugin_settings_scripts' ); 


function generateList( $list, $options = [] ) {

	$configured_options = [ 'attr' => '', 'child' => 'children' ];

	if ( ! empty( $options['child'] ) ) {
		$configured_options['child'] = $options['child'];
	}
	if ( ! empty( $options['attr'] ) ) {
		$configured_options['attr'] = $options['attr'];
	}

	$options = (object) $configured_options;

	$recursive = function ( $dataset, $child = false, $options ) use ( &$recursive ) {

		$html = "<ul $options->attr>"; // Open the menu container.

		foreach ( $dataset as $title => $properties ) {

			$sub_menu = '';

			$children = ( ! empty( $properties[ $options->child ] ) ? true : false );

			if ( $children ) {
				$sub_menu = $recursive( $properties[ $options->children ], true, $options );
			}

			$html .= '<li class="' . ( ! empty( $properties['class'] ) ? $properties['class'] : '' ) . '"><a class="'
			         . ( ! empty( $properties['disabled'] ) && true === $properties['disabled'] ? ' disabled ' : '' )
			         . ( ! empty( $properties['selected'] ) ? ' current ' : '' ) . '" href="?'
			         . $properties['pageurl']
			         . '&show=' . $properties['show']
			         . '&page=' . $properties['page']
			         . '">' . $title . '</a>'
			         . $sub_menu . '</li>';

			unset( $children, $sub_menu );

		}

		return $html . '</ul>';
	};

	return $recursive( $list, false, $options );

}

function getPageCountInfo($data) {
	if (!empty($data->results)) {
		$total = $data->count;
		$page = $data->page;
		$currentCount = count($data->results);
		$offsetStart = ( $currentCount * $page ) - $currentCount + 1;
		$offsetEnd = $currentCount * $page;
		if ($page == $data->totalpages) {
			$offsetStart = intval($_GET['show']) * ($page - 1) + 1;
			$offsetEnd = $total;
		}
		return $offsetStart . "-" . $offsetEnd . " of " . $total . " results";
	}
}

function generateSearchQueryString() {
	$search['search'] = $_GET['search'];

	return http_build_query($search);
}

function vrp_pagination( $total_pages, $cur_page = 1 ) {
	$_SESSION['pageurl'] = $pageurl = generateSearchQueryString();
	$cur_page            = (int) esc_attr( $cur_page );
	$pageurl             = esc_attr( $pageurl );
	$show                = ( ! empty( $_GET['show'] ) ? esc_attr( $_GET['show'] ) : 12 );

	$total_range = (int) ( $total_pages > 5 ? $cur_page + 4 : $total_pages );
	$start_range = (int) ( $cur_page > 5 ? $cur_page - 4 : 1 );

	if ( $total_range > $total_pages ) {
		$total_range = $total_pages;
	}

	$list = [];

	$list['Prev'] = [
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => ( $cur_page - 1 ),
		'class'    => 'abe-pagination-btn',
		'disabled' => ( $cur_page !== 1 ? false : true )
	];

	foreach ( range( $start_range, $total_range ) as $inc_page ) {

		$inc_page = (int) esc_attr( $inc_page );

		if ( $cur_page === $inc_page ) {
			$list[ $cur_page ] = [ 'pageurl' => $pageurl, 'show' => $show, 'page' => $cur_page, 'selected' => true ];
			continue;
		}

		$list[ $inc_page ] = [ 'pageurl' => $pageurl, 'show' => $show, 'page' => $inc_page ];

	}

	$list['Last'] = [
		'active'   => false,
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => $total_pages,
		'class'    => 'abe-pagination-btn',
		'disabled' => ( $total_pages > 5 ? false : true )
	];
	$list['Next'] = [
		'active'   => false,
		'pageurl'  => $pageurl,
		'show'     => $show,
		'page'     => ( $cur_page + 1 ),
		'class'    => 'abe-pagination-btn',
		'disabled' => ( $cur_page < $total_pages ? false : true )
	];

	return generateList( $list, [ 'attr' => 'class="abe-cd-pagination"' ] );
}

if (!function_exists('stars')) {
	function stars($reviewRating) 
	{
		if (!empty($reviewRating)) {
			return (number_format($reviewRating, 2) / 5) * 100;
		}	
	}
}

function vrpsortlinks( $unit ) {

	$chainedSort = false;

	if (is_array($_GET['search']['sort'])) {
		$chainedSort = $_GET['search']['sort'];
	}

	if ( isset( $_GET['search']['order'] ) ) {
		$order = $_GET['search']['order'];
	} else {
		$order = 'low';
	}

	$search['search'] = $_GET['search'];
	unset($search['search']['sort']);
	unset($search['search']['order']);
	$pageurl = http_build_query($search) . '&';
	$sortoptions = ['Bedrooms'];

	if ( isset( $unit->Rate ) ) {
		$sortoptions[] = 'Rate';
	}

	echo "<select class='vrpsorter'>";
	echo "<option>Sort by</option>";

	if ( isset( $_GET['search']['sort'] ) ) {
		$sort = $_GET['search']['sort'];
	} else {
		$sort = '';
	}
	$show = ( ! empty( $_GET['show'] ) ? esc_attr( $_GET['show'] ) : 10 );
	foreach ( $sortoptions as $s ) {

		$pageurl = esc_attr( $pageurl );
		$order   = esc_attr( $order );

		if ($s == 'random'){
			echo '<option value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]='.$order.'">Default (random)</option>';
			continue;
		}

		if($s == 'Name'){
			echo '<option '. selectedSort('low',  $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=low">'  . $s . ' - a to z</option>';
			echo '<option '. selectedSort('high', $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=high">' . $s . ' - z to a</option>';
			continue;
		}

		if ($chainedSort === false) {
			if ( $sort == $s ) {
				if ( $order == 'low' ) {
					$order = 'High';
					$other = 'Low';
				} else {
					$order = 'Low';
					$other = 'High';
				}
	
				echo '<option '. selectedSort($order, $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $order . '">' . $s . ' - ' . $order . ' to ' . $other . '</option>';
				echo '<option '. selectedSort($other, $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=' . $other . '">' . $s . ' - ' . $other . ' to ' . $order . '</option>';
				continue;
			}

			echo '<option '. selectedSort('low', $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=low">' . $s . ' - Low to High</option>';
			echo '<option '. selectedSort('high', $s) .' value="?' . $pageurl . 'search[sort]=' . $s . '&show=' . $show . '&search[order]=high">' . $s . ' - High to Low</option>';
		
		} else { // If chained sort is used 

			foreach ($chainedSort as $k => $cSort) {

				if ($s == $cSort['key']) {

					unset($chainedSort[$k]);
					$search['search']['sort'][] = $chainedSort[0];

					$order = $cSort['order'];
					$other = $order == 'ASC' ? 'DESC' : 'ASC';

					$sortOrder = [
						'key' => $s,
						'order' => $order
					];

					$sortOther = [
						'key' => $s,
						'order' => $other
					];

					$searchOrder = $searchOther = $search;

					$searchOrder['search']['sort'][] = $sortOrder;
					$searchOther['search']['sort'][] = $sortOther;

					$pageurlOrder = http_build_query( $searchOrder );
					$pageurlOther = http_build_query( $searchOther );

					echo '<option  value="?' . $pageurlOrder . '&show=' . $show . '">' . $s . ' - ' . $order . ' to ' . $other . '</option>';
					echo '<option  value="?' . $pageurlOther . '&show=' . $show . '">' . $s . ' - ' . $other . ' to ' . $order . '</option>';
					continue;
				}
			}
		}
	}
	echo '</select>';
}

/**
 * Selects active option in Sort By filter
 */
function selectedSort($order, $s) {

	if ( $order ) {
		if ( $_GET['search']['sort'] == $s && $_GET['search']['order'] == $order ) {
			return "selected=selected";
		}
	} elseif ( $_GET['search']['sort'] == $s  ) {
		return "selected=selected";
	}
}

/**
 * Display drop down to select how many results per page to display.
 */
function vrp_resultsperpage() {
	$search['search'] = $_GET['search'];
	$fields_string =  http_build_query($search);

	$fields_string = rtrim( $fields_string, '&' );
	$pageurl       = $fields_string;

	if ( isset( $_GET['show'] ) ) {
		$show = (int) $_GET['show'];
	} else {
		$show = 12;
	}
	echo "<select autocomplete='off' name='resultCount' class='vrpshowing'>";
	echo "<option value=''>Show</option>";
	foreach ( [ 12, 24, 36 ] as $v ) {
		echo '<option ' . ( ! empty( $_GET['show'] ) && (int) $_GET['show'] == $v ? 'selected="selected"' : '' ) . ' value="?' . esc_attr( $pageurl ) . '&show=' . esc_attr( $v ) . '">' . esc_attr( $v ) . '</option>';
	}
	echo '</select>';
}

/**
 * @param string $start_date Start date in series.
 * @param int $num Number of dates in series.
 *
 * @return array
 */
function date_series( $start_date, $num ) {
	$dates = [];

	$dates[0] = $start_date;
	for ( $i = 0; $i < $num; $i ++ ) {
		$start   = strtotime( end( $dates ) );
		$day     = mktime( 0, 0, 0, date( 'm', $start ), date( 'd', $start ) + 1, date( 'Y', $start ) );
		$dates[] = date( 'Y-m-d', $day );
	}

	return $dates;
}

/**
 * @param int $from Unix time start date.
 * @param int $to Unit time end date.
 * @param bool $round Whether or not to round to the next day.
 *
 * @return float
 */
function days_to( $from, $to, $round = true ) {
	$from = strtotime( $from );
	$to   = strtotime( $to );
	$diff = $to - $from;
	$days = $diff / 86400;

	return (true === $round) ? floor( $days ) : round( $days, 2 );
}

/**
 * Generate HTML Calendar for unit page.
 *
 * @param array $r Calendar array.
 * @param int   $total_months Total Months to display.
 *
 * @return string
 */
function vrp_calendar( $r, $total_months = 5, $rates = false ) {

	$datelist = [];
	$arrivals = [];
	$departs  = [];

	foreach ( $r as $v ) {
		$from_date  = $v->start_date;
		$arrivals[] = $from_date;
		$to_date    = $v->end_date;
		$departs[]  = $to_date;
		$num        = days_to( $from_date, $to_date );
		$datelist[] = date_series( $from_date, $num );
	}

	$final_date = [];

	foreach ( $datelist as $v ) {
		foreach ( $v as $v2 ) {
			$final_date[] = $v2;
		}
	}

	$today                       = strtotime( date( 'Y' ) . '-' . date( 'm' ) . '-01' );
	$calendar                    = new \Gueststream\Calendar( date( 'Y-m-d' ) );
	$calendar->highlighted_dates = $final_date;
	$calendar->arrival_dates     = $arrivals;
	$calendar->depart_dates      = $departs;
	$the_key                     = "<div class=\"calkey\"><div class=\"key-item\"><span class=\"key isavailable\"> </span> <span> Available</span></div><div class=\"key-item\"><span class=\"key notavailable highlighted\"> </span> <span> Unavailable</span></div><div class=\"key-item\"><span class=\"key isavailable dDate\"></span> <span> Check-In Only</span></div><div class=\"key-item\"><span class=\"key isavailable aDate\"></span> <span> Check-Out Only</span></div><br style=\"clear:both;\" /></div><br style=\"clear:both;\" />";
	$ret                         = '';
	$x                           = 0;

	for ( $i = 0; $i <= $total_months; $i ++ ) {

		$nextyear  = date( 'Y', mktime( 0, 0, 0, date( 'm', $today ) + $i, date( 'd', $today ), date( 'Y', $today ) ) );
		$nextmonth = date( 'm', mktime( 0, 0, 0, date( 'm', $today ) + $i, date( 'd', $today ), date( 'Y', $today ) ) );

		$ret .= $calendar->output_calendar( $nextyear, $nextmonth, 'abe-calendar', $rates );
		if ( 3 === $x ) {
			$ret .= '';
			$x = - 1;
		}
		$x ++;
	}

	return '' . $ret . $the_key;
}
/**
 * @param $string - Input string to convert to array
 * @param string $separator - Separator to separate by (default: ,)
 *
 * @return array
 */
function comma_separated_to_array($string, $separator = ',')
{
    //Explode on comma
    $vals = explode($separator, $string);

    //Trim whitespace
    foreach($vals as $key => $val) {
        $vals[$key] = trim($val);
    }
    //Return empty array if no items found
    //http://php.net/manual/en/function.explode.php#114273
    return array_diff($vals, array(""));
}

function vrpResultsSearchForm() {
    ob_start(); ?>
    <?php include STYLESHEETPATH . "/vrp/vrpResultsSearchForm.php"; ?>
    <?php return ob_get_clean();
}

add_shortcode("vrpResultsSearchForm","vrpResultsSearchForm");

/**
 * Traverse the node tree until all results are returned (TRACK only)
 *
 * @param $targetKey - The key we are comparing to
 * @param $nodes - Nodes from $searchoptions->nodes
 * @param $return - The results recursively carried over
 *
 * @return Array
 */
function getNodeResults($targetKey, $nodes, &$return = [])
{
	if ($nodes->key == $targetKey) {
		$return[] = $nodes->value;
	}
	if (!empty($nodes->children)) {
		foreach ($nodes->children as $node) {
			getNodeResults($targetKey, $node, $return);
		}
	}
	return $return;
}
/**
 * Traverse the node tree until we match our target
 *
 * @param $nodes - Nodes from $searchoptions->nodes
 * @param $targetKey - The key we are comparing to
 * @param $targetValue - The value we are comparing to
 * @param $return - The result recursively carried over
 *
 * @return Object
 */
function traverseNodeTree($nodes, $targetKey, $targetValue, &$return = false) {
	foreach ($nodes as $node) {
		if ($node->key == $targetKey && $node->value == $targetValue) {
			$return = $node;
		} else {
			if (!empty($node->children)) {
				traverseNodeTree($node->children, $targetKey, $targetValue, $return);
			}
		}
	}
	return $return;
}