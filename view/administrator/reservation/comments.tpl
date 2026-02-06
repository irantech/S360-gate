{load_presentation_object filename="reservationTour" assign="objResult"}
{load_presentation_object filename="comments" assign="objComments"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}

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
                            <th>تور</th>
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
                        {foreach key=key item=item from=$objComments->getComments('tour','',true)}
                            {$number=$number+1}

                            <tr id="del-{$item['id']}">

                                <td>
                                    <a href="detailTour&id={$item['item_id']}">
                                        {assign var="infoTourByIdSame" value=$objResult->infoTourByIdSame($item['item_id'])}
                                        {$infoTourByIdSame['tour_name']}
                                    </a>
                                </td>

                                <td>
                                    {$objDateTimeSetting->jdate("Y-m-d ( H:i )", $item['created_at'], '', '', 'en')}
                                </td>

                                <td>
                                    {$item['name']}
                                </td>

                                <td>
                                    {$item['email']}
                                </td>

                                <td>
                                    <a onclick="ModalShowInfoComment('{$item.id}');return false"
                                       data-toggle="modal"
                                       class="btn btn-primary"
                                       data-target="#ModalPublic">
                                        نمایش متن
                                    </a>
                                </td>

                                <td>
                                    {if $item['validate'] eq 0}
                                        <a class="btnCommentStatus_{$item.id} btn btn-warning cursor-default" onclick="return false;">ثبت جدید عدم نمایش در سایت</a>
                                    {elseif $item['validate'] eq 1}
                                        <a class="btnCommentStatus_{$item.id} btn btn-success cursor-default" onclick="return false;">نمایش در سایت</a>
                                    {elseif $item['validate'] eq 2}
                                        <a class="btnCommentStatus_{$item.id} btn btn-danger cursor-default" onclick="return false;">عدم نمایش در سایت</a>
                                    {/if}
                                </td>

                                <td>
                                    <a class="btn btn-success" onclick="showCommentsOnSite('{$item.id}','1')"><i class="fa fa-check"></i></a>

                                </td>

                                <td>

                                    <a class="btn btn-danger" onclick="showCommentsOnSite('{$item.id}','2')"><i class="fa fa-times"></i></a>

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

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>