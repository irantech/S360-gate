{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight-iran'=>'Flight_internal-tab','flight-external'=> 'Flight_external-tab',
                                    'hotel-iran' => 'Hotel_internal-tab','hotel-external' => 'Hotel_external-tab',
                                    'tour-iran' => 'Tour_internal-tab','tour-external' => 'Tour_external-tab',
                                    'bus' => 'Bus-tab','visa' => 'Visa-tab'
]}

{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage and $key eq 'flight-iran'}
        <style>
            .banner {
             background-image: url("{$homePage.files.main_file.src}");
            }
        </style>
    {/if}
    {assign var="homePage" value=""}
{/foreach}

<style>
    .banner {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        background-image: url("{$page.files.main_file.src}");
    {/if}
    }
</style>


<script>
    {literal}
    if($(window).width() > 576){
      {/literal}
        {foreach $searchServices as $key => $val}
            {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
            {if $homePage}
                {literal}
                  $('#{/literal}{$val}{literal}').click(function () {$('.banner').css('background-image' , 'url("{/literal}{$homePage.files.main_file.src}{literal}")')});
                {/literal}
            {/if}
        {/foreach}
    {literal}
    }
</script>
{/literal}