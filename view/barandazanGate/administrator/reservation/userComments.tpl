{load_presentation_object filename="reservationTour" assign="objResult"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت تور رزرواسیون</li>
                <li><a href="reportTour">گزارش تور</a></li>
                <li class="active">نظر کاربران</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش تور</h3>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>نام تور</th>
                            <th>تاریخ و ساعت ثبت نظر</th>
                            <th>نام</th>
                            <th>ایمیل</th>
                            <th>متن نظر</th>
                            <th>وضعیت</th>
                            <th>تائید نمایش در سایت</th>
                            <th>عدم نمایش در سایت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objResult->getAllUserComments()}
                            {$number=$number+1}

                            <tr id="del-{$item['id']}">

                                <td>
                                    <a href="detailTour&id={$item['tourIdSame']}">
                                        {$item['tourName']} ({$item['tourCode']})
                                    </a>
                                </td>

                                <td>
                                    {$item['create_date_in']} - {$item['create_time_in']}
                                </td>

                                <td>
                                    {$item['full_name']}
                                </td>

                                <td>
                                    {$item['email']}
                                </td>

                                <td>
                                    {$item['comments']}
                                </td>

                                <td>
                                    {if $item['is_show'] eq ''}
                                        <a class="btn btn-warning cursor-default" onclick="return false;">ثبت جدید عدم نمایش در سایت</a>
                                    {elseif $item['is_show'] eq 'yes'}
                                        <a class="btn btn-success cursor-default" onclick="return false;">نمایش در سایت</a>
                                    {elseif $item['is_show'] eq 'no'}
                                        <a class="btn btn-danger cursor-default" onclick="return false;">عدم نمایش در سایت</a>
                                    {/if}
                                </td>

                                <td>
                                    {if $infoTour['is_show'] eq ''}
                                        <a class="btn btn-success" onclick="showUserCommentsOnSite('{$item.id}', 'yes')"><i class="fa fa-check"></i></a>
                                    {/if}
                                </td>

                                <td>
                                    {if $infoTour['is_show'] eq ''}
                                        <a class="btn btn-danger" onclick="showUserCommentsOnSite('{$item.id}', 'no')"><i class="fa fa-times"></i></a>
                                    {/if}
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
        <span> ویدیو آموزشی بخش گزارش نظرات کاربران   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/390/--.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>