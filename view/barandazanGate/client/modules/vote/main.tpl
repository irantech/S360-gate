{load_presentation_object filename="vote" assign="objVote"}
{assign var="send_data" value=['is_active'=>1 , 'order' =>'DESC']}
{assign var='list_vote' value=$objVote->listVote($send_data)}
{$list_vote_count = $list_vote|@count}
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/vote-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/vote.css'>
{/if}
<div class="survey">
    <div class="">
        <div class="parent-survey">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 col-img p-0">
                <div class="parent-img-survey">
                    <img src="assets/images/vote/survey.jpg" alt="img-survey">
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 col-text p-0">
                {if $list_vote}
                <form data-toggle="validator" id="insert_answer_vote" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="flag" value="answerVoteUser">
                    <h2>##PassengerSurveyForm##</h2>
                    <div class="parent-js-question">
                        {assign var="number" value="0"}
                        {foreach $list_vote as $key => $vote}
                            {$number=$number+1}
                        <div id="{$number}" class="box-item-survey {if $number==1}active{/if}">
                            <h3>{$number}- {$vote.title}</h3>
                            <div class="form-input">
                                {foreach $objVote->getQuestionItem($vote.id) as $key => $item}
                                <div class="parent-label">
                                    <input id="{$item.id}" type="radio" name="answer[{$vote.id}]" value="{$item.id}">
                                    <label for="{$item.id}">{$item.title}</label>
                                </div>
                                {/foreach}
                            </div>
                            <div class="form-textarea">
                                <label for="text-form1">
                                    <svg viewBox="0 0 24 24" width="1.5em" height="1.5em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    ##TheReasonForYourChoice##
                                </label>
                                <textarea  id="reason_{$vote.id}" name="reason_{$vote.id}" cols="5" rows="2" placeholder="##PleaseWriteUsYourReason##"></textarea>
                            </div>

                        </div>
                        {/foreach}
                    </div>

                    <div class="voteCapcha" {if $list_vote_count > 1} style="display: none" {else}style="display: block"  {/if} >
                      <input  type="number" placeholder="##Securitycode##" name="vote-captcha" id="vote-captcha">
                        <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid=" alt="captcha image">
                        <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                    </div>
                    <div class="parent-btn-form">
                        <button type="button" class="btn-form-next" {if $list_vote_count > 1} style="display: block" {else}style="display: none"  {/if} onclick="clickNext()">
                            ##NextOne##
                        </button>
                        <button class="btn-form-submit" {if $list_vote_count > 1} style="display: none" {else}style="display: block"  {/if}>
                            ##Send##
                        </button>
                        <button type="button" class="btn-form-back" style="display: none" onclick="clickBack()">
                            ##JustReturn##
                        </button>
                    </div>
                </form>
                    {else}
                    <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
                        ##NoQuestionHasBeenRegisteredForThisPollYet##
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>

{literal}
    <script src="assets/modules/js/vote.js"></script>
{/literal}

