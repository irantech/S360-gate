{load_presentation_object filename="reservationTour" assign="objResult"}

{assign var="changeTourPricesLogs" value=$objResult->getChangeTourPricesLogs($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت تور رزرواسیون</li>
                <li><a href="reportTour">گزارش تور</a></li>
                <li class="active">تغییرات قیمت تور</li>
            </ol>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">تغییرات قیمت تور <a href="detailTour&id={$changeTourPricesLogs[0]['fk_tour_id_same']}">
                        {$changeTourPricesLogs[0]['tour_name']}  ({$changeTourPricesLogs[0]['tour_code']})</a></h3>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ و ساعت ثبت</th>
                            <th>تغییر قیمت</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$changeTourPricesLogs}
                            {$number=$number+1}

                            {assign var="oldPrice" value=$item['old_price']|json_decode:true}
                            {assign var="newPrice" value=$item['new_price']|json_decode:true}

                            <tr id="del-{$item['id']}">
                                <td id="borderFlyNumber-{$item['id']}">{$number}</td>

                                <td>
                                    {$item['create_date_in']} <hr> {$item['create_time_in']}
                                </td>

                                {if $item['flag_one_day_tour'] eq 'yes'}

                                    <td>
                                        <ul class="list-group">
                                            {if $oldPrice['adult_price_one_day_tour_r'] neq $newPrice['adult_price_one_day_tour_r']}
                                                <li class="list-group-item"> قیمت بزرگسال (ریالی): <i>{$oldPrice['adult_price_one_day_tour_r']}</i> --->  <i>{$newPrice['adult_price_one_day_tour_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['child_price_one_day_tour_r'] neq $newPrice['child_price_one_day_tour_r']}
                                                <li class="list-group-item"> قیمت کودک (ریالی): <i>{$oldPrice['child_price_one_day_tour_r']}</i> --->  <i>{$newPrice['child_price_one_day_tour_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_price_one_day_tour_r'] neq $newPrice['infant_price_one_day_tour_r']}
                                                <li class="list-group-item"> قیمت نوزاد (ریالی): <i>{$oldPrice['infant_price_one_day_tour_r']}</i> --->  <i>{$newPrice['infant_price_one_day_tour_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['adult_price_one_day_tour_a'] neq $newPrice['adult_price_one_day_tour_a']}
                                                <li class="list-group-item"> قیمت بزرگسال (ارزی): <i>{$oldPrice['adult_price_one_day_tour_a']}</i> --->  <i>{$newPrice['adult_price_one_day_tour_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['child_price_one_day_tour_a'] neq $newPrice['child_price_one_day_tour_a']}
                                                <li class="list-group-item"> قیمت کودک (ارزی): <i>{$oldPrice['child_price_one_day_tour_a']}</i> --->  <i>{$newPrice['child_price_one_day_tour_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_price_one_day_tour_a'] neq $newPrice['infant_price_one_day_tour_a']}
                                                <li class="list-group-item"> قیمت نوزاد (ارزی): <i>{$oldPrice['infant_price_one_day_tour_a']}</i> --->  <i>{$newPrice['infant_price_one_day_tour_a']}</i></li>
                                            {/if}
                                        </ul>
                                    </td>

                                {else}

                                    <td>
                                        <ul class="list-group list-log-tour-prices">
                                            {if $oldPrice['three_room_price_r'] neq $newPrice['three_room_price_r']}
                                                <li class="list-group-item"> قیمت سه تخته(ریالی): <i>{$oldPrice['three_room_price_r']}</i> --->  <i>{$newPrice['three_room_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['three_room_price_a'] neq $newPrice['three_room_price_a']}
                                                <li class="list-group-item"> قیمت سه تخته(ارزی): <i>{$oldPrice['three_room_price_a']}</i> --->  <i>{$newPrice['three_room_price_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['double_room_price_r'] neq $newPrice['double_room_price_r']}
                                                <li class="list-group-item"> قیمت دو تخته(ریالی): <i>{$oldPrice['double_room_price_r']}</i> --->  <i>{$newPrice['double_room_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['double_room_price_a'] neq $newPrice['double_room_price_a']}
                                                <li class="list-group-item"> قیمت دو تخته(ارزی): <i>{$oldPrice['double_room_price_a']}</i> --->  <i>{$newPrice['double_room_price_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['single_room_price_r'] neq $newPrice['single_room_price_r']}
                                                <li class="list-group-item"> قیمت یک تخته(ریالی): <i>{$oldPrice['single_room_price_r']}</i> --->  <i>{$newPrice['single_room_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['single_room_price_a'] neq $newPrice['single_room_price_a']}
                                                <li class="list-group-item"> قیمت یک تخته(ارزی): <i>{$oldPrice['single_room_price_a']}</i> --->  <i>{$newPrice['single_room_price_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['child_with_bed_price_r'] neq $newPrice['child_with_bed_price_r']}
                                                <li class="list-group-item"> کودک با تخت(ریالی): <i>{$oldPrice['child_with_bed_price_r']}</i> --->  <i>{$newPrice['child_with_bed_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['child_with_bed_price_a'] neq $newPrice['child_with_bed_price_a']}
                                                <li class="list-group-item"> کودک با تخت(ارزی): <i>{$oldPrice['child_with_bed_price_a']}</i> --->  <i>{$newPrice['child_with_bed_price_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_without_bed_price_r'] neq $newPrice['infant_without_bed_price_r']}
                                                <li class="list-group-item"> کودک بدون تخت(ریالی): <i>{$oldPrice['infant_without_bed_price_r']}</i> --->  <i>{$newPrice['infant_without_bed_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_without_bed_price_a'] neq $newPrice['infant_without_bed_price_a']}
                                                <li class="list-group-item"> کودک بدون تخت(ارزی): <i>{$oldPrice['infant_without_bed_price_a']}</i> --->  <i>{$newPrice['infant_without_bed_price_a']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_without_chair_price_r'] neq $newPrice['infant_without_chair_price_r']}
                                                <li class="list-group-item"> نوزاد(ریالی): <i>{$oldPrice['infant_without_chair_price_r']}</i> --->  <i>{$newPrice['infant_without_chair_price_r']}</i></li>
                                            {/if}
                                            {if $oldPrice['infant_without_chair_price_a'] neq $newPrice['infant_without_chair_price_a']}
                                                <li class="list-group-item"> نوزاد(ارزی): <i>{$oldPrice['infant_without_chair_price_a']}</i> --->  <i>{$newPrice['infant_without_chair_price_a']}</i></li>
                                            {/if}
                                        </ul>
                                    </td>

                                {/if}


                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>