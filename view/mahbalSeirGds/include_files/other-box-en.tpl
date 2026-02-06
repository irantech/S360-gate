
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}
{assign var="socialLinksArray" value=['telegram'=>'telegramHref','whatsapp'=> 'whatsappHref','instagram' => 'instagramHref','aparat' => 'aparatHref','youTube' => 'youtubeHref','facebook' => 'facebookHref','linkedin' => 'linkeDinHref' , 'twitter' => 'twitterHref']}

{foreach $socialLinks as $key => $val}
 {assign var=$socialLinksArray[$val['social_media']] value=$val['link']}
{/foreach}
<div class="float-sm">
 <div class="__telegram_class__ fl-fl float-gp">
  <i class="fab fa-telegram"></i>
  <a class="SMTelegram" href="{if $telegramHref}{$telegramHref}{/if}" target="_blank">JoinUs</a>
 </div>
 <div class="__whatsapp_class__ fl-fl float-rs">
  <i class="fab fa-whatsapp"></i>
  <a class="SMWhatsApp" href="{if $whatsappHref}{$whatsappHref}{/if}" target="_blank">ContactUs</a>
 </div>
 <div class="__instagram_class__ fl-fl float-ig">
  <i class="fab fa-instagram"></i>
  <a class="SMInstageram" href="{if $instagramHref}{$instagramHref}{/if}" target="_blank">FollowUs</a>
 </div>
</div>