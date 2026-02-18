{load_presentation_object filename="reservationTour" assign="objResult"}
{load_presentation_object filename="comments" assign="objComments"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
{assign var="section" value=$smarty.get.section}
{assign var="comments" value=$objComments->getAllComments($smarty.get.section,null, $smarty.get.id,true)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">نظر کاربران</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">
                    لیست نظرات
                    {if $section eq 'news'}
                    اخبار
                    {elseif $section eq 'tour'}
                        تور
                    {else}
                      مقالات
                    {/if}

                </h3>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable2" class="table table-striped text-center">
                        <thead>
                        <tr>


                            <th>تاریخ و ساعت ثبت نظر</th>
                            <th>مطلب</th>
                            <th>نام</th>
                            <th>موبایل</th>
                            <th>ایمیل</th>
                            <th>متن نظر</th>
                            <th>پاسخ</th>
                            <th>وضعیت</th>
                            <th>تائید نمایش در سایت</th>
                            <th>عدم نمایش در سایت</th>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        {include file="`$smarty.const.FRONT_CURRENT_ADMIN`comments/item.tpl" section=$section comments=$comments is_parent=true}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="new_comment_replay" tabindex="-1" role="dialog" aria-labelledby="new_comment_replay" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="new_comment_replayTitle">ثبت پاسخ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class='w-100 block' id='new_comment_replay_form' action='' method='post' enctype='multipart/form-data'>

                    <div class="modal-body">
                        <div class='w-100 p-2 border rounded mb-3' data-name='text'>

                        </div>
                        <input type="hidden" name="method" value="newComment">
                        <input type="hidden" name="className" value="comments">
                        <input type='hidden' name='comment_id'>
                        <textarea name='comment_replay' id='comment_replay' class='w-100 '></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        <button data-name='submit' type="button" onclick='submitNewCommentReplay()' class="btn btn-primary">ثبت پاسخ</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


</div>
<script>
    $(document).ready(function () {
      var table = $('#myTable2').DataTable({
        order: [[0, 'desc']],
      });

    })
</script>
<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>
<script type="text/javascript" src="assets/modules/js/comments/comments.js"></script>