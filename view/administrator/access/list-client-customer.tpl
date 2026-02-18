{load_presentation_object filename="clients" assign="objClient"}

{assign var="list_clients" value=$objClient->listClients()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userPassCustomers/list">لیست مشتری ها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <h3 class="box-title m-b-0">لیست مشتری ها</h3>
                <div class="table-responsive table-bordered">

                    <table id="myTable" class="table table-striped table-hover">

                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام مشتری</th>
                            <th>نام دامنه</th>
                            <th>نام دیتابیس</th>
                            <th>viewGds</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_clients != ''}
                        {foreach key=key item=item from=$list_clients}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.AgencyName}</td>
                            <td class="align-middle">{$item.Domain}</td>
                            <td class="align-middle">{$item.DbName}</td>
                            <td class="align-middle">{$item.ThemeDir}</td>



                </tr>
                {/foreach}
                {/if}
                </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
</div>


