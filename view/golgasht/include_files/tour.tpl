{assign var="data_search_public" value=['page_type'=>'attach']}
{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}
{if $specialPageData[0] }
<section class="i_modular_blog blog pt-5">
<div class="container">
<h2 class="title mb-5">تور های گروهی</h2>
<div class="parent">
{if $specialPageData[0] }
<a class="__i_modular_c_item_class_1 div1" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[0]['slug']}">
<img alt="{$specialPageData[0]['title']}" class="__image_class__" src="{$specialPageData[0].files.main_file.src}"/>
<div>
<h2 class="__title_class__">{$specialPageData[0]['title']}</h2>
    {*<h3 class="__heading_class__">{$specialPageData[0]['heading']}</h3>*}
</div>
</a>
{/if}
{if $specialPageData[1] }
<a class="__i_modular_c_item_class_2 div2" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[1]['slug']}">
<img alt="{$specialPageData[1]['title']}" class="__image_class__" src="{$specialPageData[1].files.main_file.src}"/>
<div>
<h2 class="__title_class__">{$specialPageData[1]['title']}</h2>
    {*<h3 class="__heading_class__">{$specialPageData[1]['heading']}</h3>*}
</div>
</a>
{/if}
{if $specialPageData[2] }
<a class="__i_modular_c_item_class_3 div3" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[2]['slug']}">
<img alt="{$specialPageData[3]['title']}" class="__image_class__" src="{$specialPageData[2].files.main_file.src}"/>
<div>
<h2 class="__title_class__">{$specialPageData[2]['title']}</h2>
    {*<h3 class="__heading_class__">{$specialPageData[2]['heading']}</h3>*}
</div>
</a>
{/if}
    {if $specialPageData[3] }
        <a class="__i_modular_c_item_class_1 div1" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[3]['slug']}">
            <img alt="{$specialPageData[3]['title']}" class="__image_class__" src="{$specialPageData[3].files.main_file.src}"/>
            <div>
                <h2 class="__title_class__">{$specialPageData[3]['title']}</h2>
                {*<h3 class="__heading_class__">{$specialPageData[0]['heading']}</h3>*}
            </div>
        </a>
    {/if}
    {if $specialPageData[4] }
        <a class="__i_modular_c_item_class_2 div2" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[4]['slug']}">
            <img alt="{$specialPageData[4]['title']}" class="__image_class__" src="{$specialPageData[4].files.main_file.src}"/>
            <div>
                <h2 class="__title_class__">{$specialPageData[4]['title']}</h2>
                {*<h3 class="__heading_class__">{$specialPageData[1]['heading']}</h3>*}
            </div>
        </a>
    {/if}
    {if $specialPageData[5] }
        <a class="__i_modular_c_item_class_3 div3" href="{$smarty.const.ROOT_ADDRESS}/page/{$specialPageData[5]['slug']}">
            <img alt="{$specialPageData[5]['title']}" class="__image_class__" src="{$specialPageData[5].files.main_file.src}"/>
            <div>
                <h2 class="__title_class__">{$specialPageData[5]['title']}</h2>
                {*<h3 class="__heading_class__">{$specialPageData[2]['heading']}</h3>*}
            </div>
        </a>
    {/if}

</div>
</div>
</section>
{/if}