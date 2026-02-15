
{load_presentation_object filename="rentCar" assign="objCar"}
{assign var="carData" value=$objCar->getRentCar($smarty.const.CAR_ID)}

{assign var="getCategoriesParameter" value=$objCar->getCategoriesParameter($smarty.const.CAR_ID)}

<section class="banner-car">
    <img class="sub-bg1" src="assets/images/reserveCar/bg-sub.png" alt="img">
    <div class="container">
        <div class="parent-car-banner-grid">
            <div class="parent-text-banner-car">
                <h2> {$carData.title}</h2>
                <h4 >##Code## : {$carData.code} </h4>
                <h3>##RentEveryDay## {$carData.price_customer} ##Rial##</h3>
                {*<a  href="javascript:" class="btn-link-banner-more">
                    ##MoreInformation##
                    <i class="fa-solid fa-arrow-left"></i>
                </a>*}
            </div>
            <div  class="parent-img-banner-car" >
                {if $carData.pic}
                <img class="img-original" src="{$carData.pic_show}" alt="img" data-follow="50">
                {/if}
                <img class="img-sub1" src="assets/images/reserveCar/rad.png" alt="img">
            </div>
        </div>
    </div>
</section>

{if $carData.description}
<section class="description-car">
    <div class="container">
        <div class="title-car">
            <img src="assets/images/reserveCar/title-img.png" alt="img-title">
            <h5>##Description##</h5>
        </div>
        <div class="description-car-text">
            <p>
                {$carData.description}
            </p>
        </div>
    </div>
</section>
{/if}

{if $carData.gallery}
<section class="gallery-car">
    <div class="container">
        <div class="title-car">
            <img src="assets/images/reserveCar/title-img.png" alt="img-title">
            <h5>##NasimBeheshtGallery##</h5>
        </div>
        <div class="parent-gallery-car">
            <div class="owl-carousel owl-theme owl-gallery-car">
                {foreach $carData.gallery as $gallery}
                <div class="item">
                    <a href="{$gallery.src}" class="item-gallery-car" data-fancybox=gallery>
                        <img src="{$gallery.src}" alt="{$gallery.alt}">
                    </a>
                </div>
                {/foreach}

            </div>
        </div>
    </div>
</section>
{/if}
{if $getCategoriesParameter}
    {foreach $getCategoriesParameter as $carParam}
<section class="specifications-car">
    <div class="container">
        <div class="title-car">
            <img src="assets/images/reserveCar/title-img.png" alt="img-title">
            <h5>{$carParam.title}</h5>
        </div>
        <div class="parent-specifications-car">
            <ul class="specifications-list-car">
                {if $carParam}
                    {foreach $carParam['parameter_items'] as $itemParam}
                <li>
                    <div class="stl_r">
                        {$itemParam.question}
                    </div>
                    <div class="stl_l">
                        {$itemParam.answer}
                    </div>
                </li>
                    {/foreach}
                {/if}
            </ul>
        </div>
    </div>
</section>
    {/foreach}
{/if}
{include file="./modules/reserveCar/main.tpl"}

{literal}
    <script src="assets/js/reserveCar/owl.carousel.min.js"></script>
    <script src="assets/js/reserveCar/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/follow-js/dist/follow.min.js" data-follow-auto></script>
    <script src="assets/js/reserveCar/script.js"></script>
    <script type="text/javascript" src="assets/main-asset/js/Europcar.js"></script>
{/literal}