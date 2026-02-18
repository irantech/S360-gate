{load_presentation_object filename="visa" assign="objVisaFaq"}

{assign var="visaFaq" value=$objVisaFaq->getFaq($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaList">ویزا</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaFaqList&visaId={$visaFaq.visa_id}">سوالات متداول</a></li>

                <li class='active'>
                    ویرایش
                    <span class='font-bold underdash'>{$visaFaq.answer}</span>
                </li>
            </ol>
        </div>
    </div>
    <div class="row">
        <form data-toggle="validator" method="post" id="editVisaFaq" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="visa">
            <input type="hidden" name="method" value="editVisaFaq">
            <input type="hidden" name="faq_id" value="{$visaFaq.id}">
            <input type="hidden" name="visa_id" value="{$visaFaq.visa_id}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>اطلاعات پایه</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="question">عنوان سوال متداول</label>
                                <input type="text" class="form-control" name="question" id="question"
                                       placeholder="عنوان ؟"
                                       value="{$visaFaq.question}">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="answer">پاسخ به پرسش</label>
                                <textarea name="answer" id="answer" class="form-control"
                                          placeholder="محتوای مطلب">{$visaFaq.answer}</textarea>
                            </div>
                        </div>


                    </div>



                </div>
            </div>

            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit">ذخیره</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
{literal}
    <script type="text/javascript">
      $(document).ready(async function() {
        console.log('awdawdawd')
      })
    </script>
{/literal}