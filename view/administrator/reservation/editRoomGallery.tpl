{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_room_gallery_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">ویرایش عکس</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید اطلاعات عکس را در سیستم ویرایش نمائید</p>

                <form id="EditGallery" method="post">
                    <input type="hidden" name="flag" id="flag" value="EditGallery">
                    <input type="hidden" name="type_id" id="type_id" value="{$smarty.get.id}">
                    <input type="hidden" name="table_name" id="table_name" value="reservation_room_gallery_tb">

                    <div class="form-group col-sm-12">
                        <img src="..\..\pic\{$objResult->list['pic']}" class="all landscape" alt="gallery"/>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="name" class="control-label">نام عکس</label>
                        <input type="text" class="form-control" name="name" value="{$objResult->list['name']}"
                               id="name" placeholder=" نام شهر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="comment" class="control-label">توضیحات</label>
                        <textarea type="text" class="form-control" name="comment" value=""
                                  id="comment" placeholder=" توضیحات عکس را وارد نمائید">{$objResult->list['comment']}</textarea>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="pic" class="control-label">عکس اتاق</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$objResult->list['pic']}" />
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