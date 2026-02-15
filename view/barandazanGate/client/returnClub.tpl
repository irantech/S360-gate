{if $smarty.get.login eq 'failed'}
<div class="s-u-content-result">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 s-u-passenger-wrapper-change">
        <span class="notice_club site-main-text-color">
        <i class="zmdi zmdi-alert-circle mart10  zmdi-hc-fw"></i>
            ##Note##
        </span>
        <div class="s-u-result-wrapper">
                <span class="s-u-result-item-change direcR iranR txt12 txtRed">
			شما اجازه دسترسی به باشگاه مشتریان را ندارید
                <br/>
                لطفا از منوی تماس با ما  با بخش <span style="font-weight: bolder; font-size: 14px;">پشتیبانی</span> تماس حاصل نمائید
            </span>
          {*  <span class="s-u-result-item-change direcR iranR txt12 txtRed">
			##NopermissiontoaccesstheClub##
                <br/>
                {assign var='europCar' value='<span style="font-weight: bolder; font-size: 14px;">##Support##</span>'}
                {functions::StrReplaceInXml(["@@europCar@@"=>$europCar],"ReturnBankMessageEuropCar")}

            </span>*}
        </div>
    </div>
</div>
{else}

<script type="text/javascript">

    window.location = 'loginUser';
</script>

{/if}

