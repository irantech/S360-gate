
{foreach $comments as $comment}
{*    $comment['count_under_not_confirm']*}
    <tr id="del-{$comment['id']}"  {if $comment['count_under_not_confirm']>0 }style='background-color: #fae3f3 !important;' {/if}>
        <td>
            {$comment['created_at_fa']}
        </td>
        <td>
            <a target='_blank' href="{$comment['item_link']}">
                {$comment['item_title']|mb_substr:0:60}...
            </a>
            {if $comment['text_under']}
            <hr>
            <span target='_blank' href="{$comment['item_link']}">
                {$comment['text_under']|mb_substr:0:20}...
            </span>
{*            <textarea id='comment-text-{$comment['id']}'  disabled style='text-align: right'>*}
{*                {$comment['text_under']}*}
{*            </textarea>*}
            {/if}
            <textarea id='comment-text-{$comment['id']}' class='d-none' disabled>
                {$comment['text']}
            </textarea>
        </td>



        <td>
            {$comment['name']}
        </td>

        <td>
           {if $comment['mobile']} {$comment['mobile']} {else} --- {/if}
        </td>
        <td>
            {if $comment['email']}{$comment['email']|mb_substr:0:20}{else}---{/if}
        </td>


        <td>
            <a onclick="ModalShowInfoComment('{$comment.id}');return false"
               data-toggle="modal"
               class="btn btn-primary"
               data-target="#ModalPublic">
                نمایش کامل متن
            </a>
            <a onclick="openEditCommentModal('{$comment.id}');return false"
               data-toggle="modal"
               class="btn btn-primary"
               data-target="#ModalPublic">
                ویرایش نظر
            </a>
            <a onclick="openDeleteCommentModal('{$comment.id}');return false"
               data-toggle="modal"
               class="btn btn-danger"
               data-target="#ModalPublic">
                حذف نظر
            </a>
            <hr style='background-color: #c8c6c6;'>
            {$comment['text']|mb_substr:0:30}...
            <textarea id='comment-text-{$comment['id']}' class='d-none' disabled style='text-align: right'>
                {$comment['text']}
            </textarea>
        </td>


        <td>
            <a onclick="openNewReplayComment('{$comment.id}','{$comment.item_id}','{$section}');return false"
               class="btn btn-primary">
                ثبت پاسخ
            </a>
        </td>




        <td class="text-center">
            <div class="status-badge mb-2">
                {if $comment['validate'] eq 0}
                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                <i class="fa fa-clock-o me-1"></i></i> در انتظار
            </span>
                {elseif $comment['validate'] eq 1}
                    <span class="badge rounded-pill bg-success px-3 py-2">
                <i class="fa fa-check-circle me-1"></i> فعال
            </span>
                {elseif $comment['validate'] eq 2}
                    <span class="badge rounded-pill bg-danger px-3 py-2">
                <i class="fa fa-times-circle me-1"></i> غیرفعال
            </span>
                {/if}
            </div>

            <div class="btn-group btn-group-sm">
                <button class="btn btn-success" onclick="showCommentsOnSite('{$comment.id}','1')">
                    <i class="fa fa-check"></i>
                </button>
                <button class="btn btn-danger" onclick="showCommentsOnSite('{$comment.id}','2')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </td>



        <td>
            <a href="#"
               onclick="showCommentManiPage('{$comment.id}'); return false">
                {if $comment.show_main}
                    <input type="checkbox" class="js-switch" data-color="#99d683"
                           data-secondary-color="#f96262" data-size="small" checked/>
                {else}
                    <input type="checkbox" class="js-switch" data-color="#99d683"
                           data-secondary-color="#f96262" data-size="small"/>
                {/if}
            </a>
        </td>

        <td>
            <input type="number"
                   class="form-control main-order-input"
                   data-id="{$comment.id}"
                   value="{$comment.orders}"
                   style="width: 70px; text-align:center;">
        </td>
        <td>

            <a href="edit?section={$section}&id={$comment.id} " class=""><i
                        class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                        data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="جزییات نظر"></i></a>

        </td>

    </tr>
    {if {$comment['replays']}}

        {include file="`$smarty.const.FRONT_CURRENT_ADMIN`comments/item.tpl" comments=$comment['replays'] section=$section is_parent=false}

    {/if}
{/foreach}