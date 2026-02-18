{load_presentation_object filename="reportAgenciesSearch" assign="objLimits"}
{$objLimits->limitExceedAgencies()}

<style>
    .limits-wrapper {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px;
        margin: 20px 0;
        border: solid 1px #ccc;
    }

    .limits-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: #ffffff;
        border-radius: 12px;
        cursor: pointer;
    }

    .limits-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 600;
        color: #111827;
    }

    .limits-title i {
        color: #dc2626;
        font-size: 18px;
    }

    .limits-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        margin-top: 0;
    }

    .limits-content.expanded {
        margin-top: 16px;
    }

    .limits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
    }

    .limit-card {
        position: relative;
        background: #f9fafb;
        border-radius: 12px;
        padding: 14px 16px;
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.25s ease;
        border-right: 4px solid #dc2626;
    }

    .limit-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    .limit-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .limit-card-type {
        font-size: 13px;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .limit-badge {
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 999px;
        font-weight: 500;
    }

    .badge-internal {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-international {
        background: #ffedd5;
        color: #c2410c;
    }

    .badge-both {
        background: #ede9fe;
        color: #6d28d9;
    }

    /* new position for remove button */
    .remove-limit-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ef4444;
        color: #fff;
        border: none;
        padding: 6px 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-limit-btn:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .empty-limits {
        text-align: center;
        padding: 36px 20px;
        color: #9ca3af;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .limits-grid {
            grid-template-columns: 1fr;
        }
    }

    .limits-toggle-icon {
        font-size: 14px;
        color: #6b7280;
        transition: transform 0.3s ease;
    }

    .limits-toggle-icon.rotated {
        transform: rotate(180deg);
    }

    /* Modal */
    .limit-modal {
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

    .limit-modal.active {
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
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
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

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit {
        flex: 1;
        background: #ef4444;
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
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
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
</style>

<div class="limits-wrapper">
    <div class="limits-header" onclick="toggleLimits()">
        <div class="limits-title">
            <i class="fa fa-exclamation-triangle"></i>
            <span>آژانس‌هایی که به لیمیت سرچ پرواز رسیده‌اند</span>
        </div>

        <i class="fa fa-chevron-down limits-toggle-icon" id="limitsToggleIcon"></i>
    </div>

    <div class="limits-content" id="limitsContent">
        {if $objLimits->agencyLimits}
            <div class="limits-grid">
                {foreach from=$objLimits->agencyLimits item=limit}
                    {if $limit.flight_type == 'internal'}
                        {assign var=flightTitle value='لیمت سرچ داخلی'}
                        {assign var=badgeClass value='badge-internal'}
                    {elseif $limit.flight_type == 'international'}
                        {assign var=flightTitle value='لیمت سرچ خارجی'}
                        {assign var=badgeClass value='badge-international'}
                    {elseif $limit.flight_type == 'both'}
                        {assign var=flightTitle value='لیمت سرچ داخلی و خارجی'}
                        {assign var=badgeClass value='badge-both'}
                    {/if}

                    <div class="limit-card">
                        <button class="remove-limit-btn" onclick="event.stopPropagation(); openRemoveModal({$limit.agency_id})">
                            برداشتن لیمیت
                        </button>

                        <div class="limit-card-title">{$limit.agency_name}</div>
                        <div class="limit-card-type">
                            <span class="limit-badge {$badgeClass}">{$flightTitle}</span>
                        </div>
                    </div>
                {/foreach}
            </div>
        {else}
            <div class="empty-limits">
                هیچ آژانسی در حال حاضر به لیمیت سرچ نخورده است
            </div>
        {/if}
    </div>
</div>

<!-- Modal -->
<div class="limit-modal" id="limitModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>آیا مطمئنید؟</h3>
            <button class="modal-close" onclick="closeRemoveModal()">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <p>
            آیا مطمئنید می‌خواهید لیمیت این پروایدر برداشته شود؟
        </p>

        <div class="modal-actions">
            <button class="btn-submit" onclick="confirmRemoveLimit()">موافقم</button>
            <button class="btn-cancel" onclick="closeRemoveModal()">انصراف</button>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
      const content = document.getElementById('limitsContent');
      const icon = document.getElementById('limitsToggleIcon');

      content.style.maxHeight = content.scrollHeight + 'px';
      content.classList.add('expanded');
      icon.classList.add('rotated');
   });

   function toggleLimits() {
      const content = document.getElementById('limitsContent');
      const icon = document.getElementById('limitsToggleIcon');

      if (content.classList.contains('expanded')) {
         content.style.maxHeight = '0px';
         content.classList.remove('expanded');
         icon.classList.remove('rotated');
      } else {
         content.classList.add('expanded');
         content.style.maxHeight = content.scrollHeight + 'px';
         icon.classList.add('rotated');
      }
   }

   // ===========================
   // Modal Remove Limit
   // ===========================
   let selectedAgencyId = null;

   function openRemoveModal(agencyId) {
      selectedAgencyId = agencyId;
      document.getElementById('limitModal').classList.add('active');
   }

   function closeRemoveModal() {
      document.getElementById('limitModal').classList.remove('active');
      selectedAgencyId = null;
   }

   function confirmRemoveLimit() {
      if (!selectedAgencyId) return;

      $.ajax({
         url: amadeusPath + 'user_ajax.php',
         type: 'POST',
         data: {
            flag: 'remove_agency_search_limit',
            agency_id: selectedAgencyId
         },
         success: function(response) {
            if (response) {
               $.toast({
                  heading: 'موفق',
                  text: "لیمیت با موفقیت برداشته شد",
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
               closeRemoveModal();
               setTimeout(function(){
                  window.location.reload();
               },300)
            } else {
               alert(response.message || 'خطا در حذف لیمیت');
            }
         },
         error: function() {
            alert('خطا در ارتباط با سرور');
         }
      });
   }

   // بستن مودال با کلیک روی پس‌زمینه
   document.getElementById('limitModal').addEventListener('click', function(e) {
      if (e.target === this) {
         closeRemoveModal();
      }
   });
</script>
