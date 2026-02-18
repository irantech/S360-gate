{load_presentation_object filename="repeatStepSourceFour" assign="repeat"}
{assign var="TicketReserve" value=$repeat->BookAndReserve($smarty.post)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">خرید بلیط و تبدیل بلیط اختصاصی به اشتراکی</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">{$TicketReserve.message} </h3>
                </div>

        </div>
    </div>


</div>


<script type="text/javascript" src="assets/JsFiles/listCancel.js"></script>