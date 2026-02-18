<div class="all-comments">
    {foreach $comments as $comment}
        {if $comment['parent_id'] > 0}
            {assign var="check_reply" value=true}
        {else}
            {assign var="check_reply" value=false}
        {/if}
        <div id='comment-item-{$comment['id']}' data-name='comment-{$comment['id']}' class="comments comment-{if $check_reply neq true}original {else}reply {/if}">
            <div class="comment-content ">
                <div class="header-comment">
                    <div class='box-data'>
                        <div class='parent-user'>
                        <div class='align-items-center bg-light-blue d-flex flex-wrap justify-content-center parent-comment-img'>
                            <img src='assets/images/comment/user.jpg' alt='user comment'>
                        </div>
                            <div class="comment-author  text-bold">
                            <span data-name='name' class="comment-author-link">
                                {$comment['name']}
                            </span>
                                <time class="comment-meta-item">
                                <span>
                                    {$comment['created_at']}
                                </span>
                                </time>
                            </div>
                        </div>
                        <div class='parent-reply-link'>
                            <button type='button' onclick='commentReplay("{$comment['id']}")' class='btn btn-default reply-link'>
                                <i class="fa fa-reply"></i>
                            </button>
                        </div>
                    </div>
                    <div class='text-comment'>
                        <p class="p_comment">
                            {$comment['text']}
                        </p>
                    </div>
                </div>
            </div>
            {if isset($comment['replays']) && $comment['replays']}
                <div class=' rounded parent-reply'>
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/comments/comment.tpl" comments=$comment['replays'] section=$section}
                </div>
            {/if}
        </div>
    {/foreach}
</div>