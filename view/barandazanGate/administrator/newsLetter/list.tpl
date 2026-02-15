{load_presentation_object filename="newsLetter" assign="objNewsLetter"}
{assign var="list_news_letter" value=$objNewsLetter->listNewsLetter()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/newsLetter/list">لیست خبرنامه</a></li>
            </ol>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a onclick="ExecuteExcelNewsLetter($(this))" class='btn btn-primary' data-target="newsLetterExcel" data-target-file="user_ajax.php"  class="btn btn-primary waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل
                </a>
                <h3 class="box-title m-b-0">لیست خبرنامه</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست درخواست های خبرنامه را مشاهده نمائید</p>

                <div class="table-responsive">
                  <form id='FormExecuteNewsLetter'  method="post">
                      <input type="hidden" name="RowCounter" id="RowCounter">

                      <div class="d-none" data-info="filter-div" data-target="newsLetterExcel">
                          <input type="hidden" name="flag" id="flag" value="newsLetterExcelForm">
                      </div>
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>زبان</th>
                            <th>شماره همراه</th>
                            <th>ایمیل</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_news_letter != ''}
                        {foreach key=key item=item from=$list_news_letter}
                        {$number=$number+1}
{*                        <input type='hidden' name='name' value='{$item.name}'>*}
{*                        <input type='hidden' name='mobile' value='{$item.mobile}'>*}
{*                        <input type='hidden' name='email' value='{$item.email}'>*}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>

                            <td class="align-middle">{$item.name}</td>

                            <td class="align-middle">{$languages[$item.language]}</td>
                            <td class="align-middle">{if $item.mobile}{$item.mobile}{else}---{/if}</td>
                            <td class="align-middle">{if $item.email}{$item.email}{else}---{/if}</td>
                            <td class="align-middle">{$item.created_at}</td>

                            <td class="align-middle">
                                <button class="btn btn-sm btn-outline btn-danger deleteNewsLetter"
                                        data-id="{$item.id}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>

                </div>

                </tr>
                {/foreach}
                {/if}
                </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>

</div>
</div>


<script type="text/javascript" src="assets/JsFiles/newsLetter.js"></script>

