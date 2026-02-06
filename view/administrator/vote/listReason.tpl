{load_presentation_object filename="vote" assign="objVote"}
{assign var="info_question" value=$objVote->getQuestion($smarty.get.answerId)}
{assign var="list_reason" value=$objVote->listReasonItem($smarty.get.answerId)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/vote/list">لیست سوالات نظرسنجی</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست دلایل انتخاب {$info_question['title']} </h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه دلایل انتخای این آیتم وب سایت خود را مشاهده نمائید</p>
                <div class="table-responsive">
                        <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th style='text-align: center'>دلیل</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_reason != ''}
                        {foreach key=key item=item from=$list_reason}
                            {if $item.reason}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle" style='text-align: center'>{$item.reason}</td>
                        </tr>
                            {/if}

                {/foreach}
                {/if}

                </tbody>

                </table>
                </div>

            </div>
    </div>

</div>
</div>



