{load_presentation_object filename="counterType" assign="objCounter"}
{$objCounter->showedit($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="counterType">نوع کانتر </a></li>
                <li class="active">ویرایش نوع کانتر</li>

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
                <h3 class="box-title m-b-0">ویرایش نوع کانتر</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید نوع کانتر را در سیستم ویرایش نمائید</p>

                <form id="EditCounterType" method="post">
                    <input type="hidden" name="flag" value="EditCounterType">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">


                    <div class="form-group col-md-6 col-lg-6 col-xs-12  col-sm-12 ">
                        <label for="name" class="control-label">عنوان کانتر</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="عنوان کانتر  را وارد نمائید" value="{$objCounter->list['name']}"
                               disabled="disabled">
                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-xs-12  col-sm-12 ">
                        <label for="discount_hotel" class="control-label"> درصد هتل </label>
                        <input type="text" class="form-control" id="discount_hotel" name="discount_hotel"
                               placeholder="درصد هتل" value="{$objCounter->list['discount_hotel']}">
                    </div>

                    <div class="form-group col-md-4 col-lg-4 col-xs-12  col-sm-12">
                        <label for="discount_system_private" class="control-label"> درصد سیستمی اختصاصی</label>
                        <input type="text" class="form-control" id="discount_system_private"
                               name="discount_system_private"
                               placeholder="درصد سیستمی اختصاصی "
                               value="{$objCounter->list['discount_system_private']}">
                    </div>
                    <div class="form-group col-md-4 col-lg-4 col-xs-12  col-sm-12 ">
                        <label for="discount_system_public" class="control-label"> درصد سیستمی اشتراکی</label>
                        <input type="text" class="form-control" id="discount_system_public"
                               name="discount_system_public"
                               placeholder="درصد سیستمی اشتراکی " value="{$objCounter->list['discount_system_public']}">
                    </div>
                    <div class="form-group col-md-4 col-lg-4 col-xs-12  col-sm-12 ">
                        <label for="discount_charter" class="control-label"> درصد چارتری </label>
                        <input type="text" class="form-control" id="discount_charter" name="discount_charter"
                               placeholder="درصد چارتری" value="{$objCounter->list['discount_charter']}">
                    </div>


                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script src="assets/JsFiles/counterType.js" type="text/javascript"></script>



