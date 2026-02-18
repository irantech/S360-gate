{load_presentation_object filename="faqs" assign="objFaqs"}




<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'>سوالات متداول</li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/faqs/insert"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    تعریف سوال متداول جدید
                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>زبان</th>
                            <th>ترتیب</th>
                            <th>مکان نمایش</th>

                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_faqs" value=$objFaqs->getFaqs()}
                        {foreach $main_faqs as $faq}
                            {*<pre>{$faq|json_encode}</pre>*}
                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$faq.title}</td>
                                <td>{$languages[$faq.language]}</td>

                                <td class="align-middle"  ><input type="number"  size="10" name="order[{$faq.id}]" id="order" value="{$faq.order_number}" class="list-order"></td>

                                <td>
                                    {foreach $faq['positions'] as $service_key=>$positions}
                                        <div class='badge badge-inverse d-flex flex-wrap gap-5'>
                                            {$objFunctions->Xmlinformation($service_key)} :
                                            {foreach $positions as $position_key=>$selected_position}
                                                <div class="badge badge-purple">

                                            {foreach $selected_position as $type_name=>$item}

                                                    {$item['title']}
                                                {if $selected_position['destination'] && $type_name eq 'origin' }
                                                    به
                                                {/if}
                                            {/foreach}
                                                </div>
                                            {/foreach}
                                        </div>
                                    {/foreach}
                                </td>


 

                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/faqs/edit?id={$faq.id}"><i
                                                class="fa fa-edit"></i>ویرایش </a>


                                    <button class="btn btn-sm btn-outline btn-danger deleteArticle"
                                            onclick='deleteFaq("{$faq.id}")'
                                            data-id="{$faq.id}"><i class="fa fa-trash"></i> حذف
                                    </button>
                                </td>


                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                    <input   class="btn btn-info" type="button" onclick='change_order_faqs()' value="تغییر ترتیب سوالات"  title="تغییر ترتیب سوالات" style='margin: 20px 0 0 0;' />

                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/faqs.js"></script>
<style>
    .shown-on-result {

    }
</style>