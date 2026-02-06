{load_presentation_object filename="gallery" assign="objGallery"}
{assign var="catId" value=$smarty.const.GALLERY_ID}
{assign var="type_data" value=['catId'=>$catId , 'is_active'=>1]}
{assign var='list_gallery_pic' value=$objGallery->listGalleryPic($type_data)}

<section class='d-none d-lg-flex gallery'>
    {if $list_gallery_pic}
        {foreach $list_gallery_pic as $item}
    <div class='col-lg-4 p-0 one h-500px'>
        <a href='{$item.pic}' data-fancybox="gallery">
            <img  src="{$item.pic}" alt="{$item.alt}" title='{$item.title}'>
            <div>
                <h3>{$item.title}</h3>
            </div>
        </a>
    </div>
        {/foreach}
        {else}
        <div class='col-lg-4 p-0 one h-500px error'>
            <p>##Noresult##</p>
        </div>
    {/if}


</section>
<section class='d-flex d-lg-none gallery-ris'>
    <div class="banner-owl">
        <div class="owl-banner-gallery owl-carousel owl-theme">
            {if $list_gallery_pic}
            {foreach $list_gallery_pic as $item}
            <div class="item">
                <a href="{$item.pic}" alt="{$item.alt}" data-fancybox="gallery">
                    <img src="{$item.pic}" alt="{$item.alt}" title='{$item.title}'>
                    <div>
                        <h3>{$item.title}</h3>
                    </div>
                </a>
            </div>
            {/foreach}
            {else}
                <div class='col-lg-4 p-0 one h-500px error'>
                    <p>##Noresult##</p>
                </div>
            {/if}
        </div>
    </div>
</section>
{literal}
    <script src="assets/modules/js/owl.carousel.min.js"></script>
    <script src="assets/modules/js/jquery.fancybox.min.js"></script>
    <script>
      $(document).ready(function () {
        $('.owl-banner-gallery').owlCarousel({
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