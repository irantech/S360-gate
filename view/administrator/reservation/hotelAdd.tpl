{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{load_presentation_object filename="reservationPublicFunctions" assign="objFunction"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li><a href="hotel">هتل ها</a></li>
                <li class="active">افزودن هتل جدید</li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <form id="FormHotelAdd" method="post" action="{$smarty.const.rootAddress}hotel_ajax">
                    <input type="hidden" name="flag" value="insert_hotel">

                    {assign var="check_offline" value=$objFunctions->checkClientConfigurationAccess('offline_hotel')}

                    {if  $check_offline eq true}
                        <input type="hidden"  id="is_request" name="is_request" value="true">
                    {else}
                        <input type="hidden"  id="is_request" name="is_request" value="false">

                    {/if}


                    <div class="form-group col-sm-6">
                        <label for="name" class="control-label">نام هتل</label>
                        <input type="text" class="form-control" name="name" value="{$smarty.post.hotel_name}"
                               id="name" placeholder=" نام هتل را وارد نمائید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="name_en" class="control-label">نام انگلیسی هتل</label>
                        <input type="text" class="form-control" name="name_en" value="{$smarty.post.hotel_name_en}"
                               id="name_en" placeholder=" نام انگلیسی هتل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label class="control-label" for="title">عنوان هتل</label>
                        <input type="text" class="form-control" name="title" id="title"
                               placeholder="عنوان هتل">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="control-label" for="heading">عنوان H1</label>
                        <input type="text" class="form-control" name="heading" id="heading"
                               placeholder="عنوان h1">
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="control-label" for="sepehr_hotel_code">کد هتل سپهر</label>
                        <input type="number" class="form-control" name="sepehr_hotel_code" id="sepehr_hotel_code"
                               placeholder="کد هتل سپهر">
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="control-label" for="description">متن کوتاه</label>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="متن سئو، حداکثر ( 160 ) حرف"></span>
                            <textarea id='description' maxlength='160' name="description" class="form-control"
                                      placeholder="متن مربوطه">{$article.description}</textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="discount" class="control-label">تخفیف تا سقف</label>
                        <input type="text" class="form-control" name="discount" value="{$smarty.post.discount}"
                               id="discount" placeholder="تخفیف تا سقف">
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="star_code" class="control-label">ستاره هتل</label>
                        <select name="star_code" id="star_code" class="form-control ">
                            <option value="">ندارد</option>
                            <option value="1">1*</option>
                            <option value="2">2*</option>
                            <option value="3">3*</option>
                            <option value="4">4*</option>
                            <option value="5">5*</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="prepaymentPercentage" class="control-label">درصد پیش پرداخت</label>
                        <select name="prepaymentPercentage" id="prepaymentPercentage" class="form-control ">
                            <option value="" disabled='disabled'>انتخاب کنید</option>
                            {section name=foo start=0 loop=100 step=10}
                                <option value="{$smarty.section.foo.index}" >{$smarty.section.foo.index}</option>
                            {/section}

                        </select>
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="type_code" class="control-label">نوع هتل</label>
                        <select name="type_code" id="type_code" class="form-control">
                            <option value="ندارد">ندارد</option>
                            <option value="1">هتل</option>
                            <option value="2">هتل آپارتمان</option>
                            <option value="3">مهمانسرا</option>
                            <option value="4">خانه سنتی</option>
                            <option value="5">هتل سنتی</option>
                            <option value="6">اقامتگاه بوم گردی</option>
                            <option value="7">هتل جنگلی</option>
                            <option value="8">مجموعه فرهنگی تفریحی</option>
                            <option value="9">پانسیون</option>
                            <option value="10">متل</option>
                            <option value="12">ویلا</option>
                            <option value="13">کاروانسرا</option>
                            <option value="14">مجتمع اقامتی</option>
                            <option value="15">خانه محلی</option>
                            <option value="16">ویلا هتل</option>
                            <option value="17">خوابگاه</option>
                            <option value="18">سوئیت</option>
                            <option value="100">هاستل</option>
                            <option value="101">بوتیک</option>
                            <option value="110">سوییت های سنتی بام خلخال</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="number_of_rooms" class="control-label">تعداد اتاق</label>
                        <input type="text" class="form-control" name="number_of_rooms" value="{$smarty.post.number_of_rooms}"
                               id="number_of_rooms" placeholder=" تعداد اتاق را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="site" class="control-label">سایت</label>
                        <input type="text" class="form-control" name="site" value="{$smarty.post.site}"
                               id="site" placeholder=" سایت را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="origin_country" class="control-label">کشور</label>
                        <select name="origin_country" id="origin_country" class="form-control select2 select2-hidden-accessible">
                            <option value="">انتخاب کنید....</option>
                            {foreach $objFunction->ListCountry() as $country}
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                            <option value="{$country['id']}">{$country['name']}</option>
                                {else}
                            <option value="{$country['id']}">{$country['name_en']}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="origin_city" class="control-label">شهر</label>
                        <select name="origin_city" id="origin_city" class="form-control select2 select2-hidden-accessible">

                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="origin_region" class="control-label">منطقه</label>
                        <select name="origin_region" id="origin_region" class="form-control ">
                        </select>
                    </div>

                    <div class="form-group col-sm-9">
                        <label for="address" class="control-label">آدرس</label>
                        <input type="text" class="form-control" name="address" value="{$smarty.post.address}"
                               id="address" placeholder=" آدرس هتل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="address_en" class="control-label">آدرس انگلیسی</label>
                        <input type="text" class="form-control" name="address_en" value="{$smarty.post.address_en}"
                               id="address_en" placeholder=" آدرس انگلیسی هتل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="tel_number" class="control-label">تلفن</label>
                        <input type="text" class="form-control" name="tel_number" value="{$smarty.post.tel_number}"
                               id="tel_number" placeholder=" تلفن هتل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-4">
                        <label for="trip_advisor" class="control-label">trip advisor</label>
                        <input type="text" class="form-control" name="trip_advisor" value="{$smarty.post.trip_advisor}"
                               id="trip_advisor" placeholder="trip ladvisor">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="email_manager" class="control-label">ایمیل مدیر</label>
                        <input type="text" class="form-control" name="email_manager" value="{$smarty.post.email_manager}"
                               id="email_manager" placeholder=" ایمیل مدیر را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-3">
                        <label for="entry_hour" class="control-label">ساعت تحویل</label>
                        <input type="text" class="form-control" name="entry_hour" value="{$smarty.post.entry_hour}"
                               id="entry_hour" placeholder=" ساعت تحویل را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="leave_hour" class="control-label">ساعت تخلیه</label>
                        <input type="text" class="form-control" name="leave_hour" value="{$smarty.post.leave_hour}"
                               id="leave_hour" placeholder=" ساعت تخلیه را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="latitude" class="control-label">عرض جغرافیایی</label>
                        <input type="text" class="form-control" name="latitude" value="{$smarty.post.latitude}"
                               id="latitude" placeholder=" عرض جغرافیایی را وارد نمائید">
                    </div>

                    <div class="form-group col-sm-2">
                        <label for="longitude" class="control-label">طول جغرافیایی</label>
                        <input type="text" class="form-control" name="longitude" value="{$smarty.post.longitude}"
                               id="longitude" placeholder=" طول جغرافیایی را وارد نمائید">
                    </div>

                        <div class="form-group col-sm-6">
                            <label for="comment" class="control-label">توضیحات</label>
                            <textarea type="text" class="form-control ckeditor" name="comment" value="{$smarty.post.comment}"
                                      id="comment" placeholder=" توضیحات را وارد نمائید" ></textarea>
                        </div>

                    <div class="form-group col-sm-6">
                        <label for="comment_en" class="control-label">توضیحات انگلیسی</label>
                        <textarea type="text" class="form-control ckeditor" name="comment_en" value="{$smarty.post.comment_en}"
                                  id="comment_en" placeholder=" توضیحات انگلیسی را وارد نمائید" ></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="distance_to_important_places" class="control-label">فاصله تا اماکن مهم</label>
                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places" value=""
                                  id="distance_to_important_places" placeholder=" فاصله تا اماکن مهم را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="distance_to_important_places_en" class="control-label">فاصله تا اماکن مهم در انگلیسی</label>
                        <textarea type="text" class="form-control ckeditor" name="distance_to_important_places_en" value=""
                                  id="distance_to_important_places_en" placeholder=" فاصله تا اماکن مهم را در انگلیسی وارد نمائید"></textarea>
                    </div>


                    <div class="form-group col-sm-6">
                        <label for="rules" class="control-label">قوانین</label>
                        <textarea type="text" class="form-control" name="rules" value="{$smarty.post.rules}"
                                  id="rules" placeholder=" قوانین را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="rules_en" class="control-label">قوانین انگلیسی</label>
                        <textarea type="text" class="form-control" name="rules_en" value="{$smarty.post.rules_en}"
                                  id="rules_en" placeholder=" قوانین انگلیسی را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="cancellation_conditions" class="control-label">قوانین کنسلی</label>
                        <textarea type="text" class="form-control" name="cancellation_conditions" value="{$smarty.post.cancellation_conditions}"
                                  id="cancellation_conditions" placeholder=" قوانین کنسلی را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="cancellation_conditions_en" class="control-label">قوانین کنسلی انگلیسی</label>
                        <textarea type="text" class="form-control" name="cancellation_conditions_en" value="{$smarty.post.cancellation_conditions_en}"
                                  id="cancellation_conditions_en" placeholder=" قوانین کنسلی انگلیسی را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="child_conditions" class="control-label">قوانین خردسال</label>
                        <textarea type="text" class="form-control" name="child_conditions" value="{$smarty.post.child_conditions}"
                                  id="child_conditions" placeholder=" قوانین خردسال را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="child_conditions_en" class="control-label">قوانین خردسال انگلیسی</label>
                        <textarea type="text" class="form-control" name="child_conditions_en" value="{$smarty.post.child_conditions_en}"
                                  id="child_conditions_en" placeholder=" قوانین خردسال انگلیسی را وارد نمائید"></textarea>
                    </div>
                    <div class="form-group col-sm-6">
                            <label for="iframe_code" class="control-label">کد آی فریم</label>
                            <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                                  data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title=" کد آی فریم کپی شده را در این قسمت وارد نمائید"></span>
                            {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/iframeLink.tpl"}
                            <textarea id="iframe_code" name="iframe_code" class="form-control" rows='4'
                                      placeholder="کد آی فریم را وارد نمائید"></textarea>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="pic" class="control-label">لوگو</label>
                        <input type="file" name="pic" id="pic" class="dropify" data-height="100"
                               data-default-file="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/no-image.png"/>
                    </div>

                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="chk_flag_special" name="chk_flag_special" type="checkbox" value="1">
                            <label for="chk_flag_special"> هتل ویژه </label>
                        </div>
                    </div>
{*                    <div class="form-group col-sm-2">*}
{*                        <div class="checkbox checkbox-success">*}
{*                            <input id="chk_flag_discount" name="chk_flag_discount" type="checkbox" value="1">*}
{*                            <label for="chk_flag_discount"> هتل تخفیف دار </label>*}
{*                        </div>*}
{*                    </div>*}
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_went" name="transfer_went" type="checkbox" value="1">
                            <label for="transfer_went"> ترانسفر رفت </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <div class="checkbox checkbox-success">
                            <input id="transfer_back" name="transfer_back" type="checkbox" value="1">
                            <label for="transfer_back"> ترانسفر برگشت </label>
                        </div>
                    </div>



                    <div class="form-group col-sm-12">
                        <h3 class="box-title m-t-40">کارگزار هتل</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table color-table purple-table" id="TableHotelBroker">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>کارگزارهتل</th>
                                    <th>ایمیل</th>
                                    <th>حذف</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><div class="checkbox checkbox-success"></div></td>
                                    <td><div class="input-text"></div></td>
                                    <td><div class="input-text"></div></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <img src="assets/css/images/add.png" border="0" onClick="appendRow(this.form)">
                            <input name="count_package" id="count_package" value="0" type="hidden">
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
<script type="text/javascript" src="assets/JsFiles/reservationPublicFunctions.js"></script>


<SCRIPT LANGUAGE="JavaScript">

    var theTable, theTableBody;
    var aa=[];
    var row=1;

    $(document).ready(function () {
        theTable = (document.all) ? document.all.TableHotelBroker : document.getElementById("TableHotelBroker");
        theTableBody = theTable.tBodies[0];
    });


    function appendRow(form) {

        $('#count_package').val(parseInt(row));
        aa[row]=row;
        insertTableRow(form, -1)
    }

    function insertTableRow(form, where) {


        var nowData = [
            '<div align="center"><input id="chk_broker' + row + '" name="chk_broker' + row + '" class="form-control" type="checkbox" value="1">\n' +
            '<label for="chk_broker1">انتخاب کارگزار</label></div>' ,
            '<div align="center"><input type="text" class="form-control textPrice" name="broker' + row + '" value="" id="broker' + row + '" placeholder="کارگزار هتل را وارد کنید." aria-invalid="false"</div>' ,
            '<div align="center"><input type="text" class="form-control textPrice" name="email' + row + '" value="" id="email' + row + '" placeholder="ایمیل را وارد کنید" aria-invalid="false"></div>' ,
            '<div align="right" dir="rtl"><img src="assets/css/images/delete.png" border="0" onClick="deleteRow(' + row + ')"></div>'
        ];

        var newCell;
        var newRow = theTableBody.insertRow(where);
        for (var i = 0; i < nowData.length; i++) {
            newCell = newRow.insertCell(i);
            newCell.innerHTML = nowData[i];
            newCell.style.backgroundColor = "#A0B7E0"
        }

        row = row+1;
    }


    /////////////////////////////////////////////////////////
    function deleteRow(index) {

        var countzero=0;
        var i;
        for(i=0; i<=aa.length; i++){
            if(aa[i]=="n"){
                countzero++;
            }
        }//tedade khali bodane khaneha

        //if khali nabodane khane ha
        if(countzero==0){
            theTableBody.deleteRow(index);
            aa[index]="n";
            return;
        }//end if


        // if khli bodane khane ha
        if(countzero!=0){
            var countkhaneha=0;
            for(var i=0;i<index;i++){
                if(aa[i]=="n"){
                    countkhaneha++;
                }
            }//end for

            //age khali gablesh nabod
            if(countkhaneha==0){
                theTableBody.deleteRow(index);
                aa[index]="n";
            }//end if


            //age khali gablesh nabod
            if(countkhaneha!=0){
                var harekat=0;
                for(var i=0;i<index;i++){
                    if(aa[i]=="n"){
                        harekat++;
                    }

                }//end for
                var kam=index-harekat;
                theTableBody.deleteRow(kam);
                aa[index]="n";
            }
            //end if

        }//end if


    }


</script>