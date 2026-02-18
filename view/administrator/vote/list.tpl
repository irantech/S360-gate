{load_presentation_object filename="vote" assign="objVote"}

{assign var="list_vote" value=$objVote->listVote()}
{assign var="languages" value=['fa'=>'فارسی','en'=>'English','ar'=>'العربیه']}


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

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/vote/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    پرسش جدید
                </a>


                <h3 class="box-title m-b-0">لیست سوالات نظرسنجی</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست همه سوالات نظرسنجی وب سایت خود را مشاهده نمائید</p>
                <div class="table-responsive">

                        <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>سوال</th>
                            <th>زبان</th>
                            <th>ترتیب</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_vote != ''}
                        {foreach key=key item=item from=$list_vote}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.tiny_title}</td>
                            <td class="align-middle">{$languages[$item.language]}</td>
                                <td class="align-middle"  style="text-align:center;"><input type="number"  size="10" name="order[{$item.id}]" id="order" value="{$item.orders}" class="list-order"></td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateVote('{$item.id}'); return false">
                                    {if $item.is_active}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.id} " class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش سوال"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deleteVote"
                                        data-id="{$item.id}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>

                        </td>
                        </tr>

                            {/foreach}
                            {/if}

                            </tbody>

                            </table>
                        <input   class="btn btn-info" type="button" onclick='change_order()' value="تغییر ترتیب"  title="حذف همه" style='margin: 20px 0 0 0;' />

                </div>

            </div>
    </div>

</div>
</div>

<script type="text/javascript" src="assets/JsFiles/vote.js"></script>

