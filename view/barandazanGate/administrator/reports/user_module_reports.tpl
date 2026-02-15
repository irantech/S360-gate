{load_presentation_object filename="userModuleReports" assign="objModules"}

<style>
    .report-accordion {
        background: #ffff;
        border-radius: 16px;
        border: solid 1px #ccc;
        padding: 30px;
        font-family: inherit;
        direction: rtl;
        margin-top: 5px;
        margin-bottom: 30px;
        /*box-shadow: 0 10px 30px rgba(0,0,0,0.05);*/
    }

    /* آکاردئون */
    .accordion-header {
        padding: 18px 24px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 14px;
        font-weight: 700;
        font-size: 20px;
        color: #111827;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: background 0.3s, transform 0.2s;
    }
    .accordion-header:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }
    .accordion-icon {
        font-size: 24px;
        transition: transform 0.3s;
    }

    /* فیلتر */
    .filter-container {
        margin-bottom: 20px;
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    .filter-container button {
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s, color 0.3s;
    }
    .filter-container button:hover {
        background: #3b82f6;
        color: #ffffff;
    }
    .filter-container button.active {
        background: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
    }

    /* Grid ماژول‌ها */
    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    /* کارت‌ها */
    .module-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.07);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }
    .module-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
    }
    .module-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 4px;
        width: 100%;
        background: linear-gradient(90deg,#3b82f6,#2563eb);
        border-radius: 4px 4px 0 0;
    }

    /* تیتر و توضیحات */
    .module-title-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .module-title {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }
    .module-desc-short {
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #3b82f6;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
        user-select: none;
    }
    .module-desc-short:hover {
        color: #2563eb;
    }
    .module-desc {
        max-height: 0;
        overflow: hidden;
        font-size: 14px;
        color: #4b5563;
        line-height: 1.6;
        transition: max-height 0.4s ease, padding 0.4s ease;
        margin-bottom: 12px;
    }

    /* badge */
    .badge {
        padding: 5px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        display: inline-block;
        margin-top: auto;
        text-align: center;
        margin-bottom: 5px;
    }
    .badge-green {
        background: linear-gradient(135deg, #10b981, #34d399);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    .badge-red {
        background: linear-gradient(135deg, #ef4444, #f87171);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }

    /* Progress bar */
    .progress-bar-container {
        width: 100%;
        height: 6px;
        background: #e5e7eb;
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-bar {
        height: 100%;
        border-radius: 3px;
        background: linear-gradient(90deg, #10b981, #34d399);
        width: 0%;
        transition: width 0.4s ease;
    }

    .module-desc-short .icon {
        transition: transform 0.3s ease;
    }

    /* Badge جذاب خریداری شده */
    .badge-green-glow {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: #fff;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 14px;
        /*box-shadow: 0 0 12px #34d399, 0 0 24px #10b981;*/
        /*animation: glow 2s infinite alternate;*/
    }

    /* Badge جذاب خریداری نشده */
    .badge-red-glow {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: #fff;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 14px;
        /*box-shadow: 0 0 12px #ef4444, 0 0 24px #f87171;*/
        /*animation: pulse 1.5s infinite;*/
    }

    /* انیمیشن glow برای سبز */
    @keyframes glow {
        0% { box-shadow: 0 0 6px #34d399, 0 0 12px #10b981; }
        100% { box-shadow: 0 0 18px #34d399, 0 0 36px #10b981; }
    }

    /* انیمیشن pulse برای قرمز */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

</style>
<style>
    /* --- موجود (اضافه کن یا ادغام کن) --- */
    .accordion-header {
        position: relative; /* برای قرارگیری absolute آیکون */
        padding: 18px 24px;
        background: #ffffff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 14px;
        font-weight: 700;
        font-size: 20px;
        color: #111827;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: background 0.3s, transform 0.2s;
        overflow: hidden; /* تا آیکون بیرون نزنه */
    }

    /* آیکون کاپ بزرگ پشت متن */
    .accordion-header .header-cap-icon {
        position: absolute;
        left: 50%; /* چون راست‌به‌چپ، با left و translate بهتر کنترل می‌کنیم */
        top: 50%;
        transform: translate(-50%, -50%) rotate(-10deg);
        font-size: 90px;              /* اندازه آیکون پشت متن */
        line-height: 1;
        opacity: 0.06;                /* شفافیت خیلی کم تا شلوغ نکند */
        z-index: 0;                   /* پشت متن */
        pointer-events: none;         /* کلیک رو مسدود نکنه */
        color: #000000;               /* رنگ آیکون (شفافیت کنترل می‌کنه) */
    }

    /* متن و آیکون سمت راست باید بالاتر از آیکون بک‌گراند باشند */
    .accordion-header .header-text {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* آیکون کوچک (علامت −) در سمت راست باید روی متن باشد */
    .accordion-header .accordion-icon {
        position: relative;
        z-index: 1;
    }

    /* تنظیمات ریسپانسیو: برای موبایل اندازه آیکون را کوچکتر کن */
    @media (max-width: 480px) {
        .accordion-header .header-cap-icon {
            font-size: 56px;
            transform: translate(-50%, -50%) rotate(-8deg);
            opacity: 0.05;
        }
        .accordion-header { font-size: 16px; padding: 12px 16px; }
    }

    .badge {
        padding: 4px 10px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }

    .badge-green {
        background: linear-gradient(135deg, #10b981, #34d399);
    }

    .badge-red {
        background: linear-gradient(135deg, #ef4444, #f87171);
    }
    .header-trophy-icon {
        color: #ef4444; /* قرمز زیبا */
    }
    .accordion-icon i {
        color: #ef4444; /* قرمز زیبا */
    }


</style>

<div class="report-accordion">
    <div class="accordion-header" onclick="toggleAccordion(this)">
        <i class="fa-solid fa-trophy header-trophy-icon"></i>
        <div class="header-text">
            همکار محترم شما
            <span class="badge badge-green-glow">{$objModules->total_purchased_modules_count}</span>
            ماژول از
            <span class="badge badge-red-glow">{$objModules->total_modules_count}</span>
            ماژول سفر 360 را خریداری کرده‌اید
        </div>
        <span class="accordion-icon"><i class="fa-solid fa-chevron-down"></i></span>
    </div>


    <div class="report-grid-container" style="overflow: hidden; max-height: 0; transition: max-height 0.5s ease;">
    <div class="filter-container" id="filterButtons">
            <button onclick="filterModules('all', this)" class="active">همه</button>
            <button onclick="filterModules('purchased', this)">خریداری شده</button>
            <button onclick="filterModules('notPurchased', this)">خریداری نشده</button>
        </div>

        <div class="report-grid">
            {foreach from=$objModules->modules item=m}
                <div class="module-card" data-purchased="{if $m.purchased}true{else}false{/if}">
                    <div class="module-title-container">
                        <div class="module-title">{$m.title}</div>
                        <div class="module-desc-short" onclick="toggleModuleDesc(this)">
                            <span class="icon" style="font-size:22px; transform: rotate(0deg); display:inline-block;">▾</span>
                        </div>
                    </div>
                    <div class="module-desc">{$m.desc}</div>

                    {if $m.purchased}
                        <span class="badge badge-green">خریداری شده</span>
                    {else}
                        <span class="badge badge-red">خریداری نشده</span>
                    {/if}

                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {$m.progress|default:0}%"></div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>


</div>

<script>
   function toggleAccordion(el) {
      const container = el.nextElementSibling;
      const icon = el.querySelector(".accordion-icon i");

      if(container.style.maxHeight && container.style.maxHeight !== "0px") {
         container.style.maxHeight = "0";
         icon.style.transform = "rotate(0deg)"; // فلش به پایین
      } else {
         container.style.maxHeight = container.scrollHeight + "px";
         icon.style.transform = "rotate(180deg)"; // فلش به بالا
      }
   }



   function toggleModuleDesc(el) {
      const desc = el.parentElement.nextElementSibling;
      const icon = el.querySelector(".icon");

      if(desc.style.maxHeight && desc.style.maxHeight !== "0px") {
         desc.style.maxHeight = "0";
         icon.style.transform = "rotate(0deg)"; // فلش به پایین
      } else {
         desc.style.maxHeight = desc.scrollHeight + "px";
         icon.style.transform = "rotate(180deg)"; // فلش به بالا
      }
   }


   function filterModules(value, btn) {
      document.querySelectorAll('#filterButtons button').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      document.querySelectorAll('.module-card').forEach(card => {
         const purchased = card.getAttribute('data-purchased') === 'true';
         card.style.display = (value === 'all' || (value === 'purchased' && purchased) || (value === 'notPurchased' && !purchased)) ? 'flex' : 'none';
      });
   }



</script>
