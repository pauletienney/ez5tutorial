{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{let search=false()}
{section show=$use_template_search}
    {set page_limit=10}
    {set search=fetch( 'ezfind', 'search',
                        hash( 'query', $search_text,
                              'section_id', $search_section_id,
                              'subtree_array', $search_subtree_array,
                              'sort_by', hash( 'modified', 'desc' ),
                              'offset', $view_parameters.offset,
                              'limit', $page_limit )
                             )}
    {set search_result=$search['SearchResult']}
    {set search_count=$search['SearchCount']}
    {set stop_word_array=$search['StopWordArray']}
    {set search_data=$search}
{/section}

<form action={'/content/search/'|ezurl} method="get">

<div class="context-block content-search">
{* DESIGN: Header START *}<div class="box-header"><div class="box-ml">
<h1 class="context-title">{'Search'|i18n( 'design/admin/content/search' )}</h1>

{* DESIGN: Mainline *}<div class="header-mainline"></div>

{* DESIGN: Header END *}</div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-content">

<div class="context-attributes">

<div class="block">
    <div id="ezautocomplete">
        <input class="halfbox" type="text" name="SearchText" id="Search" value="{$search_text|wash}" />
        <input class="button"  name="SearchButton" type="submit" value="{'Search'|i18n( 'design/admin/content/search' )}" />
        <div id="mainarea-autocomplete-rs"></div>
    </div>
</div>

{if and(count($search_subtree_array)|eq(1),$search_subtree_array.0|ne(1))}
<div class="block">
<label><input type="radio" name="SubTreeArray" value="1" />{'All content'|i18n('design/admin/content/search')}</label>
{def $search_node = fetch('content', 'node', hash( 'node_id', $search_subtree_array.0 ))}
<label><input type="radio" name="SubTreeArray" value="{$search_subtree_array.0}" checked="checked" />{'The same location'|i18n('design/admin/content/search')} ({$search_node.name|wash})</label>
{undef $search_node}
</div>
{/if}

<div class="block">
    {let adv_url=concat( '/content/advancedsearch/', $search_text|count|gt( 0 )|choose('', concat( '?SearchText=', $search_text|urlencode ) ) )|ezurl}
    {'For more options try the %1Advanced search%2.'|i18n( 'design/admin/content/search', 'The parameters are link start and end tags.', array( concat( '<a href=', $adv_url, '>' ), '</a>' ) )}
    {/let}
</div>

{* Excluded words. *}
{section show=$stop_word_array}
<p>
{'The following words were excluded from the search'|i18n( 'design/admin/content/search' )}:
{section name=StopWord loop=$stop_word_array}
    {$StopWord:item.word|wash}
    {delimiter}, {/delimiter}
{/section}
</p>
{/section}

{* No matches. *}
{if $search_count|not}
<h2>{'No results were found while searching for <%1>'|i18n( 'design/admin/content/search',, array( $search_text ) )|wash}</h2>
    <p>{'Search tips'|i18n( 'design/admin/content/search' )}</p>
    <ul>
        <li>{'Check spelling of keywords.'|i18n( 'design/admin/content/search' )}</li>
        <li>{'Try changing some keywords e.g. &quot;car&quot; instead of &quot;cars&quot;.'|i18n( 'design/admin/content/search' )}</li>
        <li>{'Try more general keywords.'|i18n( 'design/admin/content/search' )}</li>
        <li>{'Fewer keywords result in more matches. Try reducing keywords until you get a result.'|i18n( 'design/admin/content/search' )}</li>
    </ul>
{/if}

</div>
{* DESIGN: Content END *}</div></div></div>

</div>

{* Search result. *}
{if $search_count}
<div class="context-block">
{* DESIGN: Header START *}<div class="box-header"><div class="box-ml">
<h2 class="context-title">{'Search for <%1> returned %2 matches'|i18n( 'design/admin/content/search',, array( $search_text, $search_count ) )|wash}</h2>



{* DESIGN: Header END *}</div></div>

{* DESIGN: Content START *}<div class="box-bc"><div class="box-ml"><div class="box-content">

{include name=Result uri='design:content/searchresult.tpl' search_result=$search_result}

<div class="context-toolbar">
{include name=Navigator
         uri='design:navigator/google.tpl'
         page_uri='/content/search'
         page_uri_suffix=concat( '?SearchText=', $search_text|urlencode, $search_timestamp|gt( 0 )|choose( '', concat( '&SearchTimestamp=', $search_timestamp ) ), '&SubTreeArray=',$search_subtree_array|implode( ',' ) )
         item_count=$search_count
         view_parameters=$view_parameters
         item_limit=$page_limit}
</div>
{* DESIGN: Content END *}</div></div></div>
</div>
{/if}

</form>

{ezscript_require( array('ezjsc::jquery', 'ezjsc::yui2', 'ezajax_autocomplete.js') )}
<script type="text/javascript">
jQuery('#mainarea-autocomplete-rs').css('width', jQuery('input#Search').width());
var autocomplete = new eZAJAXAutoComplete({ldelim}
    url: "{'ezjscore/call/ezfind::autocomplete'|ezurl('no')}",
    inputid: 'Search',
    containerid: 'mainarea-autocomplete-rs',
    minquerylength: {ezini( 'AutoCompleteSettings', 'MinQueryLength', 'ezfind.ini' )},
    resultlimit: {ezini( 'AutoCompleteSettings', 'Limit', 'ezfind.ini' )}
{rdelim});
</script>

{/let}
