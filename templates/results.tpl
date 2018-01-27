<div id="container" style="display: table; width: 100%">
  <div id="row" style="display: table-row; width: 100%">
   <div id="left" style="display: table-cell; width: 15%;">
	{include file="search.tpl"}
    {if isset($notice_google)}<h5 id="notice">Google: {$notice_google}</h5>{/if}
    {if isset($notice_yelp)}<h5 id="notice">Yelp: {$notice_yelp}</h5>{/if}
    <h5 id="notice">Number of Results: {$results_combined|count}</h5>
    <div id="notice">
	<a href="#results">Take me to the Results!</a>
    </div>
   </div>
   <div id="right" style="display: table-cell; width: 80%;">
	<h5>Map of Results</h5>
	{if isset($maps_api_key)}{include file="maps.tpl"}{else}You must input a Google Maps API Key before the SEO Booster Rocket Map will work!{/if}
   </div>
  </div>
</div>

{if isset($results_combined)}

<br />
	<a name="results"></a>
	<table >
	<tr id="rocket-header">
		<th>Name</th>
		<th>Address</th>
		<th>Rating</th>
		<th>Phone</th>
		<th>Photos/Misc</th>
	</tr>

{foreach from=$results_combined item=result name=count}
	<tr id="rocket-results">
                <td><a name="{$result['id']}"></a>{$result['name']}</td>
		<td><a href="https://maps.google.com/maps/place/{$result['name']|escape}/@{$result['latitude']},{$result['longitude']}" target="_blank">{$result['address']}</a></td>
		<td>{if isset($result['rating'])}{$result['rating']}{/if}</td>
		<td nowrap>{$result['phone']}</td>
		<td>{if isset($result['photos'])}{$result['photos']}{/if}</td>
	</tr>
{foreachelse}
	<tr><td>No Results were Found. Please Try Again</td></tr>
{/foreach}

</table>
{/if}
