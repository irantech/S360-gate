{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        {assign var="socialLinks"  value=$about['social_links']|json_decode:true}
        {assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref' , 'twitter' => 'twitterHref' , 'bale' => 'baleHref' , 'ita' => 'itaHref']}

        {foreach $socialLinks as $key => $val}
            {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
        {/foreach}
        <div class="i_modular_footer float-sm">
            <a class="fl-fl float-gp" href="{if $baleHref}{$baleHref}{/if}" target='_blank'>
                <img alt="bale" src="project_files/images/bale.png" />
                <span>
                   بله
                  </span>
            </a>
            <a class="fl-fl float-rs" href="{if $itaHref}{$itaHref}{/if}" target='_blank'>
                <img alt="eita" src="project_files/images/eita.png" />
                <span>
                   ایتا
                  </span>
            </a>
            <a class="__whatsapp_class__ fl-fl float-wh" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">
                <img alt="Whatsapp" src="project_files/images/Whatsapp.png" />
                <span>
                   واتساپ
                  </span>
            </a>
            <a class="__instagram_class__ fl-fl float-ig" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">
                <img alt="instagram" src="project_files/images/instagram.png" />
                <span>
                   اینستاگرام
                  </span>
            </a>
        </div>
    {/if}
                            {else}
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
                            {/if}