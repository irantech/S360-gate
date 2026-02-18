{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_country_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="continent">قاره ها</a></li>
                <li class="active">ویرایش کشور</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات کشور را در سیستم ویرایش نمائید</p>

                <form id="EditCountry" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="flag" value="EditCountry">
                    <input type="hidden" name="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="id_continent" value="{$objResult->list['id_continent']}">


                    <div class="form-group col-sm-6">
                        <label for="country_name" class="control-label">نام کشور</label>
                        <input type="text" class="form-control" name="country_name" value="{$objResult->list['name']}"
                               id="country_name" placeholder=" نام کشور را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="country_name_en" class="control-label">نام انگلیسی کشور</label>
                        <input type="text" class="form-control" name="country_name_en" value="{$objResult->list['name_en']}"
                               id="country_name_en" placeholder=" نام انگلیسی کشور را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="country_name_ar" class="control-label">نام عربی کشور</label>
                        <input type="text" class="form-control" name="country_name_ar" value="{$objResult->list['name_ar']}"
                               id="country_name_ar" placeholder=" نام عربی کشور را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="country_abbreviation" class="control-label">نام اختصار</label>
                        <input type="text" class="form-control" name="country_abbreviation" value="{$objResult->list['abbreviation']}"
                               id="country_abbreviation" placeholder="نام اختصار را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="type_arz" class="control-label">قیمت برای ویزا، هر</label>
                        <select name="type_arz" id="type_arz" class="form-control ">
                            <option value="">انتخاب کنید</option>
                            <option value="1" {if $objResult->list['type_arz'] eq '1'}selected{/if}>دلار</option>
                            <option value="2" {if $objResult->list['type_arz'] eq '2'}selected{/if}>درهم</option>
                            <option value="3" {if $objResult->list['type_arz'] eq '3'}selected{/if}>یورو</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="cost_arz" class="control-label">مبلغ</label>
                        <input type="text" class="form-control" name="cost_arz" value="{$objResult->list['cost_arz']}"
                               id="cost_arz" placeholder="ریال می باشد">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="comments_visa" class="control-label">توضیحات برای ویزا</label>
                        <textarea type="text" class="form-control" name="comments_visa" id="comments_visa" value="{$objResult->list['comments_visa']}">
                            {$objResult->list['comments_visa']}
                        </textarea>
                    </div>

                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="pic" class="control-label">تصویر</label>
                            <input type="file" name="pic" id="pic" class="dropify" data-height="100" value='/gds/pic/country/{$smarty.const.CLIENT_ID}/{$objResult->list['pic']}'
                                   data-default-file="/gds/pic/country/{$smarty.const.CLIENT_ID}/{$objResult->list['pic']}"/>
                        </div>
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


<script>
   function uploadFile() {
      $(".show-pic-upload").hide();  // To hide
      $(".show-pic").show();  // To show
   }
</script>