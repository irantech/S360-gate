{load_presentation_object filename="vote" assign="objVote"}
{assign var="info_vote" value=$objVote->getVote($smarty.get.id)}
{assign var="itemVote" value=$objVote->getQuestionItem($info_vote['id'])}
{assign var="languages" value=['fa'=>'فارسی','en'=>'English','ar'=>'العربیه']}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-3 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/vote/list">
                        لیست سوالات نظرسنجی
                    </a>
                </li>
                <li class='active'>
                    ویرایش سوال
                </li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <form data-toggle="validator" id="edit_vote" method="post"  enctype="multipart/form-data">
            <input type='hidden' value='updateVote' id='method' name='method'>
            <input type='hidden' value='vote' id='className' name='className'>
            <input type='hidden' value='{$info_vote['id']}' id='id' name='id'>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">

                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>ویرایش سوال  {$info_vote['title']} </h4>
                        </div>
                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="title">عنوان</label>
                                <input type="text" class="form-control" name="title" id="title"  value='{$info_vote['title']}'
                                       placeholder="{$info_vote['title']}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="language" class="control-label">زبان</label>
                                <select name="language" class="form-control" id="language">
                                    {foreach $languages as $value=>$title}
                                        <option value="{$value}" {if $info_vote['language'] eq $value} selected {/if}>{$title}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="bg-white d-flex flex-wrap rounded w-100 ">
                            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                                <h6 class='d-flex flex-wrap font-bold m-0 py-3 px-4'> پاسخ ها</h6>
                            </div>
                            <hr class='m-0 mb-4 w-100'>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                <div class="row duplicate-item ">
                                    <div class="form-group col-sm-12 ">
                                        {foreach $itemVote as $key => $value}
                                        <div class="col-sm-12 p-0 form-group myform_{$value.id}">
                                            <div class="col-md-6 pr-0">

                                                {if $objVote->countAnswerList({$value.id}) neq 0}
                                                    <input name="vote_item[question][]" value="{$value.title}" placeholder="پاسخ"
                                                           class="form-control" id="vote_item_question" disabled
                                                           type="text">
                                                {else}
                                                    <input name="vote_item[question][]" value="{$value.title}" placeholder="پاسخ"
                                                           class="form-control" id="vote_item_question"
                                                           type="text">
                                                {/if}
                                            </div>

                                            <div class="col-md-2 d-flex gap-10 p-0">
                                                <div class="col-md-6 p-0">
                                                    {if $objVote->countAnswerList({$value.id}) neq 0}
                                                        <a
                                                                class="btn rounded form-control btn-warning " title="امکان حذف این آیتم وجود ندارد">
                                                            <span class="fa fa-remove"></span>
                                                        </a>
                                                    {else}
                                                        <button
                                                                class="btn rounded form-control btn-danger minss_{$value.id}" >
                                                            <span class="fa fa-remove"></span>
                                                        </button>
                                                    {/if}
                                                </div>
                                                <div class="col-md-6 p-0 "></div>
                                            </div>
                                        </div>
                                        {/foreach}

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 duplicate-form1">
                                <div class="row duplicate-item myform1">
                                    <div class="form-group col-sm-12 ">

                                        <div class="col-sm-12 p-0 form-group">
                                            <div class="col-md-6 pr-0">
                                                <input name="vote_item[question][]" placeholder="پاسخ"
                                                       class="form-control" id="vote_item_question"
                                                       type="text">
                                            </div>

                                            <div class="col-md-2 d-flex gap-10 p-0">
                                                <div class="col-md-6 p-0">
                                                    <button type="button"
                                                            class="btn rounded form-control btn-success plus1">
                                                        <span class="fa fa-plus"></span>
                                                    </button>
                                                </div>
                                                <div class="col-md-6 p-0 minus1"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block btn-fixed" type="submit" style='margin: 30px 0; float: left'>ذخیره</button>

                        </div>

                    </div>

                </div>

            </div>


        </form>
    </div>
    <div class="row">
        <div class="container">
            <h2>آمار </h2>
            <p>می توانید از لیست زیر آمار کلیه آیتم های این پرسش را مشاهده نمایید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان </th>
                    <th>تعداد </th>
                    <th>درصد </th>
                    <th>نظرات </th>
                </tr>
                </thead>
                <tbody>
                {assign var="number" value="0"}
                {foreach $itemVote as $key => $value}
                    {$number=$number+1}
                    <tr>
                        <td>{$number}</td>
                        <td>{$value.title}</td>

                        <td>{$objVote->countAnswerList({$value.id})} رای</td>
                        {if $objVote->countAnswerListAll({$info_vote['id']})}
                        <td>{$objVote->countAnswerList({$value.id})/$objVote->countAnswerListAll({$info_vote['id']})*100} %</td>
                        {else}
                            <td>---</td>
                        {/if}

                        <td class="align-middle">
                            <a href="listReason&answerId={$value.id}&questionId={$info_vote['id']} " class="" target="_blank">مشاهده دلایل</a>

                        </td>

                    </tr>
                {/foreach}
                {if $objVote->countAnswerListAll({$info_vote['id']})}
                <tr>
                    <td> کل پاسخ به این پرسش</td>
                    <td></td>
                    <td>{$objVote->countAnswerListAll({$info_vote['id']})}  تا</td>
                    <td></td>
                </tr>
                {/if}

                </tbody>
            </table>


        </div>
    </div>

    {if $objVote->countAnswerListAll({$info_vote['id']})}
    <div class="row">
        <div class="contentbox">
            <script type="text/javascript" src="assets/JsFiles/highcharts.js"></script>
            <script type="text/javascript">
              var chart;
              $(document).ready(function() {
                chart = new Highcharts.Chart({
                  chart: {
                    renderTo: 'container',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                  },
                  title: {
                    text: '{$info_vote['title']}'
                  },
                  tooltip: {
                    formatter: function() {
                      return '<b >'+ this.point.name +'</b> '+ this.percentage +' %';
                    }
                  },
                  plotOptions: {
                    pie: {
                      allowPointSelect: true,
                      cursor: 'pointer',
                      dataLabels: {
                        enabled: false
                      },
                      showInLegend: true
                    }
                  },
                  series: [{
                    type: 'pie',
                    name: 'Browser share',
                    data: [
                        {$pre=""}
                        {foreach $itemVote as $key => $value}
                            {$pre}['{$value.title} ',  {$objVote->countAnswerList({$value.id})/$objVote->countAnswerListAll({$info_vote['id']})*100} ]
                        {$pre=","}
                        {/foreach}

                    ]
                  }]
                });
              });

            </script>

            <div id="container" style="width: 90%; height: 400px; margin: 0 auto;direction:ltr;"></div>
            <br class="clear" />

            <div style="clear: both;"></div>
            تعداد شرکت کننده در نظر سنجی برای : <br style="clear: both;" /><br style="clear: both;" />
            {assign var="counter" value="0"}
            {foreach $itemVote as $key => $value}
                {$counter=$counter+1}
            {$counter}- {$value.title} : ({$objVote->countAnswerList({$value.id})} نفر رای داده اند )<br style="clear: both;" /><br style="clear: both;" />
            {/foreach}
        </div>
    </div>
    {/if}



</div>

<script type="text/javascript" src="assets/JsFiles/vote.js"></script>

  <script src="assets/js/mag-jquery-dropzone.js"></script>



<script>
  $(document).on('click','.plus1',function(){
    clone =$(this).closest('.duplicate-form1').find('.duplicate-item').clone();
    clone.find('input[type="text"]').val("");
    clone.removeClass('duplicate-item');
    $('.duplicate-form1').append(clone);
    clone.find(".minus1").last().append('<a type="button"\n' +
      'class="btn rounded form-control btn-danger min1">\n' +
      '<span class="fa fa-remove"></span>\n' +
      '</a>');
  });
  $(document).on('click','.min1',function(){
    $(this).closest(".myform1").remove();
  });
  {foreach $itemVote as $key => $value}
  $(document).on('click','.minss_{$value.id}',function(){
    $(this).closest(".myform_{$value.id}").remove();
  });
  {/foreach}

</script>


