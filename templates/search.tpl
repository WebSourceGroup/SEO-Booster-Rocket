<div id="search_form">
        <h4>Search for a {$search_term}</h4>
        <form method="GET" action=".">
        <input type="text" placeholder="Enter Town" name="town" id="yui-input-town" value="{if isset($town)}{$town}{/if}"><br />
        <input type="text" placeholder="Enter State" name="state" id='yui-input-state' maxlength="30" value="{if isset($state)}{$state}{/if}"><br />
        <input type="submit" value="SEARCH">
        </form>
</div>
{if isset($powered_by)}<div id="notice">{$powered_by}</div>{/if}
<br />
{include file="spinner.tpl"}
