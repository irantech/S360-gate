$(document).ready(function() {
   $('.dropify').dropify();
   $('.js-switch').each(function() {
      new Switchery($(this)[0], $(this).data());
   });
})

function submitNewCommentReplay(comment_id, item_id, section) {
   const form_box = $("#new_comment_replay")
   $.ajax({
      url: amadeusPath + "ajax",
      data: JSON.stringify({
         method: "newComment",
         className: "comments",
         comment_body: form_box.find("textarea").val(),
         item_id: item_id,
         parent_id: comment_id,
         section: section,
      }),
      dataType: "json",
      type: "POST",

      success: function (response) {
         var comment_replay = $('#comment_replay').val();
         if (comment_replay != '') {
            if (response.success) {
               $.toast({
                  heading: response.message.title,
                  text: response.message.message,
                  position: "top-right",
                  loaderBg: "#fff",
                  icon: "success",
                  hideAfter: 2500,
                  textAlign: "right",
                  stack: 6,
               })
               setTimeout(function() {
                  location.reload()
               }, 1000)
            }
         }else{
            $.toast({
               heading: response.message.title,
               text: response.message.message,
               position: "top-right",
               loaderBg: "#fff",
               icon: "error",
               hideAfter: 2500,
               textAlign: "right",
               stack: 6,
            });
         }
      },
      error: function (xhr, status, error) {
         let errorMessage = 'خطای ناشناخته رخ داده است';

         if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
         } else if (xhr.responseText) {
            errorMessage = xhr.responseText;
         } else {
            errorMessage = xhr.statusText || 'اتصال با سرور برقرار نشد';
         }

         $.toast({
            heading: "خطا در ارسال پاسخ",
            text: errorMessage,
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3000,
            textAlign: "right",
            stack: 6
         });
      }
   })
}

function openNewReplayComment(comment_id, item_id, section) {
   const form_box = $("#new_comment_replay")
   const text = $("#comment-text-" + comment_id).val()
   $("#new_comment_replay").modal()
   form_box.find("[data-name='text']").html(text)
   form_box
      .find('button[data-name="submit"]')
      .attr(
         "onClick",
         'submitNewCommentReplay("' +
         comment_id +
         '", "' +
         item_id +
         '", "' +
         section +
         '")'
      )
}

function ModalShowInfoComment(CommentId) {
   $.post(libraryPath + 'ModalCreator.php',
      {
         Controller: 'comments',
         Method: 'ModalShowInfoComment',
         Param: CommentId
      },
      function (data) {
         $('#ModalPublic').html(data);
      });
}
// ===============show/Edit comment modal =================
function openEditCommentModal(comment_id) {
   $.post(libraryPath + 'ModalCreator.php',
      {
         Controller: 'comments',
         Method: 'ModalEditComment',
         Param: comment_id
      },
      function (data) {
         $('#ModalPublic').html(data);
         $('#ModalPublic').find('#edit-comment-text').val($("#comment-text-" + comment_id).val());
      });
}


function submitEditComment(comment_id) {

   const form_box = $("#editCommentForm");
   const new_text = form_box.find("textarea").val();

   $.ajax({
      url: amadeusPath + "ajax",
      type: "POST",
      dataType: "json",
      data: JSON.stringify({
         method: "editComment",
         className: "comments",
         comment_id: comment_id,
         comment_body: new_text
      }),
      success: function(response) {

         if (response.success) {
            $.toast({
               heading: response.message.title,
               text: response.message.message,
               position: "top-right",
               loaderBg: "#fff",
               icon: "success",
               hideAfter: 2500,
               textAlign: "right",
               stack: 6,
            });

            setTimeout(() => location.reload(), 800);

         } else {
            $.toast({
               heading: response.message.title,
               text: response.message.message,
               position: "top-right",
               loaderBg: "#fff",
               icon: "error",
               hideAfter: 2500,
               textAlign: "right",
               stack: 6,
            });
         }

      },

      error: function(xhr, status, error) {

         let errorMessage = 'خطای ناشناخته رخ داده است';

         if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
         } else if (xhr.responseText) {
            errorMessage = xhr.responseText;
         } else {
            errorMessage = xhr.statusText || 'عدم اتصال به سرور';
         }

         $.toast({
            heading: "خطا",
            text: errorMessage,
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3000,
            textAlign: "right",
            stack: 6,
         });
      }
   });
}
// ===============show/delete comment modal =================
function openDeleteCommentModal(comment_id) {
   const modalHtml = `
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">حذف نظر</h4>
                </div>
                <div class="modal-body">
                    <p>آیا از حذف این نظر اطمینان دارید؟ این عملیات برگشت‌پذیر نخواهد بود.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                    <button type="button" class="btn btn-danger" onclick="submitDeleteComment(${comment_id})">حذف</button>
                </div>
            </div>
        </div>
    `;
   $('#ModalPublic').html(modalHtml);
}

function submitDeleteComment(comment_id) {
   if (!comment_id) return;

   $.ajax({
      url: amadeusPath + 'ajax', // مسیر API حذف نظر
      type: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify({
         className: 'comments',
         method: 'deleteComment',
         comment_id: comment_id
      }),
      success: function(response) {
         if (response.success) {
            $.toast({
               heading: response.message.title || 'حذف نظر',
               text: response.message.message || 'نظر با موفقیت حذف شد',
               position: 'top-right',
               loaderBg: '#fff',
               icon: 'success',
               hideAfter: 3000,
               textAlign: 'right',
               stack: 6
            });

            // بستن modal
            $('#ModalPublic').modal('hide');

            // حذف کامنت از صفحه
            setTimeout(() => location.reload(), 800);
         } else {
            $.toast({
               heading: 'خطا در حذف نظر',
               text: response.message || 'مشکلی در حذف نظر رخ داده است',
               position: 'top-right',
               loaderBg: '#fff',
               icon: 'error',
               hideAfter: 3000,
               textAlign: 'right',
               stack: 6
            });
         }
      },
      error: function(xhr, status, error) {
         let errorMessage = 'خطای ناشناخته رخ داده است';
         if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
         } else if (xhr.responseText) {
            errorMessage = xhr.responseText;
         } else {
            errorMessage = xhr.statusText || 'اتصال با سرور برقرار نشد';
         }

         $.toast({
            heading: 'خطا در حذف نظر',
            text: errorMessage,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3000,
            textAlign: 'right',
            stack: 6
         });
      }
   });
}




function showCommentsOnSite(id, validate) {
   $.confirm({
      theme: 'supervan',
      title: 'تغییر وضعیت نظر',
      icon: 'fa fa-trash',
      content: 'آیا از تغییر وضعیت نمایش نظر در سایت اطمینان دارید',
      rtl: true,
      closeIcon: true,
      type: 'orange',
      buttons: {
         confirm: {
            text: 'تایید',
            btnClass: 'btn-green',
            action: function () {
               $.post(amadeusPath + 'user_ajax.php',
                  {
                     id: id,
                     validate: validate,
                     flag: 'EditCommentValidate'
                  },
                  function (response) {
                     var res = response.split(':');
                     if (response.indexOf('success') > -1) {
                        $.toast({
                           heading: 'تغییر وضعیت نظر',
                           text: 'انجام شد',
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'success',
                           hideAfter: 3500,
                           textAlign: 'right',
                           stack: 6
                        });
                        let statusCell = $("#del-" + id + " .status-badge");

                        if (validate == 1) {
                           statusCell.html('<span class="badge rounded-pill bg-success px-3 py-2"><i class="fa fa-check-circle me-1"></i> فعال</span>');
                        }
                        if (validate == 2) {
                           statusCell.html('<span class="badge rounded-pill bg-danger px-3 py-2"><i class="fa fa-times-circle me-1"></i> غیرفعال</span>');
                        }
                     } else {
                        $.toast({
                           heading: 'تغییر وضعیت نظر',
                           text: 'مشکلی رخ داده است',
                           position: 'top-right',
                           loaderBg: '#fff',
                           icon: 'error',
                           hideAfter: 3500,
                           textAlign: 'right',
                           stack: 6
                        });
                        $('.btnCommentStatus').removeClass().addClass('btnCommentStatus btn btn-danger cursor-default').html('عدم نمایش در سایت')
                     }
                  });
            }
         },
         cancel: {
            text: 'انصراف',
            btnClass: 'btn-orange'
         }
      }
   });
}

function showCommentManiPage(id){
   $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'JSON',
      data:  JSON.stringify({
         className: 'comments',
         method: 'changeShowCommentManiPage',
         id,
      }),
      success: function (data) {
         $.toast({
            heading: 'تغییر وضعیت نمایش نظر در صفحه اصلی',
            text: data.message,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      },
      error: function(xhr, status, error) {
         let errorMessage = 'خطای ناشناخته رخ داده است';

         if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
         } else if (xhr.responseText) {
            errorMessage = xhr.responseText;
         } else {
            errorMessage = xhr.statusText || 'اتصال با سرور برقرار نشد';
         }

         $.toast({
            heading: 'تغییر وضعیت نمایش نظر در صفحه اصلی',
            text: errorMessage,
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
         });
      }
   });
}

$(document).on("blur", ".main-order-input", function () {
   let input = $(this);
   let id = input.data("id");
   let order = input.val();

   $.ajax({
      type: "POST",
      url: amadeusPath + "ajax",
      dataType: "JSON",
      data: JSON.stringify({
         className: "comments",
         method: "changeCommentMainOrder",
         id: id,
         order: order,
      }),
      success: function (data) {
         $.toast({
            heading: "ترتیب نمایش در صفحه اصلی",
            text: data.message,
            position: "top-right",
            loaderBg: "#fff",
            icon: "success",
            hideAfter: 3000,
            textAlign: "right",
            stack: 6
         });
      },
      error: function(xhr, status, error) {
         let errorMessage = 'خطای ناشناخته رخ داده است';

         if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
         } else if (xhr.responseText) {
            errorMessage = xhr.responseText;
         } else {
            errorMessage = xhr.statusText || 'اتصال با سرور برقرار نشد';
         }

         $.toast({
            heading: "خطا در تغییر ترتیب",
            text: errorMessage,
            position: "top-right",
            loaderBg: "#fff",
            icon: "error",
            hideAfter: 3000,
            textAlign: "right",
            stack: 6
         });
      }
   });
});