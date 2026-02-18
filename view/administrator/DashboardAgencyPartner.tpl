{load_presentation_object filename="accountcharge" assign="objAccount"}
{load_presentation_object filename="bookshow" assign="objbook"}
{load_presentation_object filename="viewLog" assign="objLog"}
{$objAccount->listAccountCharge()}
{$objbook->ticket_sell_in_time()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <!--<li class="active">Dashboard 3</li>-->
            </ol>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <!-- ============================================================== -->
    <!-- Other sales widgets -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-danger">
                <div class="panel-heading TitleSectionsDashboard">
                    <h6 style='font-weight: 500;font-size: 17px; color: #3c3939;'>
                        <i class="fa fa-exclamation-triangle"></i>
                        همکار گرامی به نکات زیر توجه فرمایید
                        <div class="pull-right">
                            <a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a>
                        </div>
                    </h6>
                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body panel-body-top modern-notice">
                        <ul>
                            <li>در صورتی که در مبالغ بلیط در زمان گزارشگیری از طریق ایرلاین ها به اختلاف حساب برخوردید ،
                                این مورد را با حسابداری ایران تکنولوژی در میان بگذارید،به شما اطمینان میدهیم هرگونه خطا
                                از طریق سیستم جبران می گردد
                            </li>

                            <li>در زمانیکه سیستم شما به اندازه کافی شارژ ندارد، برای حفظ محرمانگی سیستم شما، ما به مشتری پیغام "متاسفانه سامانه در حال بروز رسانی می باشد لطفا کمی بعد مجددا تلاش نمائید" را نمایش می دهیم و این به آن معنا است که شما باید پنل خود را شارژ بفرمایید</li>

                            <li>پیامک تایید رزرو فقط در صورتی که پنل پیامکی خریداری و شارژ نموده باشید، برای مسافر ارسال خواهد شد</li>
                            <li>از آنجایی که تمام اطلاع رسانی های سیستم از طریق شماره موبایل ثبت شده در سیستم انجام میپذیرد، لطفا اطلاعات خود را از طریق لینک مشاهده پروفایل، اطلاعات خود را تکمیل نمائید </li>
                            <li>در تنظیم مارک آپ و تخفیف خدمات خود دقت بفرمایید تا اختلاف قیمت فاحشی با رقبا نداشته باشید. در نظر داشته باشید سود شما برای پروازهای چارتری همان مارک آپی است که انجام داده اید و در پروازهای سیستمی داخلی 80% کمیسیون ایرلاین و در پروازهای خارجی مارک آپی است که انجام داده اید</li>
                            <li>تامین کنندگان پرواز و هتل در ایران و دنیا بسیار زیاد میباشد و هرکدام قیمت و سیاست رزرو و کنسلی خود را دارند برای آگاهی از این سیاست ها
                                <a href="https://www.iran-tech.com/whmcs/knowledgebase/409/-----------.html" target='_blank'>اینجا</a> را مطالعه کنید</li>

                            <li>در ایران و جهان سرویس دهندگان بسیار زیادی برای خدمات گردشگری وجود دارند. هیچ سرویس دهنده ای نمی تواند ادعا کند بهترین قیمت های جهان را دارد پس لطفا جهت دیدن مرجع قیمت هایی که به شما ارائه می دهیم همواره به سایت
                                <a href="https://safar360.com" target="_blank">safar360.com</a>
                                مراجعه بفرمایید.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading TitleSectionsDashboard">
                    <h6 style='font-weight: 50;font-size: 17px; color: #3c3939;'>
                        میزان اعتبار حساب شما
                        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a></div>
                    </h6>
                </div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <p class="OpacityZero">
                            {$objFunctions->CalculateCredit($smarty.session.memberIdCounterInAdmin)} ریال -
                        </p>
                        <p class="text-center FontSize26">
                            {$objFunctions->CalculateCredit($smarty.session.memberIdCounterInAdmin)} ریال -
                        </p>
                        <p class="OpacityZero">
                            {$objFunctions->CalculateCredit($smarty.session.memberIdCounterInAdmin)} ریال -
                        </p>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

    <!-- ============================================================== -->
    <!-- Demo table -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- /.container-fluid -->
<script src="assets/JsFiles/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
//        //ct-visits
        new Chartist.Line('#ct-visits', {
            labels: [

                {foreach $objFunctions->dateArray() as $i}
                '{$i}',
                {/foreach}

            ],
            series: [
                [
                    {foreach $objLog->showLog() as $j}
                    {$j['CountView']},
                    {/foreach}
                ],
                [
                    {foreach $objbook->ShowLogBuyTicket() as $k}

                    {if $smarty.const.TYPE_ADMIN eq '1'}{$k['reqNumber']*10}{else} {$k['reqNumber']}{/if},
                    {/foreach}
                ]

            ]

        }, {
            top: 0,

            low: 1,
            showPoint: true,

            fullWidth: true,
            plugins: [
                Chartist.plugins.tooltip()
            ],
            axisY: {
                labelInterpolationFnc: function (value) {
                    return value;
                }
            },
            showArea: true
        });

        new Chartist.Line('#CountTicketType', {
            labels: [

                {foreach $objFunctions->dateArray() as $i}
                '{$i}',
                {/foreach}

            ],
            series: [
                [
                    {foreach $objbook->CountTypeTicketCharter() as $j}
                    {$j['CountCharter']*10},
                    {/foreach}
                ],
                [
                    {foreach $objbook->CountTypeTicketSystemPublic() as $k}
                    {$k['CountPublicSystem']*10},
                    {/foreach}
                ],
                [
                    {foreach $objbook->CountTypeTicketSystemPrivate() as $M}
                    {$M['CountPrivateSystem']*10},
                    {/foreach}
                ]

            ]

        }, {
            top: 1,

            low: 0,
            showPoint: true,

            fullWidth: true,
            plugins: [
                Chartist.plugins.tooltip()
            ],
            axisY: {
                labelInterpolationFnc: function (value) {
                    return value;
                }
            },
            showArea: true
        });


    });
</script>
<style src="assets/css/Dashboar.css"></style>
