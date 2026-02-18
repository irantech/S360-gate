{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="messageClientOnline" assign="objMessage"}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li class="active">ارسال پیام به کاربران</li>
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
                <h3 class="box-title m-b-0">ارسال پیام به کاربران</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانیدپیام های ارسال شده را مشاهده نمائید
                    <span class="pull-right">
                         <a href="messageClientOnlineAdd" class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-user-plus"></i></span>ارسال پیام جدید
                </a>

                </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>تاریخ ارسال</th>
                            <th>عملیات</th>


                        </tr>
                        </thead>
                        <tbody>
                            {foreach key=key item=item from=$objMessage->ListMessage()}
                                  <tr id="Del-{$item.id}">
                                      <td>{$key+1}</td>
                                        <td>{$item.title}</td>
                                        <td>{$objDate->jdate('Y-m-d H:i:s', $item.creationDateInt)}</td>
                                        <td>
                                                    <a class="" onclick="DeleteMessage('{$item.id}'); return false;"><i
                                                                class="fcbtn btn btn-outline btn-danger btn-1e fa fa-trash-o tooltip-danger"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="حذف پیام"></i></a>

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



<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش لیست پیام به کاربران   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/366/----.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/messageClientOnline.js"></script>
{/if}