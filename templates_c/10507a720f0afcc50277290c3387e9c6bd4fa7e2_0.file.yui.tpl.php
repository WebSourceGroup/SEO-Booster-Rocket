<?php
/* Smarty version 3.1.31-dev/6, created on 2017-12-13 09:29:34
  from "/var/www/usayo.ga/wp-content/plugins/usayoga/templates/yui.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31-dev/6',
  'unifunc' => 'content_5a30f2fef01481_37046766',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10507a720f0afcc50277290c3387e9c6bd4fa7e2' => 
    array (
      0 => '/var/www/usayo.ga/wp-content/plugins/usayoga/templates/yui.tpl',
      1 => 1513157370,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a30f2fef01481_37046766 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 src="https://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
YUI().use('autocomplete', function (Y) {
  Y.one('body').addClass('yui3-skin-sam');
  Y.one('#yui-input-state').plug(Y.Plugin.AutoComplete, {
    resultHighlighter: 'phraseMatch',
    source: ['NY']
  });

  Y.one('#yui-input-town').plug(Y.Plugin.AutoComplete, {
    resultHighlighter: 'phraseMatch',

    source: ['Albertson', 'Amagansett', 'Amityville', 'Aquebogue', 'Asharoken', 'Atlantic Beach', 'Atlantique', 'Babylon', 'Baiting Hollow', 'Baldwin', 'Baldwin Harbor', 'Barnum Island', 'Baxter Estates', 'Bay Park', 'Bay Shore', 'Bayberry Dunes', 'Bayport', 'Bayville', 'Baywood', 'Belle Terre', 'Bellerose', 'Bellerose Terrace', 'Bellmore', 'Bellport', 'Bethpage', 'Blue Point', 'Bohemia', 'Brentwood', 'Brightwaters', 'Brookhaven', 'Brookville', 'Calverton', 'Canaan Lake', 'Captree', 'Carle Place', 'Cedarhurst', 'Center Moriches', 'Centereach', 'Centerport', 'Central Islip', 'Centre Island', 'Cherry Grove', 'Cold Spring Harbor', 'Commack', 'Copiague', 'Copiague Harbor', 'Coram', 'Cove Neck', 'Crystal Brook', 'Cupsogue Beach', 'Cutchogue', 'Davis Park', 'Deer Park', 'Dering Harbor', 'Dix Hills', 'Dunewood', 'East Atlantic Beach', 'East Farmingdale', 'East Garden City', 'East Hampton', 'East Hills', 'East Islip', 'East Marion', 'East Massapequa', 'East Meadow', 'East Moriches', 'East Northport', 'East Northport', 'East Patchogue', 'East Quogue', 'East Rockaway', 'East Setauket', 'East Shoreham', 'East Willston', 'Eastport', 'Eatons Neck', 'Elmont', 'Elwood', 'Fair Harbor', 'Farmingdale', 'Farmingville', 'Fire Island', 'Fire Island Pines', 'Fishers Island Flanders', 'Floral Park', 'Flower Hill', 'Fort Salonga', 'Franklin Square', 'Freeport', 'Garden City', 'Garden City Park', 'Garden City South', 'Gilgo', 'Glen Cove (city of)', 'Glen Head', 'Glenwood Landing', 'Gordon Heights', 'Great Neck', 'Great Neck Estates', 'Great Neck Gardens', 'Great Neck Plaza', 'Great River', 'Greenlawn', 'Greenport (village of)', 'Greenvale', 'Hagerman', 'Halesite', 'Harbor Hills', 'Harbor Isle', 'Hauppauge', 'Head of Harbor', 'Herricks', 'Hewlett', 'Hewlett Bay Park', 'Hewlett Harbor', 'Hewlett Neck', 'Hicksville', 'Holbrook', 'Holtsville', 'Huntington', 'Huntington Bay', 'Huntington Station', 'Inwood', 'Island Park', 'Islandia', 'Islip', 'Islip Terrace', 'Jamesport', 'Jericho', 'Kensington', 'Kings Park', 'Kings Point', 'Kismet', 'Lake Grove', 'Lake Ronkonkoma', 'Lake Success', 'Lakeview', 'Lattingtown', 'Laurel Hollow', 'Lawrence', 'Levittown', 'Lido Beach', 'Lindenhurst', 'Lloyd Harbor', 'Locust Valley', 'Long Beach', 'Lynbook', 'Malverne', 'Malverne Park Oaks', 'Manorhaven', 'Manhasset', 'Manorville', 'Massapequa', 'Massapequa Park', 'Mastic', 'Mastic Beach', 'Matinecock', 'Mattituck', 'Medford', 'Melville', 'Merrick', 'Middle Island', 'Mill Neck', 'Miller Place', 'Montauk', 'Moriches', 'Mount Sinai', 'Munsey Park', 'Muttontown', 'Nesconset', 'New Cassel', 'New Hyde Park', 'New Suffolk', 'Nissequogue', 'North Amityville', 'North Babylon', 'North Bay Shore', 'North Bellmore', 'North Bellport', 'North Great River', 'North Haven', 'North Hills', 'North Lindenhurst', 'North Massapequa', 'North Merrick', 'North New Hyde Park', 'North Patchogue', 'North Quoque', 'North Sea', 'North Valley Stream', 'North Wantagh', 'North Woodmere', 'Northampton', 'Northport', 'Northville', 'Noyack', 'Oak Beach', 'Oakdale', 'Ocean Bay Park', 'Ocean Beach', 'Oceanside', 'Old Bethpage', 'Old Brookville', 'Old Field', 'Old Westbury', 'Orient', 'Oyster Bay', 'Oyster Bay Cove', 'Patchogue', 'Peconic', 'Plainedge', 'Plainview', 'Plandome', 'Plandome Heights', 'Plandome Manor', 'Point Lookout', 'Point O Woods', 'Poquott', 'Port Jefferson', 'Port Jefferson Station', 'Port Washington', 'Port Washington', 'Quogue', 'Remsenburg', 'Ridge', 'Riverhead', 'Riverside', 'Robbins Rest', 'Rockville Centre', 'Rocky Point', 'Ronkonkoma', 'Roosevelt', 'Roslyn', 'Roslyn Estates', 'Roslyn Harbor', 'Roslyn Heights', 'Russell Gardens', 'Saddle Rock Estates', 'Sag Harbor', 'Sagaponack', 'Salisbury', 'Saltaire', 'Sands Point', 'Sayville', 'Sea Cliff', 'Seaford', 'Searingtown', 'Seaview', 'Selden', 'Setauket', 'Shelter Island', 'Shelter Island Heights', 'Shinnecock Hills', 'Shirley', 'Shoreham', 'Smithtown', 'Sound Beach', 'South Farmingdale', 'South Floral Park', 'South Haven', 'South Hempstead', 'South Huntington', 'South Valley Stream', 'South Westbury', 'Speonk', 'Springs', 'St. James', 'Stewart Manor', 'Stony Brook', 'Strongs Neck', 'Syosset', 'Terryville', 'The City of Glen Cove', 'The City of Long Beach', 'Thomaston', 'Town of Babylon', 'Town of Brookhaven', 'Town of East Hampton', 'Town of Hempstead', 'Town of Huntington', 'Town of Islip', 'Town of North Hempstead', 'Town of Oyster Bay', 'Town of Shelter Island', 'Town of Smithtown', 'Tuckahoe', 'Uniondale', 'University Gardens', 'Upper Brookville', 'Upton', 'Valley Stream', 'Vernon Valley', 'Village of the Branch', 'Wading River', 'Wantagh', 'Watch Hill', 'Water Island', 'Water Mill', 'West Babylon', 'West Bay Shore', 'West Fire Island', 'West Hempstead', 'West Hills', 'West Islip', 'West Manor', 'West Sayville', 'Westbury', 'Wheatley Heights', 'Williston Park', 'Woodbury', 'Woodmere', 'Woodsburgh', 'Wyandanch', 'Yaphank']

  });

});
<?php echo '</script'; ?>
>
<?php }
}
