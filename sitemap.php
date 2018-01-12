<?php

/*
 *
 * This file simply takes all the registered States, Counties & Towns & creates
 * a unique Sitemap that contains over 50,000 unique pages!
 *
 */

$sitemap = new SEO_Booster_Rocket_Sitemap;

header("Content-type: text/xml");
print $sitemap->retSiteMap();

class SEO_Booster_Rocket_Sitemap {
        private $connection;
        function __construct() {
                $this->connect();
                $this->geo_path = 'https://usayo.ga/find-yoga-studio-by-geography/';
        }
        private function connect() {
                $this->connection = mysql_connect("localhost","usayoga","fzxo83m4texo14r0m") or die("Cannot connect to database engine");
                mysql_select_db("usayoga",$this->connection) or print("Cannot connect to database");
        }
        private function cleanVariable($var) {
                return htmlspecialchars(mysql_real_escape_string(preg_replace('/\\\\/','',$var)));
        }
        public function retCitiesShort() {
                $results = Array();
                $result = mysql_query("SELECT DISTINCT city,county,state_short FROM wsg_usa_yoga_geo ORDER BY city",$this->connection);
                while($row = mysql_fetch_array($result)) {
                        array_push($results,array('name'=>$row['city'],'url'=>$this->geo_path.$row['state_short']."/".$row['county']."/".$row['city']));
                }
                return $results;
        }
        public function retCities() {
                $results = Array();
                $result = mysql_query("SELECT DISTINCT city,county,state_full FROM wsg_usa_yoga_geo ORDER BY city",$this->connection);
                while($row = mysql_fetch_array($result)) {
                        array_push($results,array('name'=>$row['city'],'url'=>$this->geo_path.$row['state_full']."/".$row['county']."/".$row['city']));
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
