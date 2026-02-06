{load_presentation_object filename="vote" assign="objVote"}
{assign var="send_data" value=['is_active'=>1, 'order' =>DESC]}
{assign var='list_vote' value=$objVote->listVote($send_data)}


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
                    <form data-toggle="validator" id="answer_vote" method="post"  enctype="multipart/form-data">
                        <input type='hidden' value='answerVote' id='method' name='method'>
                        <input type='hidden' value='vote' id='className' name='className'>
                    <div class="parent-form-private">

                        {foreach $list_vote as $key => $vote}
                            <input type="hidden" id="voteid" name="voteid[{$vote.id}]" value="{$vote.id}" />
                            <div  class='col-12 form-group' >
                                <span for="request-rights" style='margin: 20px 0'>{$vote.title}</span>
                                <br>
                                {foreach $objVote->getQuestionItem($vote.id) as $key => $item}
                                    <label class="" style='margin: 0 10px'>
                                        <input type="radio" id="{$vote.id}" name="answer[{$vote.id}]" value='{$item.id}' >
                                        <span>{$item.title}</span>
                                    </label>
                                {/foreach}
                            </div>
                                <div  class='col-12 form-group'>
                                    <label for="comment" class="control-label">دلیل انتخاب شما</label>
                                    <input type="text" class="form-control" name="reason_{$vote.id}"
                                              id="reason_{$vote.id}" placeholder=" ">

                            </div>
                            <hr>
                        {/foreach}
                    </div>
                    <div class='col-12 d-flex align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                        <button class="btn btn-success btn-block btn-fixed submit-button" type="submit">ارسال</button>
                    </div>
                    </form>
                </div>

            </div>
    </div>

</div>
</div>

<script type="text/javascript" src="assets/JsFiles/vote.js"></script>

