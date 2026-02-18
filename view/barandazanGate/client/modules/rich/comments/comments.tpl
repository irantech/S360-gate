

{*{$comments|var_dump}*}
<style>
    label.error{
        color: #ee384e !important;
        order: 2;
    }
</style>

<form data-toggle="validator" id='submit_new_comment' class="form-comment-blog" enctype='multipart/form-data'>
    <div class='title-comment'>
        <i class="fa-solid fa-comment-plus"></i>
    <h2>##SubmitComment##</h2>
    </div>
    <input type="hidden" name="method" value="newComment">
    <input type="hidden" name="className" value="comments">
    <input type="hidden" name="section" value="{$section}">
    <input type="hidden" name="item_id" value="{$item_id}">
    <input type="hidden" name="parent_id" value="0">
    <div class="div_area">
        <div class='d-flex flex-wrap align-items-center justify-content-between'>
            <label data-name='title' for="area">##commentText##
                <span>*</span>
            </label>
            <span data-name='cancel_replay' class='d-none btn btn-cancel  btn-danger' onclick='commentReplay()'>##CancleReplay##</span>
        </div>
        <textarea id="area" placeholder="##enterYourOpinion##..." name="comment_body"></textarea>
    </div>
    <div class="input_comment">
        <div class="">
            <label for="comment_name">##Namefamily##<span>*</span></label>
            <input placeholder="##PleaseEnterYourName##"
                    {if $user_info}
                        value="{$user_info['name']} {$user_info['family']}" disabled
                    {elseif $objSession->adminIsLogin()}
                        value="مدیریت {$smarty.const.CLIENT_NAME}" disabled
                    {/if}
                   id="comment_name"
                   name="comment_name"
                   type="text">
        </div>
        <div class="">
            <label class="label_email" for="comment_email">##Mobile##<span>*</span>
            </label>
            <input placeholder="##PleaseEnterMobile##"
                    {if $user_info}
                        value="{$user_info['mobile']}" disabled
                    {elseif $objSession->adminIsLogin()}
                        value="{$smarty.const.CLIENT_MOBILE}" disabled
                    {/if}
                   id="comment_mobile"
                   name="comment_mobile"
                   type="text">
        </div>
        <div class="">
            <label class="label_email" for="comment_email">##Email##<span>*</span>
            </label>
            <input placeholder="##PleaseEnterEmail##"
                    {if $user_info}
                        value="{$user_info['email']}" disabled
                    {elseif $objSession->adminIsLogin()}
                        value="{$smarty.const.CLIENT_EMAIL}" disabled
                    {/if}
                   id="comment_email"
                   name="comment_email"
                   type="email">
        </div>
        <button type="submit" class="btn-submit-blog"> ##Send##</button>
    </div>
</form>

<script src="assets/js/modules/comments.js"></script>
