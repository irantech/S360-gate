{if $item['positions']}
    {assign var="service_count" value=0}
    {foreach $item['positions'] as $service_key=>$positions}
        <div {if $service_count == 0} data-name='service' {else} data-name='added-service' {/if}
                class="bg-white d-flex flex-wrap rounded w-100 ">
            <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                <h4 class='align-items-center d-flex flex-wrap font-bold gap-10 m-0 px-4 py-3 {if $service_count != 0}  w-100 justify-content-between {/if}'>
                    {if $service_count == 0}
                        مکان نمایش
                    {else}
                        مکان نمایش {$service_count+1}
                        <button onclick="removeService($(this))"
                                type="button"
                                class="btn btn-danger font-12 rounded p-1 gap-2">
                            <span class="fa fa-trash"> </span> حذف
                        </button>
                    {/if}
                </h4>
                {if $service_count == 0}
                    <span class='btn btn-info btn-outline fa fa-question-circle font-16 ml-3 my-3 p-2 rounded-max tooltip-info'
                          data-toggle="tooltip" data-placement="top" title=""
                          data-original-title="نمایش آیتم در ابتدای نتایج جستجو"></span>
                {/if}

            </div>

            <hr class='m-0 mb-4 w-100'>
            <div class="d-flex gap-10 my-5 px-4 w-100">
                <div class="align-items-start col-md-3 col-sm-3 col-xs-3 d-flex justify-content-center p-0">
                    <div class="form-group w-100">
                        <label class="control-label" for="service1">سرویس</label>
                        <select onchange='getServicePositions($(this))' name="service[]"
                                id="service{$service_count+1}"
                                class="form-control select2">

                           {foreach $object->getServices()|@array_reverse:true as $service}
                                <option {if $service['MainService'] == $service_key}selected{/if}
                                        value="{$service['MainService']}">{$service['Title']}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class='col-md-9 d-flex flex-wrap p-0'>
                    <div data-name='positions' class='align-items-center flex-wrap w-100 d-flex justify-content-center gap-8'>

                        {assign var="position_key" value=0}


                        {foreach $positions as $selected_positions}
                            <div {if $position_key == 0} data-name='position' {else} data-name='added-position' {/if}
                                    class="w-100 d-flex  each-position  justify-content-center gap-8">


                                {if $service_key eq 'Visa'}
                                    <div class='col-sm-5 p-0 {if $route_type eq 'destination' && !$selected_position} d-none {/if}'>

                                        {assign var="exploded_selected_position" value=":"|explode:$selected_position['id']}
                                        {assign var="visa_countries" value=$object->listAllPositions($service_key)}
                                        <select name="position[{$service_key}][origin][]"
                                                id="service{$service_count}position{$position_key+1}-origin"
                                                class="form-control select2">
                                            <option value="all">همه کشور ها</option>
                                            {foreach $visa_countries['countries'] as $value=>$position}
                                                <option {if $selected_positions['origin']['id'] == $value}selected{/if}
                                                        value="{$value}">{$position.name}</option>
                                            {/foreach}
                                        </select>

                                        <select name="position[{$service_key}][Type][]"
                                                id="service{$service_count}position{$position_key+1}-type"
                                                data-test-name="visa-type"
                                                class="form-control select2">
                                            <option value="all">همه نوع ها</option>
                                            {foreach $visa_countries['types'] as $value=>$type}
                                                <option {if $selected_positions['origin']['type'] == $type.id}selected{/if}
                                                        value="{$type.id}">{$type.title}</option>
                                            {/foreach}
                                        </select>
                                    </div>


                                {else}

                                    {foreach $selected_positions as $route_type=>$selected_position}

                                        <div class='col-sm-5 p-0 {if $route_type eq 'destination' && !$selected_position} d-none {/if}'>

                                            <div class="form-group">
                                                <label class="align-items-center control-label d-flex flex-wrap justify-content-between"
                                                       for="service{$service_count}position{$position_key+1}">
                                                    {if $route_type eq 'origin'}
                                                        مبدا
                                                    {else}
                                                        مقصد
                                                    {/if}
                                                    {$position_key+1}

                                                </label>

                                                <select data-name="{$route_type}"
                                                        name="position[{$service_key}][{$route_type}][]"
                                                        id="service{$service_count}position{$position_key+1}-{$route_type}"
                                                        class="form-control  {if $service_key eq 'Hotel'} select2SearchHotel {else} select2 {/if}">
                                                    <option {if $selected_position['id'] eq 'all' }selected{/if} value="all">همه مبداء/مقاصد</option>

                                                    {if $service_key eq 'Hotel'}
                                                        <option selected
                                                                value="{$selected_position['id']}">
                                                            {$object->getHotelCity($selected_position['id'])}
                                                        </option>
                                                    {elseif $service_key eq 'contactUs'}
                                                    {else}

                                                        {foreach $object->listAllPositions($service_key) as $value=>$position}
                                                            <option {if $selected_position['id'] neq 'all' && $selected_position['id'] eq $value}selected{/if}
                                                                    value="{$value}">{$position.name}</option>
                                                        {/foreach}
                                                    {/if}


                                                </select>
                                            </div>
                                        </div>
                                    {/foreach}

                                {/if}
                            </div>
                            {assign var="position_key" value=$position_key+1}
                        {/foreach}

                    </div>

                </div>

            </div>
        </div>
        {assign var="service_count" value=$service_count+1}
    {/foreach}
{else}

    {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/modules/position/new.tpl"
    getServices=$object->getServices() object=$object}

{/if}