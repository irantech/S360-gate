{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_region_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">ویرایش منطقه</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات منطقه را در سیستم ویرایش نمائید</p>

                <form id="EditRegion" method="post">
                    <input type="hidden" name="flag" value="EditRegion">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="id_city" value="{$objResult->list['id_city']}">


                    <div class="form-group col-sm-6">
                        <label for="region_name" class="control-label">نام شهر</label>
                        <input type="text" class="form-control" name="region_name" value="{$objResult->list['name']}"
                               id="region_name" placeholder=" نام شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="region_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="region_abbreviation" value="{$objResult->list['abbreviation']}"
                               id="region_abbreviation" placeholder="نام اختصار را وارد نمائید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
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

<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>