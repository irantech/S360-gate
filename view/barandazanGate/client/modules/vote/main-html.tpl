{load_presentation_object filename="vote" assign="objVote"}
{assign var="send_data" value=['is_active'=>1 , 'order' =>'DESC']}
{assign var='list_vote' value=$objVote->listVote($send_data)}
<div class="survey">
    <div class="">
        <div class="parent-survey">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 col-img p-0">
                <div class="parent-img-survey">
                    <img src="assets/images/vote/survey.jpg" alt="img-survey">
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 col-text p-0">
                <form data-toggle="validator" id="insert_answer_vote" method="post"  enctype="multipart/form-data" >
                    <h2>فرم نظرسنجی مسافران</h2>
                    <div class="parent-js-question">
                        <div id="1" class="box-item-survey active">
                            <h3>1- میزان رضایت شما از نحوه برخورد و پاسخگویی پرسنل گردش در هنگام مکالمه تلفنی چگونه بود؟</h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="01">عالی</label>
                                    <input id="01" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="02">خوب</label>
                                    <input id="02" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="03">متوسط</label>
                                    <input id="03" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="04">ضعیف</label>
                                    <input id="04" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form1">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form1" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>

                        </div>
                        <div id="2" class="box-item-survey ">
                            <h3>
                                2- رضایت شما از نحوه برخورد و پاسخگویی پرسنل گردش در هنگام مراجعه حضوری چگونه بوده است؟
                            </h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="05">عالی</label>
                                    <input id="05" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="06">خوب</label>
                                    <input id="06" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="07">متوسط</label>
                                    <input id="07" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="08">ضعیف</label>
                                    <input id="08" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form2">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form2" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>

                        </div>
                        <div id="3" class="box-item-survey ">
                            <h3>
                                3- اطلاعات کارمندان گردش از خدمات خواسته شده چگونه بوده است؟
                            </h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="09">عالی</label>
                                    <input id="09" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="010">خوب</label>
                                    <input id="010" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="011">متوسط</label>
                                    <input id="011" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="012">ضعیف</label>
                                    <input id="012" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form3">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form3" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>

                        </div>
                        <div id="4" class="box-item-survey ">
                            <h3>
                                4- میزان دقت و سرعت عمل پرسنل در انجام وظایف چگونه بوده است؟
                            </h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="013">عالی</label>
                                    <input id="013" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="014">خوب</label>
                                    <input id="014" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="015">متوسط</label>
                                    <input id="015" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="016">ضعیف</label>
                                    <input id="016" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form4">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form4" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>

                        </div>
                        <div id="5" class="box-item-survey ">
                            <h3>
                                5- رضایت شما از محتوای سایت شرکت گردش چگونه بوده است؟
                            </h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="017">عالی</label>
                                    <input id="017" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="018">خوب</label>
                                    <input id="018" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="019">متوسط</label>
                                    <input id="019" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="020">ضعیف</label>
                                    <input id="020" type="radio" name="r" value="4">
                                </div>
                                <div class="parent-label">
                                    <label for="020">ضعیف</label>
                                    <input id="020" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form5">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form5" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>
                        </div>
                        <div id="6" class="box-item-survey ">
                            <h3>
                                6- آیا از طرح راضی هستید؟
                            </h3>
                            <div class="form-input">
                                <div class="parent-label">
                                    <label for="021">عالی</label>
                                    <input id="021" type="radio" name="r" value="1">
                                </div>
                                <div class="parent-label">
                                    <label for="022">خوب</label>
                                    <input id="022" type="radio" name="r" value="2">
                                </div>
                                <div class="parent-label">
                                    <label for="023">متوسط</label>
                                    <input id="023" type="radio" name="r" value="3">
                                </div>
                                <div class="parent-label">
                                    <label for="024">ضعیف</label>
                                    <input id="024" type="radio" name="r" value="4">
                                </div>
                            </div>
                            <div class="form-textarea">
                                <label for="text-form6">
                                    <svg viewBox="0 0 24 24" width="1em" height="1em" fill="#888" class="  shrink-0"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18Zm0 6a.75.75 0 0 1 .745.663l.005.087v7.5a.75.75 0 0 1-1.495.087l-.005-.087v-7.5A.75.75 0 0 1 12 9Zm0-3a.75.75 0 0 1 .745.663l.005.087v.75a.75.75 0 0 1-1.495.087L11.25 7.5v-.75A.75.75 0 0 1 12 6Z"></path></svg>
                                    دلیل انتخاب شما
                                </label>
                                <textarea name="" id="text-form6" cols="5" rows="2" placeholder="لطفا دلیل خود را برای ما بنویسید..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="parent-btn-form">
                        <button type="button" class="btn-form-next" onclick="clickNext()">
                            بعدی
                        </button>
                        <button class="btn-form-submit" style="display: none" >
                            ارسال
                        </button>
                        <button type="button" class="btn-form-back" style="display: none" onclick="clickBack()">
                            برگشت
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{literal}
    <script src="assets/modules/js/vote.js"></script>
{/literal}

