{load_presentation_object filename="recommendation" assign="objRecommendations"}

{*<code>{$getCategory|json_encode}</code>*}
{if isset($smarty.get.service) && in_array($smarty.get.service,array_keys($getServices))}

{/if}



<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class='active'>لیست سفرنامه ها</li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a class="btn btn-primary rounded"
                   href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/insert">
                    <i class="fa fa-plus"></i>
                        سفرنامه جدید
                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>نام و نام خانوادگی</th>
                            <th>زبان</th>
                            <th>نمایش در کشور</th>
                            <th>نوع ویزا</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="recommendation_list" value=$objRecommendations->getRecommendations(null , null, null  , false, [], 'all')}

                        {foreach $recommendation_list['data'] as $recommendation}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$recommendation['fullName']}</td>
                                <td>{$languages[$recommendation['language']]}</td>
                                <td>
                                   {$recommendation['country']['titleFa']}
                                </td>
                                <td>
                                    {$recommendation['visa_type']['title']}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/recommendation/edit?id={$recommendation['id']}"><i
                                                class="fa fa-edit"></i>ویرایش </a>
                                        <button class="btn btn-sm btn-outline btn-default"
                                                onclick='recommendationSelectedToggle($(this),"{$recommendation.id}")'>
                                        {if $recommendation['is_visible'] eq '1'}
                                            <i class="fa fa-times"></i>
                                            <span>
                                            عدم نمایش
                                            </span>
                                        {else}
                                            <i class="fa fa-check"></i>
                                            <span>
                                             نمایش
                                            </span>
                                        {/if}

                                    </button>
                                    </a>

                                    <button class="btn btn-sm btn-outline btn-danger deleteRecommendation"
                                            onclick='removeRecommendation("{$recommendation['id']}")'>
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
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

<script type="text/javascript" src="assets/JsFiles/recommendations.js"></script>
<style>
    .shown-on-result {

    }
</style>