{load_presentation_object filename="visa" assign="objVisaFaqs"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaList">ویزا</a></li>
                <li class='active'>سوالات متداول</li>

            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaFaqInsert&visaId={$smarty.get.visaId}"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    تعریف سوال متداول جدید
                </a>

                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان سوال</th>
{*                            <th>ویزا</th>*}
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_faqs" value=$objVisaFaqs->getFaqs($smarty.get.visaId)}
                        {foreach $main_faqs as $faq}
{*                            <pre>{$faq|json_encode}</pre>*}
                            {$rowNum=$rowNum+1}

                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$faq.question}</td>
{*                                <td>{$faq.title}</td>*}

                                <td>
                                    <a class="btn btn-sm btn-outline gap-4 btn-primary"
                                       href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaFaqEdit?visaFaqEditId={$smarty.get.visaId}&id={$faq.id}"><i
                                                class="fa fa-edit"></i>ویرایش </a>


                                    <button class="btn btn-sm btn-outline btn-danger"
                                            onclick='deleteVisaFaq("{$faq.id}")'
                                            data-id="{$faq.id}"><i class="fa fa-trash"></i> حذف
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

<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
<style>
    .shown-on-result {

    }
</style>