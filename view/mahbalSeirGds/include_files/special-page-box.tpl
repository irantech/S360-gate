{load_presentation_object filename="specialPages" assign="special_pages"}
{assign var="best_item_1" value=$special_pages->getPageById(1)}
{assign var="best_item_2" value=$special_pages->getPageById(2)}
{assign var="best_item_3" value=$special_pages->getPageById(3)}
{assign var="best_item_4" value=$special_pages->getPageById(4)}
<section class="sec_ads">
    <div class="container">
        <div class="owl-ads owl-carousel owl-theme">
            {if $best_item_1 }
            <div class="item">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/{$best_item_1['position']}" target='_blank'>
                    <img alt="{$best_item_1['title']}" src="{$best_item_1['files']['main_file']['src']}"/>
                    <h2>{$best_item_1['title']}</h2>
                </a>
            </div>
            {/if}
            {if $best_item_2 }
                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/page/{$best_item_2['position']}" target='_blank'>
                        <img alt="{$best_item_2['title']}" src="{$best_item_2['files']['main_file']['src']}"/>
                        <h2>{$best_item_2['title']}</h2>
                    </a>
                </div>
            {/if}
            {if $best_item_3 }
                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/page/{$best_item_3['position']}" target='_blank'>
                        <img alt="{$best_item_3['title']}" src="{$best_item_3['files']['main_file']['src']}"/>
                        <h2>{$best_item_3['title']}</h2>
                    </a>
                </div>
            {/if}
            {if $best_item_4 }
                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/page/{$best_item_4['position']}" target='_blank'>
                        <img alt="{$best_item_4['title']}" src="{$best_item_4['files']['main_file']['src']}"/>
                        <h2>{$best_item_4['title']}</h2>
                    </a>
                </div>
            {/if}
        </div>
    </div>
</section>