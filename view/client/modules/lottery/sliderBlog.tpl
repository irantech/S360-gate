{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/mag-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/mag.css'>
{/if}


{*<link rel='stylesheet' href='assets/modules/css/mag.css'>*}
{if $articles}
<div class='d-flex flex-wrap parent-slider-blog'>
    <section class="box_three text-right w-100">
        <div class="parent_owl">
            <div class="titel_owl_mag">
                <h4>
                    <i class="fa fa-books"></i>
                    ##PopularArticles##
                </h4>
            </div>
            <div class="owl-carousel owl-theme owl_mag">
                {foreach $articles as $article}
                    <div class="item">
                        <div class='div_up'>
                            <div class="img_card">
                                <a href="{$article['link']}">
                                    <img src="{$article['image']}"
                                         alt="{$article['alt']}">
                                </a>
                                <div class='d-flex w-100 flex-wrap gap-7 mt-2'>
                                    {if isset($article['categories_array'])}

                                        {foreach $article['categories_array'] as $category}
                                            <a href='{$category['link']}' class='badge badge-primary px-2 py-1'>
                                                {$category['title']}
                                            </a>
                                        {/foreach}

                                    {/if}

                                </div>
                            </div>
                            <div class="text-card-mag">
                                <a href="{$article['link']}">
                                    <h3>
                                        {$article['heading']}
                                    </h3>
                                </a>
                                <p>
                                    {$article['tiny_text']}
                                </p>
                            </div>
                            <div class="created-at-box">
                                <div class="calender">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M112 0C120.8 0 128 7.164 128 16V64H320V16C320 7.164 327.2 0 336 0C344.8 0 352 7.164 352 16V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H96V16C96 7.164 103.2 0 112 0zM416 192H312V264H416V192zM416 296H312V376H416V296zM416 408H312V480H384C401.7 480 416 465.7 416 448V408zM280 376V296H168V376H280zM168 480H280V408H168V480zM136 376V296H32V376H136zM32 408V448C32 465.7 46.33 480 64 480H136V408H32zM32 264H136V192H32V264zM168 264H280V192H168V264zM384 96H64C46.33 96 32 110.3 32 128V160H416V128C416 110.3 401.7 96 384 96z"/></svg>
                                    {$article['created_at']}
                                </div>

                                <div class="flex-wrap justify-content-end star">

                                    <div class='d-flex justify-content-end'>
                                        {assign var="rates" value=$article['rates']['average']}
                                        {for $item=1 to 5}
                                            {if $rates > 0}
                                                <span>
                                                <i class="fa fa-solid fa-star"></i>
                                            </span>
                                            {else}
                                                <span>
                                                <i class="fa fa-solid fa-star-o"></i>
                                            </span>
                                            {/if}
                                            {assign var="rates" value=$rates-1}
                                        {/for}
                                    </div>

                                    <span class='d-flex parent-star-blog'>
                                        {$article['rates']['average']}
                                        /
                                        5
                                    <span class=' small'>
                                        ##OfTotal## {$article['rates']['count']} ##Point##
                                    </span>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </section>
</div>
{/if}
{literal}
<script>

  $(document).ready(function() {
    $('.owl_mag').owlCarousel({
      rtl: true,
      loop: false,
      navText: ['<i class=\'fas fa-chevron-right\'></i>', '<i class=\'fas fa-chevron-left\'></i>'],
      margin: 10,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplaySpeed: 3000,
      responsive: {
        0: {
          items: 1,
          nav: false,
        },
        767: {
          items: 2,
          nav: false,
        },
        1000: {
          items: 3,
        },
      },
    })
  })
</script>
{/literal}
