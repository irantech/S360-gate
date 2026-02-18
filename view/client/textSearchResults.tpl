{load_presentation_object filename="positions" assign="objPosition" }
{assign var="listPositionSearch" value=$objPosition->getAllTextSearchResultsByPosition($moduleData)}
{if  $listPositionSearch }
    <div class="flight_blog content-whatever-special-pages"  style='margin-bottom: 20px;'>
        {foreach $listPositionSearch as $list}
            <p class='hotel-city-name'>{$list['title']}</p>
            {$list['content']}
        {/foreach}
    </div>
{/if}
