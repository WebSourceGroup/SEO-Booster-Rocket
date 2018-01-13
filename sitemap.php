<?php

/*
 *
 * This file simply takes all the registered States, Counties & Towns & creates
 * a unique Sitemap that contains over 50,000 unique pages!
 *
 */

define('WP_USE_THEMES', false);
require_once("../../../wp-load.php");

$sitemap = new SEO_Booster_Rocket_Sitemap;

header("Content-type: text/xml");
print $sitemap->retSiteMap();

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
                return htmlspecialchars($this->db->_real_escape(preg_replace('/\\\\/','',$var)));
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

?>
