<?php
/**
 * Plugin Name: SEO Booster Rocket
 * Plugin URI: https://websourcegroup.com/
 * Description: This plugin provides over 50,000 unique indexable web pages to your Wordpress Website!
 * Version: 1.0
 * Author: Web Source Group
 * Author URI: http://websourcegroup.com/seo-booster-rocket-wordpress-plugin-rocket-boost-seo-results/
 * License: GPL2
 */

defined( 'ABSPATH' ) or die( 'Direct access to this file is prohibited.' );

if(!class_exists('Smarty')) {
	include(__DIR__.'/smarty/libs/Smarty.class.php');
}

class SEO_Booster_Rocket_Sitemap {
        private $db;
        function __construct() {
                global $wpdb;
                $this->db = $wpdb;
                $server_scheme='http';
                if($_SERVER['HTTPS']=='on') {
                        $server_scheme='https';
                }
                $this->geo_path = $server_scheme.'://'.$_SERVER['SERVER_NAME'].get_option('booster-rocket-maps-uri');
        }
        private function cleanVariable($var) {
		return sanitize_text_field($var);
        }
        public function retCitiesShort() {
                $results = Array();
                $result = $this->db->get_results("SELECT DISTINCT city,county,state_short FROM wsg_usa_yoga_geo ORDER BY city");
                foreach($result as $res) {
                        array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_short."/".$res->county."/".$res->city));
                }
                return $results;
        }
        public function retCities() {
                $results = Array();
                $result = $this->db->get_results("SELECT DISTINCT city,county,state_full FROM wsg_usa_yoga_geo ORDER BY city");
                foreach($result as $res) {
                        array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_full."/".$res->county."/".$res->city));
                }
                return $results;
        }
        public function retSiteMap() {
                $retval='<?xml version="1.0" encoding="UTF-8"'."?".'><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

                foreach($this->retCities() as $city) {
                        $retval.='<url><loc>'.$city['url'].'</loc><changefreq>weekly</changefreq><priority>0.69</priority></url>'."\n";
                }
                foreach($this->retCitiesShort() as $city) {
                        $retval.='<url><loc>'.$city['url'].'</loc><changefreq>weekly</changefreq><priority>0.69</priority></url>'."\n";
                }
                $retval.='</urlset>';
                return $retval;
        }
}
function display_rocket_booster_sitemap() {
	if(isset($_GET['seo-booster-rocket-sitemap'])) {
		$sitemap = new SEO_Booster_Rocket_Sitemap;
		header("Content-type: text/xml");
		print $sitemap->retSiteMap();
		exit;
	}
}
add_action( 'init', 'display_rocket_booster_sitemap' );

class SEO_Booster_Rocket_HTMLify {
	private $url_path;
	private $smarty;
	function __construct() {
		$this->url_path = '';
		$this->smarty = new Smarty();
		$this->smarty->setTemplateDir(__DIR__.'/templates/');
		$this->smarty->setCompileDir(__DIR__.'/templates_c');
	}
	public function process($title,$results,$cells_per_row = 4) {
		if(is_array($results)) {
			$this->smarty->assign('title',$title);
			$this->smarty->assign('mod',intval($cells_per_row));
			$this->smarty->assign('results',array_filter($results));
		        if(get_option('booster-rocket-powered-by')==1) {
				$this->smarty->assign('powered_by','Powered by <a href="https://wordpress.org/plugins/seo-booster-rocket/" target="_blank">SEO Booster Rocket</a>, developed by <a href="https://websourcegroup.com/" target="_blank"><img src="'.plugin_dir_url(__FILE__).'/images/Web-Source-Group-Logo.png" alt="Web Source Group - We Build Businesses with Technology" /></a>');
			}
			if(get_option('booster-rocket-search-term')) {
				$this->smarty->assign('search_term',get_option('booster-rocket-search-term'));
			}
			return $this->smarty->fetch(__DIR__.'/templates/htmlify.tpl');
		}
		return '';
	}
}

class SEO_Booster_Rocket_Geography {
	private $db;
	private $geo_path;
	private $seo_db;
	function __construct() {
		global $wpdb;
                $this->db = $wpdb;
		$this->geo_path = get_option('booster-rocket-maps-uri');
		$this->seo_db = new SEO_Booster_Rocket_DB();
	}
        private function cleanVariable($var) {
		return sanitize_text_field($var);
        }
	public function retStateShortName($state_long) {
		$state_long = $this->cleanVariable($state_long);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT state_short FROM ".$this->seo_db->ret_geo_table()." WHERE state_full = '$state_long'");
		if(isset($result[0]->state_short)) {
			return $result[0]->state_short;
		}else{
			print mysql_error();
		}
		return FALSE;
	}
	public function retStatesFull() {
		$results = Array();
		$result = $this->seo_db->db->get_results("SELECT DISTINCT (state_full) FROM ".$this->seo_db->ret_geo_table()." ORDER BY state_full");	
		foreach($result as $res) {
			array_push($results,array('name'=>$res->state_full,'url'=>$this->geo_path.$res->state_full));
		}
		return $results;
	}
	public function retStatesShort() {
		$results = Array();
		$result = $this->seo_db->db->get_results("SELECT DISTINCT (state_short) FROM ".$this->seo_db->ret_geo_table()." ORDER BY state_short");	
		foreach($result as $res) {
			array_push($results,array('name'=>$res->state_short,'url'=>$this->geo_path.$res->state_short));
		}
		return $results;
	}
	public function retCounties() {
		$results = Array();
		$result = $this->seo_db->db->get_results("SELECT DISTINCT county,state_full FROM ".$this->seo_db->ret_geo_table()." ORDER By county");
		foreach($result as $res) {
			$res->county=ucwords(strtolower($res->county));
			array_push($results,array('name'=>$res->county,'url'=>$this->geo_path.$res->state_full."/".$res->county));
		}
		return $results;
	}
	public function retCountiesByStateFull($state) {
		$results = Array();
		$state = $this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT county,state_full FROM ".$this->seo_db->ret_geo_table()." WHERE state_full = '$state' ORDER BY county");
		foreach($result as $res) {
			$res->county=ucwords(strtolower($res->county));
			array_push($results,array('name'=>$res->county,'url'=>$this->geo_path.$res->state_full."/".$res->county));
		}
		return $results;
	}
	public function retCountiesByStateShort($state) {
		$results = Array();
		$state = $this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT county,state_short FROM ".$this->seo_db->ret_geo_table()." WHERE state_short = '$state' ORDER BY county");
		foreach($result as $res) {
			$res->county=ucwords(strtolower($res->county));
			array_push($results,array('name'=>$res->county,'url'=>$this->geo_path.$res->state_short."/".$res->county));
		}
		return $results;
	}
	public function retCities() {
		$results = Array();
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_full FROM ".$this->seo_db->ret_geo_table()." ORDER BY city");
		foreach($result as $res) {
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_full."/".$res->county."/".$res->city));
		}
		return $results;
	}
	public function retCitiesByStateFull($state) {
		$results = Array();
		$state = $this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_full FROM ".$this->seo_db->ret_geo_table()." WHERE state_full = '$state' ORDER BY city");
		foreach($result as $res) {
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_full."/".$res->county."/".$res->city));
		}
		return $results;
	}
	public function retCitiesByStateShort($state) {
		$results = Array();
		$state = $this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_short FROM ".$this->seo_db->ret_geo_table()." WHERE state_short = '$state' ORDER BY city");
		foreach($result as $res) {
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_short."/".$res->county."/".$res->city));
		}
		return $results;
	}
	public function retCitiesByCounty($county) {
		$results = Array();
		$county = $this->cleanVariable($county);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_full FROM ".$this->seo_db->ret_geo_table()." WHERE county = '$county' ORDER BY city");
		foreach($result as $res) {
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_full."/".$res->county."/".$res->city));
		}
		return $results;
	}
	public function retCitiesByCountyShortState($county,$state) {
		$results=Array();
		$county=$this->cleanVariable($county);
		$state=$this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_short FROM ".$this->seo_db->ret_geo_table()." WHERE county = '$county' AND state_short = '$state' ORDER BY city");
		foreach($result as $res) {
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_short."/".$res->county."/".$res->city));
		}
		return $results;
	}
	public function retCitiesByCountyFullState($county,$state) {
		$results=Array();
		$county=$this->cleanVariable($county);
		$state=$this->cleanVariable($state);
		$result = $this->seo_db->db->get_results("SELECT DISTINCT city,county,state_full FROM ".$this->seo_db->ret_geo_table()." WHERE county = '$county' AND state_full = '$state' ORDER BY city");
		foreach($result as $res) {		
			array_push($results,array('name'=>$res->city,'url'=>$this->geo_path.$res->state_full."/".$res->county."/".$res->city));
		}
		return $results;
	}
}

function ret_seo_cities( $atts ) {
	$geo = new SEO_Booster_Rocket_Geography();
	$htmlify = new SEO_Booster_Rocket_HTMLify();
	if(isset($atts['state']) && isset($atts['county']) && strlen($atts['state']) >= 2) {
		if(strlen($atts['state']) == 2) {
			return $htmlify->process("City Filtered by Short State & County: ".ucwords(strtolower(htmlspecialchars($atts['county']))).", ".htmlspecialchars($atts['state']),$geo->retCitiesByCountyShortState($atts['county'],$atts['state']));
		}else{
			return $htmlify->process("City Filtered by Full State & County: ".ucwords(strtolower(htmlspecialchars($atts['county']))).", ".htmlspecialchars($atts['state']),$geo->retCitiesByCountyFullState($atts['county'],$atts['state']));
		}
	}elseif(isset($atts['state']) && strlen($atts['state']) >= 2) {
		if(strlen($atts['state']) == 2) {
			if(isset($atts['array']) && $atts['array']==TRUE) {
				return $geo->retCitiesByStateShort($atts['state']);
			}else{
				return $htmlify->process("City Filtered by Short State Name: ".htmlspecialchars($atts['state']),$geo->retCitiesByStateShort($atts['state']));
			}
		}else{
			if(isset($atts['array']) && $atts['array']==TRUE) {
				$geo->retCitiesByStateFull($atts['state']);
			}else{
				return $htmlify->process("City Filtered by Full State Name: ".ucwords(strtolower(htmlspecialchars($atts['state']))),$geo->retCitiesByStateFull($atts['state']));
			}
		}
	}elseif(isset($atts['county'])) {
		if(isset($atts['array']) && $atts['array']==TRUE) {
			return $geo->retCitiesByCounty($atts['county']);
		}else{
			return $htmlify->process("City Filtered by County: ".ucwords(strtolower(htmlspecialchars($atts['county']))),$geo->retCitiesByCounty($atts['county']));
		}
	}
	if(isset($atts['array']) && $atts['array']==TRUE) {
		return $geo->retCities();
	}else{
		return $htmlify->process("Cities",$geo->retCities());
	}
}
function ret_seo_counties( $atts ) {
	$geo = new SEO_Booster_Rocket_Geography();
	$htmlify = new SEO_Booster_Rocket_HTMLify();
	if(isset($atts['state']) && strlen($atts['state']) >= 2) {
		if(strlen($atts['state']) == 2) {
			return $htmlify->process("Counties Filtered by Short State Name: ".htmlspecialchars($atts['state']),$geo->retCountiesByStateShort($atts['state']));
		}else{
			return $htmlify->process("Counties Filtered by Full State Name: ".ucwords(strtolower(htmlspecialchars($atts['state']))),$geo->retCountiesByStateFull($atts['state']));
		}
	}
	return $htmlify->process("Counties",$geo->retCounties());
}
function ret_seo_state( $atts ) {
	$geo = new SEO_Booster_Rocket_Geography();
	$htmlify = new SEO_Booster_Rocket_HTMLify();
	if(isset($atts['full']) && $atts['full'] == "true") {
		return $htmlify->process("Full State Name",$geo->retStatesFull());
	}
	return $htmlify->process("Short State Name",$geo->retStatesShort(),10);
}
function ret_seo_long_state_to_short($state) {
	$geo = new SEO_Booster_Rocket_Geography();
	return $geo->retStateShortName($state);
}

add_filter('query_vars', 'register_query_vars');
function register_query_vars($public_query_vars) {
	$public_query_vars[] = "state";
	$public_query_vars[] = "county";
	$public_query_vars[] = "city";
	return $public_query_vars;
}

add_action('init','seo_booster_rocket_rewrite_rule');
function seo_booster_rocket_rewrite_rule() {
	if($_SERVER['REQUEST_URI'] != esc_attr(get_option('booster-rocket-maps-uri'))) { return false; }
	global $wp_rewrite;
	$wp_rewrite->flush_rules( false );

	$post_id=url_to_postid(esc_attr(get_option('booster-rocket-maps-uri')));
	$post_page='index.php?page_id='.intval($post_id);

	add_rewrite_tag('%state%','([^&]+)');
	add_rewrite_tag('%county%','([^&]+)');
	add_rewrite_tag('%city%','([^&]+)');

	//STATE
		$state_match=ltrim(esc_attr(get_option('booster-rocket-maps-uri')),'/').'([A-Za-z\ \+]+)/?$';
		$state_target=$post_page.'&state=$matches[1]';
		add_rewrite_rule($state_match,$state_target,'top');

	//COUNTY
		$county_match=ltrim(esc_attr(get_option('booster-rocket-maps-uri')),'/').'([A-Za-z\ \+]+)/([A-Za-z\ \+]+)/?$';
		$county_target=$post_page.'&state=$matches[1]&county=$matches[2]';
		add_rewrite_rule($county_match,$county_target,'top');


	//CITY
		$city_match=ltrim(esc_attr(get_option('booster-rocket-maps-uri')),'/').'([A-Za-z\ \+]+)/([A-Za-z\ \+]+)/([A-Za-z\ \+]+)/?$';
		$city_target=$post_page.'&state=$matches[1]&county=$matches[2]&city=$matches[3]';
		add_rewrite_rule($city_match,$city_target,'top');

	//print $state_match.' '.$state_target."<br />";
	//print $county_match.' '.$county_target."<br />";
	//print $city_match.' '.$city_target."<br />";
	#print "AAAAAAA";
}

add_shortcode('seo_booster_rocket_process_requests','seo_booster_rocket_process_requests');
function seo_booster_rocket_process_requests() {
	global $wp_query;
	if(isset($wp_query->query_vars['city']) && isset($wp_query->query_vars['county']) && isset($wp_query->query_vars['state'])) {
		return seo_booster_rocket_map(array());
	}elseif(isset($wp_query->query_vars['county']) && isset($wp_query->query_vars['state'])) {
		return ret_seo_cities(array('state'=>htmlspecialchars($wp_query->query_vars['state']),'county'=>htmlspecialchars($wp_query->query_vars['county'])));
	}elseif(isset($wp_query->query_vars['state'])) {
		return ret_seo_counties(array('state'=>htmlspecialchars($wp_query->query_vars['state'])));
	}else{
		return ret_seo_state(array('full'=>"true")).ret_seo_state(array());
	}
}

class SEO_Booster_Rocket_Places {
	private $places_api_key;
	private $maps_api_key;
	private $seo_db;
	function __construct($town="New York",$state="NY") {
		$this->seo_db = new SEO_Booster_Rocket_DB();
		$this->smarty = new Smarty();
		$this->smarty->setTemplateDir(__DIR__.'/templates/');
		$this->smarty->setCompileDir(__DIR__.'/templates_c');
		$this->town = $town;
		$this->state = $state;
		$this->places_api_key = get_option('booster-rocket-places-api-key');
		$this->maps_api_key = get_option('booster-rocket-maps-api-key');
		$this->base_url = "https://maps.googleapis.com/maps/api/place/textsearch/json?key=".$this->places_api_key."&";
		$this->request_count=0;
		$this->location_names=Array();
		$this->cache_age=intval(get_option( 'booster-rocket-cache-age' )); //UPDATE
	}

	public function ret_maps_api_key() {
		return $this->maps_api_key;
	}
	public function retLocationCount() {
		return count($this->location_types);
	}
        private function cleanVariable($var) {
		return sanitize_text_field($var);
        }

	private function retSearchCache($state,$city) {
		$state=$this->cleanVariable($state);
		$city=$this->cleanVariable($city);
		if(strlen($state) >= 2 && strlen($city) > 2) {
			if(strlen($state) > 2) {
				$state = $this->retStateShortName($state);
			}
			$result = $this->seo_db->db->get_results("SELECT json_response FROM ".$this->seo_db->ret_cache_table()." WHERE state = '$state' AND city = '$city' AND DATEDIFF(date,NOW()) < ".$this->cache_age); // add cache expiration mechanism.

			if(isset($result[0])) {
				return $result[0]->json_response;
			}
		}
		return FALSE;
	}
	private function delSearchCache($state,$city) {
		$state=$this->cleanVariable($state);
		$city=$this->cleanVariable($city);
		if($this->seo_db->db->query("DELETE FROM ".$this->seo_db->ret_cache_table()." WHERE state = '$state' AND city = '$city'")) {
			return TRUE;
		}
		return FALSE;
	}
	private function addSearchCache($state,$city,$json_response) {
		$state=$this->cleanVariable($state);
		$city=$this->cleanVariable($city);
		$json_response=$this->seo_db->db->_real_escape($json_response);
		if($this->seo_db->db->query("INSERT INTO ".$this->seo_db->ret_cache_table()." VALUES('$state','$city','$json_response',NOW())")) {
			return TRUE;
		}else{
			print mysql_error();
		}
		return FALSE;
	}

	public function fetch_json($next_page='') {
		$results=Array();
			if(strlen($this->state) > 2) {
				$this->state = ret_seo_long_state_to_short($this->state);
			}
			$query="query=".urlencode(esc_attr( get_option('booster-rocket-search-term')))."+near+".str_replace(" ","+",$this->town).",+".$this->state; //UPDATE
			//if(strlen($next_page) > 0) {
			//	$query.="&pagetoken=$next_page";
			//}
			//print "\tNow Fetching:  $this->base_url$query<br /><br />";
			$res = $this->retSearchCache($this->state,$this->town);
			if($res == FALSE) {
				$res = file_get_contents($this->base_url.str_replace('&amp;','&',$query));
				$this->request_count++;
				$this->addSearchCache($this->state,$this->town,$res);
				$this->smarty->assign('notice',"Using Live Results");
			}else{
				$this->smarty->assign('notice',"Using Cached Results");
			}
			//print "Results Length: ".strlen($res)."<br />";
			$json_results = json_decode($res,1);
			if(isset($json_results['error_message'])) {
				$this->smarty->assign('error',$json_results['error_message']);
				return $this->smarty->fetch(__DIR__.'/templates/error.tpl');
			}
			$is_records=0;
			foreach($json_results['results'] as $record) {
				$is_records=1;
				if(!in_array($record['name'],$this->location_names)) {
					array_push($results,$record);
					array_push($this->location_names,$record['name']);
				}
			}
			// The following code sometimes results in an infinite loop.
			//if(isset($json_results['next_page_token']) && strlen($json_results['next_page_token']) > 0 && $is_records) {
				//sleep(1);
				//array_push($results,$this->fetch_json($json_results['next_page_token'],$type));
			//}
		return $results;
	}

	public function ret_town_geo() {
		//$res = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ','+',$this->town).",+".str_replace(' ','+',$this->state)."&key=".$this->places_api_key); //Doesn't seem to need an api key anymore?
		$res = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ','+',$this->town).",+".str_replace(' ','+',$this->state));
		$this->request_count++;
		$json_result = json_decode($res,1);
		if(isset($json_result['results'][0]['geometry']['location'])) {
			return Array($json_result['results'][0]['geometry']['location']['lat'],$json_result['results'][0]['geometry']['location']['lng']);
		}else{
			#return to suffolk county ny
			return Array('40.792240','-73.138260');
		}
	}

	public function ret_request_count () {
		return $this->request_count;
	}
}


add_shortcode('seo_booster_rocket_map','seo_booster_rocket_map');
function seo_booster_rocket_map( $atts ) {
	global $wp_query;
	$places = new SEO_Booster_Rocket_Places();
	$retval=$places->smarty->fetch(__DIR__.'/templates/css.tpl');

	$town='';
	$state='';

	if(isset($_GET['town']) && strlen($_GET['town']) > 0) { $town = htmlentities($_GET['town']); }
	if(isset($_GET['city']) && strlen($_GET['city']) > 0) { $town = htmlentities($_GET['city']); }
	if(isset($_GET['state']) && strlen($_GET['state']) > 0) { $state = htmlentities($_GET['state']); }

	if(isset($wp_query->query_vars['town']) && strlen($wp_query->query_vars['town']) > 0) { $town = htmlentities($wp_query->query_vars['town']); }
	if(isset($wp_query->query_vars['city']) && strlen($wp_query->query_vars['city']) > 0) { $town = htmlentities($wp_query->query_vars['city']); }
	if(isset($wp_query->query_vars['state']) && strlen($wp_query->query_vars['state']) > 0) { $state = htmlentities($wp_query->query_vars['state']); }

	if(get_option('booster-rocket-powered-by')==1) {
		$places->smarty->assign('powered_by','Powered by <a href="https://wordpress.org/plugins/seo-booster-rocket/" target="_blank">SEO Booster Rocket</a>, developed by <a href="https://websourcegroup.com/" target="_blank"><img src="'.plugin_dir_url(__FILE__).'/images/Web-Source-Group-Logo.png" alt="Web Source Group - We Build Businesses with Technology" /></a>');
	}

	if(strlen($town) > 0 && strlen($state) > 0) {
		$places = new SEO_Booster_Rocket_Places($town,$state);
		if(get_option('booster-rocket-powered-by')==1) {
			$places->smarty->assign('powered_by','Powered by <a href="https://wordpress.org/plugins/seo-booster-rocket/" target="_blank">SEO Booster Rocket</a>, developed by <a href="https://websourcegroup.com/" target="_blank"><img src="'.plugin_dir_url(__FILE__).'/images/Web-Source-Group-Logo.png" alt="Web Source Group - We Build Businesses with Technology" /></a>');
		}
		$places->smarty->assign("search_term",htmlspecialchars($town).", ".htmlspecialchars($state));

		$places->smarty->assign('town',$town);
		$places->smarty->assign('state',$state);
		$places->smarty->assign('results',$places->fetch_json());
		$places->smarty->assign('request_count',$places->ret_request_count());
		$places->smarty->assign('geolocation',$places->ret_town_geo());
		if(get_option('booster-rocket-search-term')) {
			$places->smarty->assign('search_term',get_option('booster-rocket-search-term'));
		}
		if(isset($atts['results']) && $atts['results'] == "false") {
			$retval.=$places->smarty->fetch(__DIR__.'/templates/search.tpl');
		}else{
			$places->smarty->assign('maps_api_key',$places->ret_maps_api_key());
			$retval.=$places->smarty->fetch(__DIR__."/templates/results.tpl");
		}
	}else{
		if(get_option('booster-rocket-search-term')) {
			$places->smarty->assign('search_term',get_option('booster-rocket-search-term'));
		}
		$places->smarty->display(__DIR__.'/templates/search.tpl');
	}
	return $retval;
}

function menu_seo_booster_rocket_admin_places_maps() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );		
	}else{
		$seo_db = new SEO_Booster_Rocket_DB();
		settings_fields( 'seo-booster-rocket-places-maps' );
		do_settings_sections( 'seo-booster-rocket-places-maps' );

		if(isset($_POST)) {
			$msg="";
			$success=FALSE;
			if(isset($_POST['booster-rocket-places-api-key']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-places-api-key',$seo_db->cleanVariable($_POST['booster-rocket-places-api-key']));
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}
			if(isset($_POST['booster-rocket-maps-api-key']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-maps-api-key',$seo_db->cleanVariable($_POST['booster-rocket-maps-api-key']));
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}
			if(isset($_POST['booster-rocket-maps-uri']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-maps-uri',$seo_db->cleanVariable($_POST['booster-rocket-maps-uri']));
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}
			if(isset($_POST['booster-rocket-search-term']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-search-term',$seo_db->cleanVariable($_POST['booster-rocket-search-term']));
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}
			if(isset($_POST['booster-rocket-cache-age']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-cache-age',$seo_db->cleanVariable($_POST['booster-rocket-cache-age']));
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}
			if(isset($_POST['booster-rocket-powered-by']) && $_POST['booster-rocket-powered-by'] == 1 && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-powered-by',1);
				$msg="SEO Booster Rocket Options Saved.";
				$success=TRUE;
			}elseif(isset($_POST['booster-rocket-powered-by']) && $_POST['booster-rocket-powered-by'] == 0 && wp_verify_nonce($_REQUEST['seo-booster-rocket-update-config'],'seo-booster-rocket-update-config')==1) {
				update_option('booster-rocket-powered-by',0);
				$msg="SEO Booster Rocket Options Saved.";
                                $success=TRUE;
			}
			if(isset($_POST['seo_booster_rocket_install_tables']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-install-tables'],'seo-booster-rocket-install-tables')==1) {
				if(!$seo_db->are_tables_installed()) {
					if($seo_db->install_tables()) {
						$msg="SEO Booster Rocket Tables Installed Successfully.";
						$success=TRUE;
					}else{
						$msg="SEO Booster Rocket Could Not Be Installed.";
						$failed=TRUE;
					}
				}
			}
			if(isset($_POST['seo_booster_rocket_install_geo_data']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-install-geo'],'seo-booster-rocket-install-geo')==1) {
				if(!$seo_db->is_geography_data_installed()) {
					if($seo_db->install_geo_data()) {
						$msg="SEO Booster Rocket GEO Data Installed Successfully.";
						$success=TRUE;
					}else{
						$msg="SEO Booster Rocket GEO Data Could Not Be Installed.";
						$failed=TRUE;
					}
				}
			}
			if(isset($_POST['seo_booster_rocket_clear_geography']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-clear-geo'],'seo-booster-rocket-clear-geo')==1) {
				if($seo_db->clear_geography()) {
					$msg="SEO Booster Rocket Geography Sucessfully Cleared.";
					$success=TRUE;
				}else{
					$msg="SEO Booster Rocket Geography Failed to Clear.";
					$failed=TRUE;
				}
			}
			if(isset($_POST['seo_booster_rocket_clear_cache']) && wp_verify_nonce($_REQUEST['seo-booster-rocket-clear-cache'],'seo-booster-rocket-clear-cache')==1) {
				if($seo_db->clear_geography_cache()) {
					$msg="SEO Booster Rocket Cached Searches Sucessfully Cleared.";
					$success=TRUE;
				}else{
					$msg="SEO Booster Rocket Cached Searches Failed to Clear.";
					$failed=TRUE;
				}
			}
			if($success) {
				?><div class="updated notice"><p><? echo $msg; ?></p></div><?
			}
			if($failed) {
				?><div class="notice notice-failed"><p><? echo $msg; ?></p></div><?
			}
		}
		if(!$seo_db->are_tables_installed()) {
			?><div class="notice notice-error"><p>SEO Booster Rocket Database Tables Are Not Installed! </p><form method="POST" action=""><input type="hidden" name="seo_booster_rocket_install_tables" value="1" /><?php wp_nonce_field('seo-booster-rocket-install-tables','seo-booster-rocket-install-tables'); ?><input type="submit" value="Click Here to Install Tables Now" /></form></div><?
		}else{
			if(!$seo_db->is_geography_data_installed()) {
				?><div class="notice notice-error"><p>SEO Booster Rocket Geography Data Is Not Installed! </p><form method="POST" action=""><input type="hidden" name="seo_booster_rocket_install_geo_data" value="1" /><?php wp_nonce_field('seo-booster-rocket-install-geo','seo-booster-rocket-install-geo'); ?><input type="submit" value="Click Here to Install Geography Data Now" /></form><p>Downloading this data reqiures a connection to the Web Source Group Server. This communication is encrypted using HTTPS technologies. Please be patient as this process may take up to a minute.</p></div><?
			}
		}
		?>
		<div class="wrap">
			<h1>SEO Booster Rocket - Places & Maps</h1>
			<br />
			<form method="post" action=""> 
				<div valign="top">
					<th scope="col">Google Places API Key:</th>
					<td><input type="text" name="booster-rocket-places-api-key" size="100" placeholder="<? echo str_repeat("X",39); ?>" value="<?php echo esc_attr( get_option('booster-rocket-places-api-key' ) ); ?>" /> <a target="_blank" href="https://websourcegroup.com/how-to-get-a-google-places-api-key/">How do I get a Places API Key?</a>
					</td>
				</div>
				<div valign="top">
					<th scope="col">Google Maps API Key:</th>
					<td><input type="text" name="booster-rocket-maps-api-key" size="100" placeholder="<? echo str_repeat("X",39); ?>" value="<?php echo esc_attr( get_option('booster-rocket-maps-api-key' ) ); ?>" /> <a target="_blank" href="https://websourcegroup.com/how-to-get-a-google-maps-api-key/">How do I get a Maps API Key?</a>
					</td>
				</div>
				<div valign="top">
					<th scope="col">Booster Rocket Maps URI:</th>
					<td><input type="text" name="booster-rocket-maps-uri" size="100" placeholder="/search-for-convinience-stores/" value="<?php echo esc_attr( get_option('booster-rocket-maps-uri' ) ); ?>" /><span class="dashicons dashicons-info" data-toggle="tooltip" title="This option works in conjunction with the '[seo_booster_rocket_process_requests]' shortcode and the resulting SiteMap. It tells the plugin what URL to use for form processing. This shoudl match the page/post URL whcih uses, or holds, the seo_booster_rocket_process_requests shortcode."></span></td>
				</div>
				<div valign="top">
					<th scope="col">Places Search Term:</th>
					<td><input type="text" name="booster-rocket-search-term" size="100" placeholder="Convinience Stores" value="<?php echo esc_attr( get_option('booster-rocket-search-term' ) ); ?>" /><span class="dashicons dashicons-info" data-toggle="tooltip" title="This option determines what search term is used with the Places API. This search term shoudl be relevant to the topic of your website. ex: If your site discusses Pool Halls then put in 'Pool Halls'."></span></td>
				</div>
				<div valign="top">
					<th scope="col">Maximum Search Cache Age in Days:</th>
					<td><input type="text" name="booster-rocket-cache-age" size="100" placeholder="7" value="<?php echo esc_attr( get_option('booster-rocket-cache-age' ) ); ?>" /><span class="dashicons dashicons-info" data-toggle="tooltip" title="Searches are Cached to preserve your API Usage. This value determines the Expiration of this Cache to ensure you have up to date search results."></span></td>
				</div>
				<div valign="top">
					<th scope="col">Add a Powered By Link to Support this Plugin (Is Much Appreciated):</th>
					<td>Yes: <input type="radio" name="booster-rocket-powered-by" value="1"<?php if(get_option('booster-rocket-powered-by')==1) echo " checked"; ?> /> - No: <input type="radio" name="booster-rocket-powered-by" value="0"<?php if(get_option('booster-rocket-powered-by')==0) echo " checked"; ?> /><span class="dashicons dashicons-info" data-toggle="tooltip" title="We hope that you'll consider enabling this option. It places attribution text below your results that shows you support this plugin."></span></td>
				</div>
				<?php wp_nonce_field('seo-booster-rocket-update-config','seo-booster-rocket-update-config'); ?>
				<?php submit_button(); ?>
			</form>
				<div valign="top">
					<th scope="col">Number of Geographic Entities:</th>
					<td><? echo $seo_db->geography_data_count(); if($seo_db->geography_data_count() != 0) { ?> <form method="POST" action=""><input type="hidden" name="seo_booster_rocket_clear_geography" value="1" /><?php wp_nonce_field('seo-booster-rocket-clear-geo','seo-booster-rocket-clear-geo'); ?><input type="submit" value="Clear Geography Data" /></form> <? } ?></td>
				</div><br />
				<div valign="top">
					<th scope="col">Number of Cached Searches:</th>
					<td><? echo $seo_db->cached_geography_data_count(); if($seo_db->cached_geography_data_count() != 0) { ?> <form method="POST" action=""><input type="hidden" name="seo_booster_rocket_clear_cache" value="1" /><?php wp_nonce_field('seo-booster-rocket-clear-cache','seo-booster-rocket-clear-cache'); ?><input type="submit" value="Clear Search Cache" /></form> <? } ?></td>
				</div>

				<p>* We recommend restricting the Places API Key to your server address. This has been detected as: <b><? echo $_SERVER['SERVER_NAME']; ?></b> using the IP Address <b><? echo gethostbyname($_SERVER['SERVER_NAME']); ?></b></p>
				<p>* We recommend restricting the Maps API Key to your server referral address. This has been detected as: <b><? echo $_SERVER['SERVER_NAME']; ?></b></p>
				<p>* This plugin supports two short codes: [seo_booster_rocket_process_requests] &amp; [seo_booster_rocket_map].</p>
				<p>* One you have confirmed that this plugin is configured properly you can submit the following XML sitemap to your prefered Search Engines: <a target="_blank" href="<? echo home_url(); ?>?seo-booster-rocket-sitemap">SiteMap</a></p>
		</div>
		<style>
			form div th {
				width: 400px !important;
				min-width: 30% !important;
				max-width: 40% !important;
			}
		</style>
		<?
	}
}

function menu_seo_booster_rocket() {
	?>
                <div class="wrap">
                        <h1><?php echo esc_html( get_admin_page_title() ); ?> - Main Plugin Page</h1>
                        <br />
			<div class="updated notice header_notice">
				<div>
					<div class="header_left_div"><span class="dashicons dashicons-yes"></span>This plugin was developed by <a href="https://websourcegroup.com/" target="_blank">Web Source Group</a>.<br />
					If you like SEO Rocket Booster, please consider either <a href="https://tinyurl.com/ydaadbdy" target="_blank">Donating to the project</a> or refer <a href="https://websourcegroup.com/contact-web-source-group/request-a-free-business-consultation/" target="_blank">Web Source Group to your Business &amp; your Clients</a>!</div>
					<div class="header_right_div"><a href="https://websourcegroup.com/" target="_blank"><img src="<? echo plugin_dir_url(__FILE__); ?>/images/Web-Source-Group-Logo.png" alt="Web Source Group" /></a></div>
				</div>
			</div>
			<div class="header_left_div">
				<p>This plugin was developed with the sole purpose of increasing the indexable footprint of your Wordpress Website. This plugin can rapidly transform a 5 page web site into a 50,000+ page website in minutes!</p>
				<p>The data that is used by this plugin only supports US Based States, Counties &amp; Towns. If you have access to i18n geographic data then please <a href="https://websourcegroup.com/contact-web-source-group/" target="_blank">contact us to determine integration strategies</a>.</p>
				<p>A demo is available for viewing <a href="https://usayo.ga/search-for-a-yoga-studio/" target="_blank">Here</a> and <a href="https://usayo.ga'.esc_attr(get_option('booster-rocket-maps-uri')).'" target="_blank">Here</a>.</p>
				<h3>Configure this Plugin</h3>
				<h5><a href="admin.php?page=seo-booster-rocket-places-maps">Places & Maps</a></h5>
				<br />
				<p>* This plugin supports two short codes: [seo_booster_rocket_process_requests] &amp; [seo_booster_rocket_map].</p>
			</div>
                </div>
		<style>
			.header_notice {
				padding: 20px !important;
				border-radius: 15px;
			}
			.header_left_div {
				padding: 5px 20px 20px 20px;
				float: left;
				max-width: 60%;
				width: auto;
				font-size: 125%;
			}
		</style>
	<?
}

function add_seo_booster_rocket_menu() {
	add_menu_page( __('SEO Booster Rocket','seo-booster-rocket'),__('SEO Booster Rocket','seo-booster-rocket'),'administrator','seo-booster-rocket','menu_seo_booster_rocket','dashicons-chart-area',81);
	add_submenu_page('seo-booster-rocket','SEO Booster Rocket - Places & Maps','Places & Maps','administrator','seo-booster-rocket-places-maps','menu_seo_booster_rocket_admin_places_maps');
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-places-api-key' );
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-maps-api-key' );
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-maps-uri' );
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-search-term' );
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-cache-age' );
	register_setting( 'seo-booster-rocket-places-maps', 'booster-rocket-powered-by' );
}


add_action( 'admin_menu', 'add_seo_booster_rocket_menu' );



class SEO_Booster_Rocket_DB {
	private $geo_table;
	private $cache_table;
	private $charset;
	public $db;
	private $geo_data_url;

	function __construct() {
		global $wpdb;
		$this->db = $wpdb;
		$this->geo_table = $this->db->prefix."seo_booster_rocket_geo";
		$this->cache_table = $this->db->prefix."seo_booster_rocket_cache";
		$this->charset = $this->db->get_charset_collate();
		$this->geo_data_url="https://websourcegroup.com/download/seo-booster-rocket-geographic-data-backup/";
	}
        public function cleanVariable($var) {
		return sanitize_text_field($var);
        }
	public function ret_geo_table() {
		return $this->geo_table;
	}
	public function ret_cache_table() {
		return $this->cache_table;
	}
	public function install_tables() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		if($this->db->get_var("SHOW TABLES LIKE '".$this->geo_table."'") != $this->geo_table) {
			$sql="CREATE TABLE ".$this->geo_table." (city VARCHAR(50) NOT NULL, state_short VARCHAR(2) NOT NULL, state_full VARCHAR(50) NOT NULL, county VARCHAR(50) NOT NULL, city_alias VARCHAR(50) NOT NULL) ENGINE=InnoDB ".$this->charset.";";
			dbDelta( $sql );
		}
		if($this->db->get_var("SHOW TABLES LIKE '".$this->cache_table."'") != $this->cache_table) {
			$sql="CREATE TABLE ".$this->cache_table." (state VARCHAR(2) NOT NULL, city VARCHAR(50) NOT NULL, json_response MEDIUMTEXT NOT NULL, date DATE NOT NULL) ENGINE=InnoDB ".$this->charset.";";
			dbDelta( $sql );
		}
		return $this->are_tables_installed();
	}
	public function are_tables_installed() {
		if($this->db->get_var("SHOW TABLES LIKE '".$this->geo_table."'") != $this->geo_table || $this->db->get_var("SHOW TABLES LIKE '".$this->cache_table."'") != $this->cache_table) {
			return FALSE;
		}
		return TRUE;
	}
	public function is_geography_data_installed() {
		if($this->are_tables_installed()) {
			if($this->geography_data_count() > 0) {
				return TRUE;
			}
		}
		return FALSE;
	}
	public function geography_data_count() {
		if($this->are_tables_installed()) {
                        return $this->db->get_var("SELECT COUNT(*) FROM ".$this->geo_table);
                }
                return 0;
	}
	public function cached_geography_data_count() {
		if($this->are_tables_installed()) {
                        return $this->db->get_var("SELECT COUNT(*) FROM ".$this->cache_table);
                }
                return 0;
	}
	public function clear_geography() {
		if($this->are_tables_installed()) {
			$this->db->query("DELETE FROM ".$this->geo_table);
			if($this->geography_data_count() == 0) {
				return TRUE;
			}
		}
		return FALSE;
	}
	public function clear_geography_cache() {
		if($this->are_tables_installed()) {
			$this->db->query("DELETE FROM ".$this->cache_table);
			if($this->cached_geography_data_count() == 0) {
				return TRUE;
			}
		}
		return FALSE;
	}
	public function install_geo_data() {
		$geo_data = file_get_contents($this->geo_data_url);
		if($geo_data != FALSE) {
			//require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta($geo_data);
			return $this->is_geography_data_installed();
		}
		return FALSE;
	}
}

?>
