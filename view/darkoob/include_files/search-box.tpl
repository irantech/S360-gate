{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
{if $page.files.main_file}
    {$banners = [0 => ['pic' => $page.files.main_file.src , 'title' => 'page']]}
{/if}

<section class="i_modular_banner_gallery position-relative">
    <div class="banner-demo ">
        <div class="container h-100">
            <div class="parent-data-demo banner-safiran" id="bg-banner-demo">
{*                <div id="particles-js"></div>*}
                {*    <div id="large-header" class="large-header">*}
                {*        <canvas id="demo-canvas" width="1280" height="840"></canvas>*}
                {*    </div>*}
                <div class="parent-text-banner-demo">
                    <h2 id="title-banner">دارکوب 724 مرکز رزرواسیون هتل های داخلی و خارجی</h2>
                    <p id="caption-banner">

{*                        برای خرید آنلاین تو و هتل در سفرهای دارکوب ایرانیان کافیست مبدا، مقصد و تاریخ  خود را انتخاب کنید.*}

                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="search_box container">
        <div class="i_modular_searchBox search_box_div">
            <ul class="__search_box_tabs__ nav"
                id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
            <div class="__search_boxes__ tab-content"
                 id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
        </div>
    </div>
</section>
{include file="include_files/banner-slider.tpl"}
{if $smarty.const.GDS_SWITCH eq 'page'}
<script>
    {literal}
   if (window.innerWidth <= 576) {
      const openSheetButton = document.querySelectorAll('.sheet-js');
      const closeSheetButton = document.getElementById('closeSheet');
      const bottomSheet = document.getElementById('bottomSheet');
      const overlay = document.getElementById('overlay');
      const handle = document.querySelector('.handle');

      // تغییر اصلی: نمایش فوتر شیت در هنگام لود صفحه
      window.addEventListener('DOMContentLoaded', () => {
         bottomSheet.style.transform = 'translateY(0)';
         bottomSheet.classList.add('open');
         overlay.classList.add('active');
         document.body.classList.add('no-scroll');
      });

      // Open bottom sheet
      openSheetButton.forEach(tab => {
         tab.addEventListener('click', () => {
            // Reset transform before adding open class
            bottomSheet.style.transform = 'translateY(100%)';
            // Use setTimeout to ensure the initial transform is applied before transition
            setTimeout(() => {
               bottomSheet.style.transform = 'translateY(0)';
               bottomSheet.classList.add('open');
               overlay.classList.add('active');
               document.body.classList.add('no-scroll');
            }, 10);
         });
      });

      // Close bottom sheet with X button
      closeSheetButton.addEventListener('click', closeBottomSheet);

      // Close bottom sheet with overlay
      overlay.addEventListener('click', closeBottomSheet);

      function closeBottomSheet() {
         bottomSheet.classList.remove('open');
         overlay.classList.remove('active');
         document.body.classList.remove('no-scroll');
         bottomSheet.style.transform = 'translateY(100%)';
         currentTranslateY = 0; // Reset the translation tracking
      }

      // Drag functionality
      let isDragging = false;
      let startY, startTranslateY;
      let currentTranslateY = 0;

      handle.addEventListener('mousedown', (e) => {
         isDragging = true;
         startY = e.clientY;
         startTranslateY = getTranslateY(bottomSheet);
         document.addEventListener('mousemove', onMouseMove);
         document.addEventListener('mouseup', onMouseUp);
      });

      handle.addEventListener('touchstart', (e) => {
         isDragging = true;
         startY = e.touches[0].clientY;
         startTranslateY = getTranslateY(bottomSheet);
         document.addEventListener('touchmove', onTouchMove);
         document.addEventListener('touchend', onTouchEnd);
      });

      function onMouseMove(e) {
         if (!isDragging) return;
         const deltaY = e.clientY - startY;
         const newTranslateY = startTranslateY + deltaY;
         if (newTranslateY >= 0) {
            currentTranslateY = newTranslateY;
            bottomSheet.style.transform = `translateY(${newTranslateY}px)`;
         }
      }

      function onMouseUp() {
         if (!isDragging) return;
         isDragging = false;
         document.removeEventListener('mousemove', onMouseMove);
         document.removeEventListener('mouseup', onMouseUp);
         snapBottomSheet();
      }

      function onTouchMove(e) {
         if (!isDragging) return;
         const deltaY = e.touches[0].clientY - startY;
         const newTranslateY = startTranslateY + deltaY;
         if (newTranslateY >= 0) {
            currentTranslateY = newTranslateY;
            bottomSheet.style.transform = `translateY(${newTranslateY}px)`;
         }
      }

      function onTouchEnd() {
         if (!isDragging) return;
         isDragging = false;
         document.removeEventListener('touchmove', onTouchMove);
         document.removeEventListener('touchend', onTouchEnd);
         snapBottomSheet();
      }

      // Modified snap function to only allow fully open or closed states
      function snapBottomSheet() {
         const sheetHeight = bottomSheet.offsetHeight;
         const dragThreshold = sheetHeight * 0.3; // 30% of sheet height as threshold

         if (currentTranslateY > dragThreshold) {
            // If dragged more than threshold, close the sheet
            closeBottomSheet();
         } else {
            // If dragged less than threshold, snap back to fully open
            bottomSheet.style.transform = 'translateY(0)';
            currentTranslateY = 0; // Reset the translation tracking
         }
      }

      function getTranslateY(element) {
         const style = window.getComputedStyle(element);
         const transform = style.transform;
         if (transform === 'none') return 0;
         const matrix = transform.match(/matrix.*\((.+)\)/)[1].split(', ');
         return parseFloat(matrix[5] || matrix[13]);
      }
   }
    {/literal}
</script>
{/if}


