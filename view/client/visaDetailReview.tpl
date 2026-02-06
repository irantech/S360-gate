{load_presentation_object filename="visa" assign="objVisa"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="visaInfo" value=$objVisa->getVisaByFactorNumber($smarty.get.factor_number)}

<div id="accordion" class="mb-4">
    {foreach $visaInfo as $passenger_key=>$passenger}
    {assign var="country_code" value=$objFunctions->country_code($passenger.passenger_country,$smarty.const.SOFTWARE_LANG)}
        {*{assign var="passenger_data" value=[
        '##Sex##'=>$passenger.passenger_gender,
        '##Name##'=>$passenger.passenger_name,
        '##Nation##'=>$country_code,
        '##Family##'=>$passenger.passenger_family,
        '##Nameenglish##'=>$passenger.passenger_name_en,
        '##Familyenglish##'=>$passenger.passenger_family_en,
        '##shamsihappybirthday##'=>$passenger.passenger_birthday,
        '##miladihappybirthday##'=>$passenger.passenger_birthday_en,
        '##Nationalnumber##'=>$passenger.passenger_national_code,
        '##Numpassport##'=>$passenger.passport_number,
        '##Passportexpirydate##'=>$passenger.passport_expire,
        '##Destination##'=>$passenger.visa_destination_code,
        '##Typevisa##'=>$passenger.visa_type,
        '##PhonenumberTraveler##'=>$passenger.member_mobile,
        '##Email##'=>$passenger.member_email,
        '##Mobilephonebuyer##'=>$passenger.mobile_buyer,
        '##Emailbuyer##'=>$passenger.email_buyer,
        '##Nameagency##'=>$passenger.agency_name,
        '##Titlevisa##'=>$passenger.visa_title,
        '##Status##'=>$passenger.status,
        '##DateOfPayment##'=>$passenger.payment_date,
        '##DateOfLastUpdate##'=>$passenger.last_edit
        ]}*}

        <div class="card">
            <div class="card-header p-0" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn w-100 p-3 btn-link" data-toggle="collapse" data-target="#collapse{$passenger_key}" aria-expanded="false" aria-controls="collapse{$passenger_key}">
                        اطلاعات مسافر :  {$passenger.passenger_name}
                    </button>
                </h5>
            </div>
            <div id="collapse{$passenger_key}" class="collapse" aria-labelledby="heading{$passenger_key}" data-parent="#accordion">
                <div class="card-body">

                    <table class="table table-sm bg-white table-striped">

                        <tbody class="text-center">

                        {*{foreach $passenger_data as $data_key=>$data}
                            <tr>
                                <th scope="row">{$data_key}</th>
                                <td>{$data}</td>
                            </tr>
                        {/foreach}*}

                        {assign var="custom_file_fields" value=json_decode($passenger.main_custom_file_fields,true)}

                        {foreach $custom_file_fields as $field_key=>$field}
                            {foreach $field as $name=>$src}
                                <tr>
                                    <th scope="row">{$name}</th>
                                    <td>
                                        {if $src neq ''}
                                            <img style="width: 150px;"
                                                 src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/visaPassengersFiles/{$src}"
                                                 alt="{$name}">
                                            <a class="text-primary" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/visaPassengersFiles/{$src}" target="_blank">
                                                دانلود
                                            </a>
                                        {else}
                                            عکسی آپلود نشده بود
                                        {/if}
                                        {if $smarty.const.TYPE_ADMIN eq '1'}
                                            <input type="file" name="">
                                            <a class="btn btn-primary" href=""></a>
                                        {/if}
                                    </td>

                                </tr>
                            {/foreach}
                        {/foreach}


                        {assign var="visa_files" value=$passenger.visa_files}

                        <tr class="bg-info text-white">
                            <th scope="row">visa_files</th>
                            <td>
                                {if $visa_files neq ''}
                                    <img style="width: 150px;"
                                         src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/visaPassengersFiles/{$visa_files}"
                                         alt="visa_files">
                                    <a class="text-white" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/visaPassengersFiles/{$visa_files}" target="_blank">
                                        دانلود
                                    </a>
                                {else}
                                    عکسی آپلود نشده بود
                                {/if}
                            </td>

                        </tr>


                        </tbody>
                    </table>
            </div>
        </div>



    {/foreach}
</div>
</div>


<script type="text/javascript" src="assets/js/customForVisa.js"></script>
