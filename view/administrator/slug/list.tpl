{load_presentation_object filename="slugController" assign="objSlugController"}
{assign var="service" value=$objSlugController->findAccessServiceClient($smarty.get.module)}
{assign var="items" value=$objSlugController->modelItems($service['MainService'])}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">

                        {$service.Title}
                    </a></li>
                <li class='active'>سرویس ها</li>
            </ol>
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
                            <th>نامک</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {foreach $items as $item}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>
                                    <span class='badge text-dark rounded'>
                                        {$item.slug_fa}
                                    </span>
                                    <br>
                                    <span class='badge text-dark rounded'>
                                        {$item.slug_en}
                                    </span>
                                    <br>
                                    <span class='badge text-dark rounded'>
                                        {$item.slug_ar}
                                    </span>
                                </td>
                                <td>
                                    <a data-toggle="modal"
                                       data-target="#ModalPublic"
                                       onclick='ModalShowSlugs("{$item.id}","{$item.self}")'
                                       class='btn btn-primary rounded'>
                                        ویرایش
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

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>
<style>
    .shown-on-result {

    }
</style>