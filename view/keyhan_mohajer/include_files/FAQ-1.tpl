{assign var="data_search_public" value=['service'=>'Public','limit'=> 10]}
{assign var='faqs' value=$obj_main_page->faqsPosition($data_search_public)}

{if $faqs|count > 0}
<section class="section_club my-5 py-5">
    <div class="container">
        <div class="w-100">
            <div class="clubTitle">
                <h2>سوالات متداول</h2>
            </div>
            <div class="FAQ py-3">
                <div>
                    <div class="accordion" id="accordionExample">
                        {foreach $faqs as $key => $faq}
                            <div class="mb-3 accordion_btnParent">
                                <div class="" id="heading0">
                                    <button aria-controls="collapse{$faq['id']}" aria-expanded="true" class="accordion_btn collapsed" data-target="#collapse{$faq['id']}" data-toggle="collapse">

                                        {$faq['title']}

                                        <i>
                                            <svg viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M23.5 294.5l152-143.1C180.1 146.2 186.1 144 192 144s11.88 2.188 16.5 6.562l152 143.1c9.625 9.125 10.03 24.31 .9375 33.93c-9.125 9.688-24.38 10.03-33.94 .9375l-135.5-128.4l-135.5 128.4c-9.562 9.094-24.75 8.75-33.94-.9375C13.47 318.9 13.87 303.7 23.5 294.5z"></path></svg>
                                        </i>
                                    </button>
                                </div>
                                <div aria-labelledby="heading{$faq['id']}" class="collapse" data-parent="#accordionExample" id="collapse{$faq['id']}">
                                    <div class="accordion_text">
                                        {$faq['content']}
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                    <div class="w-100 d-flex justify-content-between align-items-center mt-3">
                        <a class="btn_more" href="{$smarty.const.ROOT_ADDRESS}/faq">سوالات بیشتر</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="service" id="contact_HolderPart2" style="display: none;">
            <div class="header-title"><h4 class="heading"> سوالی دارید؟ </h4>
                <span>اگر سوال خاصی دارید که در لیست سوالات متداول نبود از طریق فرم زیر برای ما ارسال نمایید</span>
            </div>
            <p id="AlertSmsTemp"></p>
            <div class="w-100">
                <form action="http://192.168.1.100/immigration_Demo/fa/user/#contact_HolderPart2" id="FormPrj" method="post" name="FormPrj">
                    <h4 class="Red Center"></h4>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-input">
                            <label class="textInputs" for="name">نام و نام خانوادگی</label>
                            <input class="focusInputs" id="name" name="name" type="text" value=""/>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 col-input">
                            <label class="textInputs" for="cell">شماره همراه</label>
                            <input class="focusInputs" id="cell" name="cell" type="text" value=""/>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 col-input">
                            <label class="textInputs" for="comment">متن خود را بنویسید</label>
                            <textarea class="focusInputs" id="comment" name="comment" type="text"></textarea>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 col-input">
                            <button class="btn btn-success btn_send" onclick="Contact()" type="button">

                                ارسال

                            </button>
                        </div>
                    </div>
                    <span id="SpamCell"></span> <span id="SpamEmail"></span></form>
            </div>
        </div>
    </div>
</section>
{/if}
