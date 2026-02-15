{load_presentation_object filename="members" assign="objCounter"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">خریداران مهمان</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">خریداران مهمان</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست اطلاعات خریداران مهمان  را مشاهده
                    نمائید


                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام  /ایمیل کاربر</th>
                            <th>شماره همراه</th>
                            <th>شماره ثابت</th>
                            <th>تعداد خرید</th>
                            <th>افزودن به کاربران</th>
                            <!--<th>ویرایش</th>-->
                            <!--{*<th>حذف</th>*}-->
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {$objCounter->getCounters('5')}
                        {foreach key=key item=item from=$objCounter->getGuestUser()}  {*گرفتن لیست اسامی مسافران آنلاین*}
                        {$number=$number+1}
                        <tr>
                            <td>{$number}</td>
                            <td>{if $item.name == '' } {$item.email}{else}{$item.name} {$item.family}<br> {$item.email}{/if}</td>
                            <td>{$item.mobile}</td>
                            <td>{$item.telephone}</td>
                            <td>{$item.CountCustomer}</td>
                            <td>
                                <a onclick="GuestUserConvertModal('{$item.email}','{$item.mobile}')" data-toggle="modal" data-target="#ModalPublic"
                                   class="btn btn-primary btn-outline waves-effect waves-light btn-xs">
                                    <span class="btn-label ml-1 pl-2"><i class="fa fa-star"></i></span>
                                    افزودن
                                </a>
                            </td>


                            <!--<td><a href="administratoronlinePassengerInsert&import=admin&edit={$item.id}"><i class="btn btn-info fa fa-edit"></i></a></td>-->
                            <!--{*<td><a href="administratoronlinePassengerShow&import=admin&delete={$item.id}"><i class="btn btn-info fa fa-edit"></i></a></td>*}-->
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش خریداران مهمان</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/371/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/mainUser.js"></script>