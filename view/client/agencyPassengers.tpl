{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="members" assign="objMember"}
{*{assign var="list_passengers" value=$objAgency->getAllPassengers($objSession->getAgencyId())}*}
{assign var="memberIdFilter" value=$smarty.post.memberId|default:0}
{assign var="list_passengers" value=$objAgency->getAllPassengers($objSession->getAgencyId(), $memberIdFilter)}
{assign var="info_member" value=$objMember->findUser($memberIdFilter)}

{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}


{*    {$smarty.post.memberId|var_dump}*}
    <div class="client-head-content w-100">
        {if $smarty.post.memberId}
            <div class="client-head-title">
                <p>
                    لیست مسافران
                     &nbsp;  {$info_member['name']} {$info_member['family']}

                </p>
            </div>
        {/if}






        <div class="row">

            <div class="col-lg-12">

                <div id="passengersAgency_wrapper" class="dataTables_wrapper no-footer">
                    <table id="passengersAgency" class="table table-sm dataTable no-footer" role="grid" aria-describedby="passengersAgency_info" >
                        <thead>
                        <tr role="row">
                            <th scope="col" class="text-center">ردیف</th>
                            <th scope="col" class="text-center">نام و نام خانوادگی</th>
                            <th scope="col" class="text-center d-none d-md-table-cell">تاریخ تولد</th>
                            <th scope="col" class="text-center">کد ملی</th>
                            <th scope="col" class="text-center d-none d-md-table-cell">شماره پاسپورت</th>
                            <th scope="col" class="text-center">نوع مسافر</th>
                            {if !$smarty.post.memberId}
                            <th scope="col" class="text-center">کانتر</th>
                            {/if}
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="counter" value=1}
                        {foreach from=$list_passengers item=passenger}
                            <tr role="row" {if $counter % 2 == 0}class="even"{else}class="odd"{/if}>
                                <td class="text-center">{$counter}</td>
                                <td>
                                    <div class="passenger-name-container text-center">
                                        {* نمایش نام فارسی *}
                                        {if $passenger.passengerName neq '' || $passenger.passengerFamily neq ''}
                                            <div class="persian-name fw-bold">
                                                {$passenger.passengerName} {$passenger.passengerFamily}
                                            </div>
                                        {/if}

                                        {* نمایش نام انگلیسی *}
                                        {if $passenger.passengerNameEn neq '' || $passenger.passengerFamilyEn neq ''}
                                            <div class="english-name text-muted small mt-1">
                                                {$passenger.passengerNameEn} {$passenger.passengerFamilyEn}
                                            </div>
                                        {/if}

                                        {* اگر هیچ نامی وجود ندارد *}
                                        {if ($passenger.passengerName eq '' && $passenger.passengerFamily eq '' && $passenger.passengerNameEn eq '' && $passenger.passengerFamilyEn eq '')}
                                            <span class="text-muted">-</span>
                                        {/if}
                                    </div>
                                </td>
                                <td class="text-center d-none d-md-table-cell">
                                    <div class="birthday-container">
                                        {* تاریخ تولد شمسی *}
                                        {if $passenger.passengerBirthdayFa neq '' && $passenger.passengerBirthdayFa neq '0000-00-00'}
                                            <div class="persian-date text-primary">
                                                {$passenger.passengerBirthdayFa}
                                            </div>
                                        {/if}

                                        {* تاریخ تولد میلادی *}
                                        {if $passenger.passengerBirthday neq '' && $passenger.passengerBirthday neq '0000-00-00'}
                                            <div class="english-date text-muted small mt-1">
                                                {$passenger.passengerBirthday}
                                            </div>
                                        {/if}

                                        {* اگر هیچ تاریخی وجود ندارد *}
                                        {if ($passenger.passengerBirthdayFa eq '' || $passenger.passengerBirthdayFa eq '0000-00-00') && ($passenger.passengerBirthday eq '' || $passenger.passengerBirthday eq '0000-00-00')}
                                            <span class="text-muted">-</span>
                                        {/if}
                                    </div>
                                </td>
                                <td class="text-center">
                                    {if $passenger.nationalCode neq ''}
                                        <span class="national-code-badge">{$passenger.nationalCode}</span>
                                    {else}
                                        <span class="text-muted">-</span>
                                    {/if}
                                </td>
                                <td class="text-center d-none d-md-table-cell">
                                    {if $passenger.passportNumber neq ''}
                                        <span class="passport-number">{$passenger.passportNumber}</span>
                                    {else}
                                        <span class="text-muted">-</span>
                                    {/if}
                                </td>
                                <td class="text-center">
                                    {if $passenger.isForeign == 1}
                                        <span class="badge bg-primary text-white border-0 px-3 py-2">خارجی</span>
                                    {else}
                                        <span class="badge bg-success text-white border-0 px-3 py-2">ایرانی</span>
                                    {/if}
                                </td>
                                {if !$smarty.post.memberId}
                                <td class="text-center">
                                    <div class="counter-info">
                                        <span class="counter-name fw-semibold">{$passenger.counterName} {$passenger.counterFamily}</span>
                                    </div>
                                </td>
                                {/if}
                            </tr>
                            {assign var="counter" value=$counter+1}
                            {foreachelse}
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">
                                    <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                    هیچ مسافری یافت نشد
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>


{literal}


    <script>
       $(document).ready(function() {
          $('#passengersAgency').DataTable({
             "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json"
             },
             "pageLength": 10,
             "ordering": true,
             "searching": true
          });
       });
    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}