{$check_general = true}

{if $check_general}
<div class="i_modular_newsletter footer_widget news_main">
<h3 class="footer_title">
                            عضویت در خبر نامه
                        </h3>
<form class="w-100" id="FormSmsPrj" method="post" name="FormSmsPrj">
<label class="col-12 p-0">
<input autocomplete="off" class="__name_class__ full-name-js" id="NameSms" name="NameSms" placeholder="نام و نام خانوادگی" type="text" value=""/>
</label>
<label class="col-12 p-0">
<input class="__email_class__ email-js" id="EmailSms" name="EmailSms" onchange="Email(value,'SpamEmail')" placeholder="پست الکترونیکی" type="email" value=""/>
</label>
<label class="col-12 p-0">
<input class="__phone_class__ mobile-js" id="CellSms" name="CellSms" onchange="Mobile(value,'SpamCell')" placeholder="شماره موبایل" type="text" value=""/>
</label>
<div class="btn_mmore col-12 p-0">
<a class="__submit_class__ w-100" id="ButSms" onclick="submitNewsLetter()"> ثبت </a>
</div>
</form>
<span id="SpamCell"></span>
<span id="SpamEmail"></span>
</div>
{/if}