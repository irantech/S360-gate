{load_presentation_object filename="reportAgenciesSearch" assign="objLimits"}
{assign var=agencyLimit value=$objLimits->limitExceedAgency()}

{if $agencyLimit}

    {if $agencyLimit.flight_type == 'internal'}
        {assign var=flightTitle value='سرچ داخلی'}
    {elseif $agencyLimit.flight_type == 'international'}
        {assign var=flightTitle value='سرچ خارجی'}
    {elseif $agencyLimit.flight_type == 'both'}
        {assign var=flightTitle value='سرچ داخلی و خارجی'}
    {/if}

    <style>
        .agency-limit-alert {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 14px;
            padding: 14px 16px;
            margin: 20px 0;
            overflow: hidden;
        }

        .agency-limit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px 12px;
        }

        .agency-limit-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #9a3412;
        }

        .agency-limit-title i {
            color: #ea580c;
            font-size: 18px;
        }

        .agency-limit-toggle {
            font-size: 14px;
            color: #6b7280;
            transition: transform 0.3s ease;
        }

        .agency-limit-toggle.rotated {
            transform: rotate(180deg);
        }

        .agency-limit-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            padding: 0 12px;
        }

        .agency-limit-content.expanded {
            margin-top: 10px;
            padding-bottom: 12px;
        }

        .agency-limit-text {
            font-size: 13px;
            color: #7c2d12;
            line-height: 1.8;
        }
    </style>

    <div class="agency-limit-alert">
        <div class="agency-limit-header" onclick="toggleAgencyLimit()">
            <div class="agency-limit-title">
                <i class="fa fa-exclamation-circle"></i>
                <span>شما به دلیل زیر با محدودیت ({$flightTitle}) lookToBook مواجه شدید</span>
            </div>
            <i class="fa fa-chevron-down agency-limit-toggle" id="agencyLimitToggleIcon"></i>
        </div>

        <div class="agency-limit-content expanded" id="agencyLimitContent">
            <div class="agency-limit-text">
                بر اساس استاندارد بین‌المللی، در سرچ‌های داخلی به ازای هر
                <strong>50</strong> بار سرچ و در سرچ‌های خارجی به ازای هر
                <strong>50</strong> بار سرچ، باید حداقل یک خرید انجام شود.
                <br>
                در غیر این صورت، تا ساعت <strong>۲۴</strong> همان روز
                موتور جستجو هیچ پاسخی نخواهد داد.

            </div>
        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
          const content = document.getElementById('agencyLimitContent');
          const icon = document.getElementById('agencyLimitToggleIcon');

          // پیش‌فرض باز
          content.style.maxHeight = content.scrollHeight + 'px';
          content.classList.add('expanded');
          icon.classList.add('rotated');
       });

       function toggleAgencyLimit() {
          const content = document.getElementById('agencyLimitContent');
          const icon = document.getElementById('agencyLimitToggleIcon');

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
    </script>

{/if}
