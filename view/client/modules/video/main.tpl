
{load_presentation_object filename="video" assign="objVideo"}
{*{assign var="list_video" value=$objVideo->listVideo()}*}
{assign var="type_data" value=['is_active'=>1 , 'limit' =>100]}
{assign var='list_video' value=$objVideo->listVideo($type_data)}
<div class=""  style='margin-top: 40px'>

    {if $list_video}
    <div class="aboutiran_grid" >
        {foreach $list_video as $item}
        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/video/{$item.id}" class="aboutiran_box" >
            <div class="">

                <iframe src="{$item['iframe_code']}"></iframe>
            </div>
            <h2>{$item.title}</h2>
            <p>{$item.tiny_text}</p>
            <button>##ReadMore##</button>
        </a>
        {/foreach}
    </div>
    {else}
        <div class="aboutiran_grid" style="text-align: right;">
                <p class='error'>
                  ##NotResultsFound##
                </p>
        </div>
    {/if}
    <div class="aboutiran_grid error" id='citySearchRes' style='display: none ; text-align: right;' >
        <p >
            ##NotResultsFound##
        </p>
    </div>
</div>
{if $list_video}
<div class="owl-carousel owl-theme owl-mobile" >
    {foreach $list_video as $item}
    <div class="item" >
        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/video/{$item.id}" class="aboutiran_box">
            <div class="img_box">
                <iframe width="420" height="345" src="{$item.iframe_code}">
                </iframe>
            </div>
            <h2>{$item.title}</h2>
            <p>{$item.tiny_text}</p>
            <button>##ReadMore##</button>

     </a>
    </div>
{/foreach}
</div>
{/if}

{literal}
    <script src="assets/modules/js/video.js"></script>
    <script src="assets/modules/js/owl.carousel.min.js"></script>
{/literal}