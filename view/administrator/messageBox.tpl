{load_presentation_object filename="message" assign="objMessage"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">پیام های دریافت شده</li>
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
                <h3 class="box-title m-b-0">لیست پیام های دریافت شده</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست پیام هایی که برای شما ارسال شده را  مشاهده
                    نمائید
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>موضوع</th>
                            <th>تاریخ ارسال</th>
                            <th>تاریخ آخرین مشاهده</th>
                            <th>وضعیت مشاهده</th>
                            <th>مشاهده</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objMessage->MessageUserList()}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$item.title} </td>
                            <td>{$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)}</td>
                            <td dir="ltr" class="text-left">{if $item.seen_date_int gt 0}{$objDate->jdate('Y-m-d (H:i:s)', $item.seen_date_int)} {else} ---- {/if}</td>
                            <td>
                                <a href="#" onclick=" return false;">
                                    {if $item.is_seen eq '1'}
                                   <i class=" fcbtn btn btn-outline btn-success btn-1f  tooltip-success mdi mdi-bell-ring" data-toggle="tooltip" data-placement="top" title=""
                                      data-original-title=" پیام قبلا مشاهده شده است "></i>

                                    {else}
                                    <i class=" fcbtn btn btn-outline btn-danger btn-1f  tooltip-danger mdi mdi-bell-off" data-toggle="tooltip" data-placement="top" title=""
                                       data-original-title=" پیام مشاهده نشده است " id="noView-{$item.id}"></i>
                                    {/if}
                                </a>
                            </td>
                            <td>
                                <a onclick="ModalShowMessage('{$item.id}');return false"
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

<script type="text/javascript" src="assets/JsFiles/message.js"></script>