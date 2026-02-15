{if $smarty.const.TYPE_ADMIN eq 1}
{load_presentation_object filename="apiClients" assign="objapiClients"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}




<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class='active'>لیست مشتریان api</li>

            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>

                <p class="text-muted m-b-30 textPriceChange">
                </p>

                <form id="FormAddApiClients" method="post" enctype='multipart/form-data' data-toggle="validator" >

                    <input type="hidden" name="className" value="apiClients">
                    <input type="hidden" name="method" value="storeApiClients">

                    <div class="form-group col-sm-6">
                        <label for="userName" class="control-label">نام کاربری</label>
                        <input type="text" class="form-control" name="userName" value=""
                               id="userName" placeholder="نام کاربری را وارد کنید">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="keyTabdol" class="control-label">پسورد</label>
                        <input type="text" class="form-control" name="keyTabdol" value="{$objapiClients->generateRandomString()}"
                               id="keyTabdol" placeholder="پسورد را وارد کنید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">



                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام کاربری</th>
                            <th>نوع</th>
                            <th>پسورد</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                            <th>فعال بودن</th>

                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="apiClients_list" value=$objapiClients->getApiClients()}

                        {foreach $apiClients_list as $apiClients}
                            {if $apiClients['creationDateInt']}
                                {assign var="correctDate" value=$objDateTimeSetting->jdate("Y-m-d", $apiClients['creationDateInt'] , '', '', 'en') }

                                {else}
                                {assign var="correctDate" value='--' }

                            {/if}

                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$apiClients['userName']}</td>
                                {if $apiClients['clientId'] eq 299}
                                    <td>تست</td>
                                    {else}
                                    <td> </td>
                                {/if}
                                <td>{$apiClients['keyTabdol']}</td>
                                <td>{$correctDate}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/apiClients/edit?id={$apiClients['id']}"><i
                                                class="fa fa-edit"></i>ویرایش </a>
                                    </a>
                                </td>
                                <td class="align-middle">
                                    <a href="#"
                                       onclick="updateApi('{$apiClients.id}');  return false">
                                         <input id='is_enable_{$apiClients.id}' type="checkbox" class="js-switch" data-color="#99d683" value='{$apiClients['is_enable']}'
                                                   data-secondary-color="#f96262" data-size="small" {if $apiClients['is_enable'] eq '1'}  checked {/if}/>
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

<script type="text/javascript" src="assets/JsFiles/apiClients.js"></script>
<style>
    .shown-on-result {

    }
</style>

{/if}