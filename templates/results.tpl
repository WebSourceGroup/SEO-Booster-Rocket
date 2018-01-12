<div id="container" style="display: table; width: 100%">
  <div id="row" style="display: table-row; width: 100%">
   <div id="left" style="display: table-cell; width: 15%;">
	{include file="search.tpl"}
    <h5 id="notice">{$notice}</h5>
    <h5 id="notice">Number of Results: {$results|count}</h5>
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
	<tr>
		<th>Name</th>
		<th>Address</th>
		<th>Open?</th>
		<th>Rating</th>
		<th>Photos/Contact Names?</th>
	</tr>

{foreach from=$results item=result name=count}
        {if isset($result['name'])}
        <tr>
                <td><a name="{$result['id']}"></a>{$result['name']}</td>
                <td>{$result['formatted_address']|replace:", United States":""}</td>
                <td>
                {if isset($result['opening_hours'])}
                        {if {$result['opening_hours']['open_now']} == 1}Yes{elseif {$result['opening_hours']['open_now']} == 0}No{/if}
                {/if}
                        </td>
		<td>{$result['rating']}</td>
                <td>{if isset($result['photos'])}{$result['photos'][0]['html_attributions'][0]|replace:"<a href=":"<a target='_blank' href="}{/if}</td>
        </tr>
        {/if}
{foreachelse}
	<tr><td>No Results were Found. Please Try Again</td></tr>
{/foreach}
</table>
