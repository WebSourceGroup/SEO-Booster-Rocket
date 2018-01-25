<div id="container" style="display: table; width: 100%">
  <div id="row" style="display: table-row; width: 100%">
   <div id="left" style="display: table-cell; width: 15%;">
	{include file="search.tpl"}
    <h5 id="notice">Google: {$notice_google}</h5>
    <h5 id="notice">Yelp: {$notice_yelp}</h5>
    <h5 id="notice">Number of Results: {$results_combined|count}</h5>
    <div id="notice">
	<a href="#results">Take me to the Results!</a>
    </div>
   </div>
   <div id="right" style="display: table-cell; width: 80%;">
	<h5>Map of Results</h5>
	{include file="maps.tpl"}
   </div>
  </div>
</div>
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
	<tr>
                <td><a name="{$result['id']}"></a>{$result['name']}</td>
		<td>{$result['address']}</td>
		<td>{$result['rating']}</td>
		<td>{$result['phone']}</td>
		<td>{$result['photos']}</td>
	</tr>
{foreachelse}
	<tr><td>No Results were Found. Please Try Again</td></tr>
{/foreach}

</table>
