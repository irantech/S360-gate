
<form id='submit_new_comment' class="form_comment form-tour" enctype='multipart/form-data'>
    <input type="hidden" name="method" value="newComment">
    <input type="hidden" name="className" value="comments">
    <input type="hidden" name="section" value="{$section}">
    <input type="hidden" name="item_id" value="{$item_id}">
    <input type="hidden" name="parent_id" value="0">
    <div class="div_area">
        <div class='d-flex flex-wrap gap-10 align-items-center '>
            <label data-name='title' for="area">##Yourcomment##
                <span>*</span>
            </label>
            <span data-name='cancel_replay' class='d-none btn btn-cancel  btn-danger' onclick='commentReplay()'>##CancleReplay##</span>
        </div>
        <textarea id="area" placeholder="##Writeyourcomment##..." name="comment_body"></textarea>
    </div>
    <div class="">
        <div class='input_comment'>
            <div class="">
                <label for="comment_name">##Name##<span>*</span></label>
                <input placeholder="##PleaseEnterYourName##"
                        {if $user_info}
                            value="{$user_info['name']} {$user_info['family']}" disabled
                        {/if}
                       id="comment_name"
                       name="comment_name"
                       type="text">
            </div>
            <div class="">
                <label class="label_email" for="comment_email">##Email##<span>*</span>
                </label>
                <input placeholder="##PleaseEnterEmail##"
                        {if $user_info}
                            value="{$user_info['email']}" disabled
                        {/if}
                       id="comment_email"
                       name="comment_email"
                       type="email">
            </div>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn_submit"> ##SendComment##</button>
        </div>
    </div>

</form>
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/comments/comment.tpl" comments=$comments item_id=$item_id section=$section}

<script src="assets/js/modules/comments.js"></script>
