{load_presentation_object filename="userBookmarks" assign="objBookmarks"}

<style>
    .bookmarks-wrapper {
        background: #ffff;
        border-radius: 14px;
        padding: 20px;
        margin: 20px 0;
        border: solid 1px #ccc;
    }

    .bookmarks-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #ffffff;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        /*box-shadow: 0 2px 6px rgba(0,0,0,0.04);*/
    }

    .bookmarks-header:hover {
        background: #f9fafb;
        transform: translateY(-1px);
    }

    .bookmarks-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 17px;
        font-weight: 600;
        color: #1f2937;
    }

    .bookmarks-title i {
        color: #ef4444;
        font-size: 20px;
    }

    .bookmarks-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .bookmark-count {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
    }

    .add-bookmark-btn {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(16,185,129,0.2);
    }

    .add-bookmark-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }

    .toggle-icon {
        transition: transform 0.3s ease;
        color: #6b7280;
    }

    .toggle-icon.rotated {
        transform: rotate(180deg);
    }

    .bookmarks-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        margin-top: 0;
    }

    .bookmarks-content.expanded {
        margin-top: 15px;
    }

    .bookmarks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 12px;
    }

    .bookmark-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        position: relative;
        border-right: 4px solid #dc2626;
        cursor: pointer;
    }

    .bookmark-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .bookmark-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .bookmark-card-url {
        font-size: 12px;
        color: #6b7280;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        direction: ltr;
        text-align: left;
    }

    .bookmark-delete {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ef4444;
        color: #fff;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
        font-size: 12px;
    }

    .bookmark-card:hover .bookmark-delete {
        opacity: 1;
    }

    .bookmark-delete:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .empty-bookmarks {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
    }

    .empty-bookmarks i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.4;
    }

    .empty-bookmarks p {
        font-size: 14px;
        margin: 0;
    }

    /* Modal */
    .bookmark-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }

    .bookmark-modal.active {
        display: flex;
    }

    .modal-content {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        width: 90%;
        max-width: 480px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
    }

    .modal-close {
        background: #f3f4f6;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #e5e7eb;
        transform: rotate(90deg);
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit {
        flex: 1;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }

    .btn-cancel {
        flex: 1;
        background: #f3f4f6;
        color: #374151;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .bookmarks-grid {
            grid-template-columns: 1fr;
        }

        .bookmarks-header {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .bookmarks-controls {
            justify-content: space-between;
        }
    }
</style>

<div class="bookmarks-wrapper">
    <div class="bookmarks-header" onclick="toggleBookmarks()">
        <div class="bookmarks-title">
            <i class="fa fa-bookmark"></i>
            <span>لینک‌های سریع</span>
            <span style="font-size:14px">(برای خود دسترسی لینک های مهم پنل را ایجاد کنید.)</span>
{*            <span class="bookmark-count">{$objBookmarks->total_bookmarks}</span>*}
        </div>
        <div class="bookmarks-controls">
            <button class="add-bookmark-btn" onclick="event.stopPropagation(); openAddModal()">
                <i class="fa fa-plus"></i>
                افزودن لینک
            </button>
            <i class="fa fa-chevron-down toggle-icon" id="toggleIcon"></i>
        </div>
    </div>

    <div class="bookmarks-content" id="bookmarksContent">
        {if $objBookmarks->total_bookmarks > 0}
            <div class="bookmarks-grid" id="bookmarksGrid">
                {foreach from=$objBookmarks->bookmarks item=bookmark}
                    <div class="bookmark-card" onclick="window.open('{$bookmark.url}', '_blank')">
                        <button class="bookmark-delete" onclick="event.stopPropagation(); deleteBookmark({$bookmark.id})">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="bookmark-card-title">{$bookmark.title}</div>
{*                        <div class="bookmark-card-url">{$bookmark.url}</div>*}
                    </div>
                {/foreach}
            </div>
        {else}
            <div class="empty-bookmarks">
                <i class="fa fa-bookmark-o"></i>
                <p>هنوز لینکی ذخیره نکرده‌اید</p>
            </div>
        {/if}
    </div>
</div>

<!-- Modal -->
<div class="bookmark-modal" id="bookmarkModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>افزودن لینک جدید</h3>
            <button class="modal-close" onclick="closeAddModal()">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <form id="addBookmarkForm" onsubmit="return submitBookmark(event)">
            <div class="form-group">
                <label>عنوان لینک</label>
                <input type="text" id="bookmarkTitle" placeholder="مثال: پنل مدیریت" required>
            </div>
            <div class="form-group">
                <label>آدرس لینک</label>
                <input type="url" id="bookmarkUrl" placeholder="https://example.com" required>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-submit">ذخیره</button>
                <button type="button" class="btn-cancel" onclick="closeAddModal()">انصراف</button>
            </div>
        </form>
    </div>
</div>

<script>
   $(document).ready(function() {
   const content = document.getElementById('bookmarksContent');
   const icon = document.getElementById('toggleIcon');
      content.style.maxHeight = content.scrollHeight + 'px';
      content.classList.add('expanded');
      icon.classList.add('rotated');
   })
   function toggleBookmarks() {
      const content = document.getElementById('bookmarksContent');
      const icon = document.getElementById('toggleIcon');

      if (content.style.maxHeight && content.style.maxHeight !== '0px') {
         content.style.maxHeight = '0';
         content.classList.remove('expanded');
         icon.classList.remove('rotated');
      } else {
         content.style.maxHeight = content.scrollHeight + 'px';
         content.classList.add('expanded');
         icon.classList.add('rotated');
      }
   }

   function openAddModal() {
      document.getElementById('bookmarkModal').classList.add('active');
      document.getElementById('bookmarkTitle').focus();
   }

   function closeAddModal() {
      document.getElementById('bookmarkModal').classList.remove('active');
      document.getElementById('addBookmarkForm').reset();
   }

   function submitBookmark(e) {
      e.preventDefault();

      const title = document.getElementById('bookmarkTitle').value;
      const url = document.getElementById('bookmarkUrl').value;

      $.ajax({
         url: amadeusPath + 'user_ajax.php',
         type: 'POST',
         data: {
            action: 'add',
            title: title,
            flag:'userBookmarks',
            url: url
         },
         success: function(response) {
            if (response) {
               $.toast({
                  heading: 'موفق',
                  text: "لینک با موفقیت اضافه گردید",
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
               closeAddModal();
               setTimeout(function(){
                  window.location.reload();
               },300)
            } else {
               alert(response.message || 'خطا در ذخیره');
            }
         },
         error: function() {
            alert('خطا در ارتباط با سرور');
         }
      });

      return false;
   }

   function deleteBookmark(id) {
      if (!confirm('آیا از حذف این لینک اطمینان دارید؟')) {
         return;
      }

      $.ajax({
         url: amadeusPath + 'user_ajax.php',
         type: 'POST',
         data: {
            action: 'delete',
            flag:'userBookmarks',
            id: id
         },
         success: function(response) {
            if (response) {
               $.toast({
                  heading: 'موفق',
                  text: "لینک با موفقیت حذف گردید",
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
               closeAddModal();
               setTimeout(function(){
                  window.location.reload();
               },300)
            } else {
               alert(response.message || 'خطا در حذف');
            }
         },
         error: function() {
            alert('خطا در ارتباط با سرور');
         }
      });
   }

   // بستن مودال با کلیک روی پس‌زمینه
   document.getElementById('bookmarkModal').addEventListener('click', function(e) {
      if (e.target === this) {
         closeAddModal();
      }
   });
</script>