{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="message" assign="objMessage"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">پیام های ارسال  شده</li>
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
                <h3 class="box-title m-b-0">لیست پیام های ارسال شده</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست پیام هایی که برای مشتریان خود  ارسال نموده اید را  مشاهده
                    نمائید
                    <span class="pull-right">
                         <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/messageBoxSendToUsers" class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="mdi mdi-message-plus"></i></span>ارسال پیام جدید
                </a>
                </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>موضوع</th>
                            <th>تاریخ ارسال</th>
                            <th>تعداد ارسال</th>
                            <th> کاربران ارسال شده</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objMessage->messageListAllUser()}
                        {$number=$number+1}
                        <tr>
                            <td>{$number}</td>
                            <td>{$item.title} </td>
                            <td dir="ltr" class="text-left">{$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}</td>
                            <td>{$item.count} </td>
                            <td>
                                <a href="#" onclick="ModalShowUsersForMessage('{$item.id}'); return false"
                                   data-toggle="modal" data-target="#ModalPublic"
                                   style="margin: 5px 0;">

                                    <i class=" fcbtn btn btn-outline btn-success btn-1f  tooltip-success mdi mdi-account-multiple" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title=" لیست کاربران که پیام برای آنها ارسال شده است "></i>


                                </a>
                            </td>

                            <td>
                                <a onclick="ModalShowMessageAdmin('{$item.id}');return false"
                                   data-toggle="modal" data-target="#ModalPublic"
                                   style="margin: 5px 0;"  >
                                    <i class="fcbtn btn btn-outline btn-info btn-1f tooltip-info mdi mdi-eye"
                                       data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title="مشاهده پیام" ></i>
                                </a>


                            </td>

                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/messageAdmin.js"></script>
{/if}