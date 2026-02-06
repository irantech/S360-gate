
{assign var="data_search_blog" value=['service'=>'Public','section'=>'article', 'limit' =>'4']}
{assign var='blog' value=$obj_main_page->articlesPosition($data_search_blog)}

{assign var='counter' value=0}
{assign var="article_count" value=$blog|count}
{if $blog[0]}
    {assign var='check_general' value=true}
{/if}
{if $check_general}
<div class="tourist">
    <div class="container">
        <div class="tourist-title col-xs-12"> خدمات گردشگری کیش</div>
        <div class="row row2-kh">
            {foreach $blog as $key => $item}
            <div class="__i_modular_nc_item_class_0 tour_card">
                <div class="tour_card_child">
                    <a class="tourist-img width-gallery" href="{$item['link']}" target="_blank">
                        <img alt="{$item["alt"]}" class="__image_class__"
                             src="{$item["image"]}" height="210"  width="100%"/>
                        <div class="tourist-titr-parent">
                            <div class="tourist-titr1">{$item["title"]}</div>
                            <div class="tourist-titr2"> {$item["description"]}</div>
                        </div>
                    </a>
                </div>
            </div>
            {/foreach}
        </div>
    </div>
</div>
{/if}