{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{$objResult->SelectAllWithCondition('reservation_tour_type_tb', 'id', $smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="tourType">نوع تور</a></li>
                <li class="active">ویرایش نوع تور</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30">شما با استفاده از فرم زیر میتوانید نوع تور را در سیستم ویرایش نمائید</p>

                <form id="FormTouTypeEdit" method="post">
                    <input type="hidden" name="flag" value="editTourType">
                    <input type="hidden" name="id" value="{$smarty.get.id}">


                    <div class="form-group col-sm-6">
                        <label for="tour_type" class="control-label">نام</label>

                        <input type="text" class="form-control" name="tour_type" value="{$objResult->list['tour_type']}" id="tour_type">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="tour_type" class="control-label">نام انگلیسی</label>

                        <input type="text" class="form-control" name="tour_type_en" value="{$objResult->list['tour_type_en']}" id="tour_type_en">
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