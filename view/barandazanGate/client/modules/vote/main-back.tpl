{load_presentation_object filename="vote" assign="objVote"}
{assign var="send_data" value=['is_active'=>1 , 'order' =>'DESC']}
{assign var='list_vote' value=$objVote->listVote($send_data)}
<section class="title-form">
    <img src="assets/images/How%20to%20sell%20your%20web%20design%20business%20for%20top%20dollar.jpg" alt="img">
    <div class="container">
        <h2>فرم نظرسنجی</h2>
        <svg class="title-sum" version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2677.000000 186.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,186.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M18275 1689 c-1865 -8 -3306 -27 -4740 -64 -544 -13 -1285 -32 -1645 -40 -360 -8 -1224 -38 -1920 -65 -696 -27 -1384 -54 -1530 -60 -473 -18 -706 -30 -1975 -100 -687 -38 -1421 -79 -1630 -90 -209 -11 -445 -25 -525 -30 -185 -13 -3173 -267 -3300 -281 -321 -34 -792 -91 -832 -100 -62 -14 -131 -74 -153 -134 -25 -65 -17 -150 21 -211 37 -59 114 -106 176 -106 24 1 225 21 448 46 494 55 560 61 2040 186 652 56 1228 105 1280 111 52 5 869 52 1815 104 946 52 1752 97 1790 100 39 3 426 19 860 35 435 17 1200 46 1700 65 1242 48 4063 112 5740 130 737 8 2006 15 2819 15 l1480 0 1365 -40 c1161 -34 1500 -48 2256 -90 1719 -96 2482 -149 2620 -180 70 -16 136 -11 190 14 140 65 186 235 98 367 -41 62 -98 93 -215 118 -288 59 -1221 124 -3028 211 -707 34 -703 34 -1800 61 -443 11 -967 24 -1165 29 -198 5 -414 9 -480 8 -66 -1 -858 -5 -1760 -9z"></path>
            </g>
        </svg>
    </div>
</section>
<section class="employment-form position-relative">

    <div class="container">
        <div class="parent-employment-form">
            <div class="parent-form">
                <form data-toggle="validator" id="insert_answer_vote" method="post"  enctype="multipart/form-data">
                    <input type="hidden" name="flag" value="answerVoteUser">
                    <div class="box-data-family">
                        <div class="title-Internal">
                            <svg class="svg-title svg-title-2" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <h5>سوالات نظرسنجی</h5>
                        </div>
                        <div class="parent-form-private">


                            {foreach $list_vote as $key => $vote}
                                <input type="hidden" id="voteid" name="voteid[{$vote.id}]" value="{$vote.id}" />
                                <div  class='col-12 form-group' >
                                    <span for="request-rights" style='margin: 20px 0'>{$vote.title}</span>
                                    <br>
                                    {foreach $objVote->getQuestionItem($vote.id) as $key => $item}
                                        <label class="" style='margin: 0 10px'>
                                            <input type="radio" class="radioFara" id="{$vote.id}" name="answer[{$vote.id}]" value='{$item.id}' >
                                            <span>{$item.title}</span>
                                        </label>
                                    {/foreach}
                                </div>
                                <div  class='col-12 form-group'>
                                    <label for="comment" class="control-label">دلیل انتخاب شما</label>
                                    <input type="text" class="form-control reason" name="reason_{$vote.id}"
                                           id="reason_{$vote.id}" placeholder=" ">

                                </div>
                                <hr>
                            {/foreach}
                        </div>
                    </div>
                    <div class="login-captcha gds-l-r-error">
                       <span>
                        <input class="full-width has-padding capchaFara" type="number" placeholder="##Securitycode##" name="signup-captcha2" id="signup-captcha2">
                         <a id="captchaRefresh" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php" alt="">
                       </span>
                    </div>
                    <div class="btn-send">
                        <button type="submit" id="voteButton" >ارسال اطلاعات</button>
                    </div>


                    <div class="gds-login-error-box gds-login-error-none">
                        <div class="gds-login-error-box-inner">
                            <div class="message-login txtCenter txtRed"></div>
                            <div class="gds-login-register-error" id="error-signin-captcha2"></div>
                        </div>
                    </div>
                    <div class='message-register'></div>
                </form>
            </div>
            <div class="col-img">
                <div class="parent-img">
                    <img src="assets/images/2.png" alt="img">
                </div>
            </div>
        </div>
    </div>
</section>

{literal}
    <script src="assets/modules/js/vote.js"></script>

{/literal}


