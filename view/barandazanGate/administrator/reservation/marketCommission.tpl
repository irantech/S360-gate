{load_presentation_object filename="marketplaceCommission" assign="objCommission"}
{assign var="commission" value=$objCommission->getCommissionMarketplace(['service_id' => $smarty.get.id , 'type' => $smarty.get.type])} {*گرفتن لیست تخفیف ها*}
{load_presentation_object filename="reservationHotel" assign="objHotel"}
{assign var="hotel" value=$objHotel->getHotelById(['id' => $smarty.get.id])}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="marketHotel">لیست هتل ها</a></li>
                <li class="active">تعیین کمیسیون دریافتی از هتل مارکت پلیس</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تعیین کمیسیون دریافتی از {$hotel['name']}</h3>
                <p class="text-muted m-b-30"></p>
                <form name="marketplace_commission" id="marketplace_commission" method="post" data-toggle="validator">
                    <input type="hidden" name="service_id" id="service_id" value="{$smarty.get.id}">
                    <input type="hidden" name="service_type" id="service_type" value="{$smarty.get.type}">
                    <input type="hidden" name="method" id="method" value="insertCommissionMarketplace">
                    <div class="row">
                        <div class="form-group col-sm-6 ">
                            <label for="type_commission" class="control-label">نوع کمیسیون</label>
                            <select class="form-control" name="type_commission" id="type_commission" >
                                <option value=""> انتخاب کنید...</option>
                                <option value="price" {if $commission['type_commission'] == 'price'}selected{/if}>ریالی</option>
                                <option value="percent" {if $commission['type_commission'] == 'percent'}selected{/if}>درصدی</option>
                            </select>
                        </div>


                        <div class="form-group col-sm-6 ">
                            <label for="amount_commission" class="control-label">میزان کمیسیون</label>
                            <input type="text" name="amount_commission" id="amount_commission" class="form-control"
                                   value="{$commission['amount_commission']}">
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" id="submitForm" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/marketplaceCommission.js"></script>

