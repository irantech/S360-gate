{load_presentation_object filename="manageMenuAdmin" assign="obj_manage_menu_admin"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li ><a href="accessToMenu">تعیین دسترسی سوابق خرید کانتر</a></li>
                <li class="active">تغییر دسترسی به سوابق خرید خدمات</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box row">
                <h3 class="box-title m-b-0"> تغییر دسترسی به سوابق خرید خدمات</h3>

                <p class="text-muted m-b-30">
                    در فرم زیر میتوانید  تغییرات مد نظر را اعمال کنید
                </p>

                <div class="form-group col-md-5 ">
                    <label for="service" class="control-label">نام خدمات</label>
                    <select name='service' id='service' class='select2 form-control'>
                        <option value=''>انتخاب کنید</option>
                        {foreach $obj_manage_menu_admin->servicesAccessClient() as $service}
                            <option value='{$service['id']}'>{$service['Title']}</option>
                        {/foreach}
                    </select>
                </div>

              <div class="form-group col-md-5 ">
                    <label for="relevant_service" class="control-label">نوع خدمات</label>
                    <select name='relevant_service' id='relevant_service' class='select2 form-control' disabled='disabled'>
                        <option value=''>انتخاب کنید</option>
                    </select>
                </div>
                {*   <div class="form-group col-md-2 ">
                      <label for="locality" class="control-label">نوع جستجو</label>
                      <select name='locality'  id="locality" class='select2 form-control'>
                          <option value=''>انتخاب کنید</option>
                          <option value='local'>داخلی</option>
                          <option value='international'>خارجی</option>
                      </select>
                  </div>*}
                <div class="form-group col-md-2 float-left ">
                    <input type="hidden" name="member_id" id="member_id" value="{$smarty.get.id}">
                    <label for="relevant_service" class="control-label"> </label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info form-control ColorAndSizeMenu active" onclick='setAccessCounterAdmin()'>ارسال اطلاعات</button>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست تغییرات قیمت پرواز</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}

                        {assign var="list_access" value=$obj_manage_menu_admin->listAccessHistoryCounter($smarty.get.id)}
                        {if $list_access != ''}
                        {foreach key=key item=item from=$list_access}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.title_fa}</td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-outline btn-danger deleteSlider" onclick="deleteAccessHistoryCounter('{$item.id}')"
                                        data-id="{$item.id}"><i class="fa fa-trash"></i> حذف
                                </button>

                </div>
                </td>
                </tr>
                {/foreach}
                {/if}
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" src="assets/JsFiles/accessHistory.js"></script>