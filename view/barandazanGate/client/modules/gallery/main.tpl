{load_presentation_object filename="gallery" assign="objGallery"}
{assign var="type_data" value=['is_active'=>1 , 'limit' =>100 , 'order' => 'ASC' ]}
{assign var='list_gallery' value=$objGallery->listGalleryCategorySite($type_data)}


<section class='d-none d-lg-flex gallery'>

    {if $list_gallery}
        {foreach $list_gallery as $key=>$item}
            {if $key%2==0}
                {foreach $item as $counter=>$galley}
                    {if $counter == 0 || $counter == 1}
                        <div class='col-lg-6 p-0 {if $counter == 0 } one {elseif $counter == 1}two{/if}'>
                    {/if}
                        <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/gallery/{$galley.id}'>
                            <img src="{$galley.pic}" alt="{$galley.alt}">
                            <div>
                                <h3>{$galley.title}</h3>
                            </div>
                        </a>
                    {if $counter == 0 || ($item|count == 2 && $counter == 1)  || $counter == 2}
                    </div>
                    {/if}
                {/foreach}
            {/if}
            {if $key%2==1}
                {foreach $item as $counter=>$galley}
                    {if $counter == 0 || $counter == 2}
                        <div class='col-lg-6 p-0 {if $counter == 0 } two {elseif $counter == 2}one{/if}'>
                    {/if}
                    <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/gallery/{$galley.id}'>
                        <img src="{$galley.pic}" alt="{$galley.alt}">
                        <div>
                            <h3>{$galley.title}</h3>
                        </div>
                    </a>
                    {if $counter == 1  || $counter == 2 || ($item|count == 2 && $counter == 1) }
                        </div>
                    {/if}
                {/foreach}
            {/if}
        {/foreach}
    {else}
        <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
            ##NoInformationToDisplay##
        </div>
    {/if}



</section>
<section class='d-flex d-lg-none gallery-ris'>
    <div class="banner-owl">
        <div class="owl-banner owl-carousel owl-theme">
            {if $list_gallery}
            {foreach $list_gallery as $key=>$item}
            {foreach $item as $counter=>$galley}
            <div class="item">
                <a href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/gallery/{$galley.id}'>
                    <img src="{$galley.pic}" alt="{$galley.alt}">
                    <div>
                        <h3>{$galley.title}</h3>
                    </div>
                </a>
            </div>
            {/foreach}
            {/foreach}
            {else}
                <div class='col-lg-6 p-0 one error'>
                    <p>##NotResultsFound##</p>
                </div>
            {/if}
        </div>
    </div>
</section>


{literal}
    <script src="assets/modules/js/owl.carousel.min.js"></script>
    <script>
      $(document).ready(function () {
        $('.owl-banner').owlCarousel({
          loop:true,
          rtl:true,
          margin:10,
          nav:false,
          dots:true,
          autoplay:true,
          autoplayTimeout:3500,
          autoplayHoverPause:true,
          items:1,
        })
      })
    </script>
{/literal}
