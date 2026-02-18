{load_presentation_object filename="partner" assign="objectPartner"}


{assign var="allClients" value=$objectPartner->subClient($smarty.get.id)}
{assign var="getAllGroupServices" value=$objectPartner->getGroupListServicesClient($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li class="active">تعیین کمیسیون دریافتی از همکار دارای وایت لیبل</li>
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
                <h3 class="box-title m-b-0">تعیین کمیسیون دریافتی از همکار دارای وایت لیبل</h3>
                <p class="text-muted m-b-30"></p>
                <form name="client_commission" id="client_commission" method="post" data-toggle="validator">
                    <input type="hidden" name="client_id_parent" id="client_id_parent" value="{$smarty.get.id}">
                    <input type="hidden" name="method" id="method" value="insertCommissionClient">
                    <div class="row">
                        <div class="form-group col-sm-6 ">

                            <label for="client_id" class="control-label">نام همکار</label>
                            <select class="form-control" name="client_id" id="client_id">
                                <option value=""> انتخاب کنید...</option>
                                {foreach $allClients as $client}
                                    <option value="{$client['id']}">{$client['AgencyName']}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group col-sm-6 ">

                            <label for="type" class="control-label">بخش مربوطه</label>
                            <select class="form-control" name="type" id="type" onchange="selectDetailService()">
                                <option value=""> انتخاب کنید...</option>
                                {foreach $getAllGroupServices as $serviceGroup}
                                    <option value="{$serviceGroup['MainService']}">{$serviceGroup['Title']}</option>
                                {/foreach}
                            </select>
                        </div>

                        <div class="form-group col-sm-6 ">
                            <label for="detail_type" class="control-label">سرویس</label>
                            <select class="form-control" name="detail_type" id="detail_type">
                                <option value=""> انتخاب کنید...</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-6 ">
                            <label for="type_commission" class="control-label">نوع کمیسیون</label>
                            <select class="form-control" name="type_commission" id="type_commission">
                                <option value=""> انتخاب کنید...</option>
                                <option value="price">ریالی</option>
                                <option value="percent">درصدی</option>
                            </select>
                        </div>


                        <div class="form-group col-sm-6 ">
                            <label for="amount_commission" class="control-label">میزان کمیسیون</label>
                            <input type="text" name="amount_commission" id="amount_commission" class="form-control"
                                   value="">
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


<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

