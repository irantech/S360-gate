{load_presentation_object filename="representatives" assign="obJRepresentatives"}
{assign var="list_representatives" value=$obJRepresentatives->listRepresentatives('client')}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}
{assign var="selected_countries" value=$obJRepresentatives->selected_countries()}


<section class="agencyList">
    {if $selected_provinces or $selected_countries}
        <div class="link">
            <a href="{$smarty.const.ROOT_ADDRESS}/requestAgent">
                ##NasimBeheshtAgent##
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M166.5 424.5l-143.1-152c-4.375-4.625-6.562-10.56-6.562-16.5c0-5.938 2.188-11.88 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.9375c9.688 9.125 10.03 24.38 .9375 33.94l-128.4 135.5l128.4 135.5c9.094 9.562 8.75 24.75-.9375 33.94C190.9 434.5 175.7 434.1 166.5 424.5z"/></svg>
            </a>
        </div>
        {foreach $selected_countries as $country}
            {assign var="selected_provinces" value=$obJRepresentatives->selected_provinces($country.id)}
            {if  $selected_provinces}
                <div class="agencyList-tab mb-4">
                    <h3 class='country-header'>
                        {if  $smarty.const.SOFTWARE_LANG neq 'fa'}
                            {$country['name_en']}
                        {else}
                            {$country['name']}
                        {/if}
                    </h3>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        {assign var="counter" value=0}
                        {foreach $selected_provinces as  $item}
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {if $counter == 0}  active {/if}"
                                        id="province{$item.id}-tab"
                                        data-toggle="pill"
                                        data-target="#province{$item.id}"
                                        type="button"
                                        role="tab"
                                        aria-controls="province{$item.id}"
                                        aria-selected="true">
                                    {if  $smarty.const.SOFTWARE_LANG neq 'fa'}
                                        {$item['name_en']}
                                    {else}
                                        {$item['name']}
                                    {/if}
                                </button>
                            </li>
                            {$counter = $counter + 1}
                        {/foreach}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        {assign var="counter" value=0}
                        {foreach $selected_provinces as  $item}
                            <div class="tab-pane fade{if $counter == 0} show  active {/if}"
                                 id="province{$item.id}"
                                 role="tabpanel"
                                 aria-labelledby="province{$item.id}-tab">
                                <div class="agencyList-box">
                                    {foreach $list_representatives as $agency}
                                        {if $agency['province'] == $item.id}
                                            <div class="agencyList-box-card">
                                                <div class="agencyList-box-card-img">
                                                    <img src="{$agency['image']}" alt="alt">
                                                </div>
                                                <h2>{$agency['company_name']}</h2>
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M1.359 380.1l21.06 91.34c5.469 23.84 26.44 40.53 50.1 40.53C315.3 511.1 512 315.3 512 73.39c0-24.56-16.7-45.53-40.61-50.98l-91.25-21.06c-24.53-5.672-49.72 6.984-59.87 30.19l-42.25 98.56c-9.078 21.34-2.891 46.42 15.02 61.05l33.55 27.48c-25.75 44.75-63.26 82.25-108 107.1L191.1 293.1C176.5 275.1 151.3 268.9 129.9 278.2l-98.2 42.08C8.39 330.3-4.36 355.5 1.359 380.1zM48.12 369.3c-.4531-1.969 .6562-4.156 2.531-4.969l98.26-42.09c1.734-.8125 3.812-.2813 4.922 1.125l40.01 48.87c7.062 8.625 19.16 11.25 29.16 6.344c67.28-33.03 122.5-88.25 155.5-155.5c4.906-9.1 2.281-22.08-6.344-29.14l-48.78-39.97c-1.5-1.234-1.1-3.297-1.25-5.062l42.14-98.33c.6875-1.562 2.312-2.609 4.047-2.609c.3125 0 .6406 .0313 .9531 .1094l91.34 21.08c2.047 .4687 3.344 2.109 3.344 4.203c0 215.4-175.2 390.6-390.6 390.6c-2.109 0-3.75-1.281-4.219-3.281L48.12 369.3z"/></svg>
                                                    <span>
                                            {$agency['phone_number']}
                                        </span>
                                                </p>
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352 432h32c8.875 0 16-7.125 16-16v-32c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C336 424.9 343.1 432 352 432zM352 336h32c8.875 0 16-7.125 16-16V288c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C336 328.9 343.1 336 352 336zM256 336h32c8.875 0 16-7.125 16-16V288c0-8.875-7.125-16-16-16h-32C247.1 272 240 279.1 240 288v32C240 328.9 247.1 336 256 336zM464 192H176L175.1 48h222.1L432 81.94V160H480V81.94c0-12.73-5.057-24.94-14.06-33.94l-33.94-33.94C423 5.057 410.8 0 398.1 0H175.1c-26.51 0-48 21.49-48 48l.0059 82.26C122.9 128.9 117.6 128 112 128H64C28.65 128 0 156.7 0 192v256c0 35.35 28.65 64 64 64h400c26.47 0 48-21.53 48-48v-224C512 213.5 490.5 192 464 192zM128 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V192c0-8.822 7.178-16 16-16h48C120.8 176 128 183.2 128 192V448zM464 464H173.7C175.1 458.9 176 453.6 176 448V240h288V464zM256 432h32c8.875 0 16-7.125 16-16v-32c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C240 424.9 247.1 432 256 432z"></path></svg>
                                                    <span>
                                            {$agency['fax_number']}
                                        </span>
                                                </p>
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z"/></svg>
                                                    <span>
                                            {$agency['address']}
                                        </span>
                                                </p>
                                                <div class="socialMedia">
                                                    {if $agency['mobile_number']}
                                                        <a href="tel:{$agency['mobile_number']}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M1.359 380.1l21.06 91.34c5.469 23.84 26.44 40.53 50.1 40.53C315.3 511.1 512 315.3 512 73.39c0-24.56-16.7-45.53-40.61-50.98l-91.25-21.06c-24.53-5.672-49.72 6.984-59.87 30.19l-42.25 98.56c-9.078 21.34-2.891 46.42 15.02 61.05l33.55 27.48c-25.75 44.75-63.26 82.25-108 107.1L191.1 293.1C176.5 275.1 151.3 268.9 129.9 278.2l-98.2 42.08C8.39 330.3-4.36 355.5 1.359 380.1zM48.12 369.3c-.4531-1.969 .6562-4.156 2.531-4.969l98.26-42.09c1.734-.8125 3.812-.2813 4.922 1.125l40.01 48.87c7.062 8.625 19.16 11.25 29.16 6.344c67.28-33.03 122.5-88.25 155.5-155.5c4.906-9.1 2.281-22.08-6.344-29.14l-48.78-39.97c-1.5-1.234-1.1-3.297-1.25-5.062l42.14-98.33c.6875-1.562 2.312-2.609 4.047-2.609c.3125 0 .6406 .0313 .9531 .1094l91.34 21.08c2.047 .4687 3.344 2.109 3.344 4.203c0 215.4-175.2 390.6-390.6 390.6c-2.109 0-3.75-1.281-4.219-3.281L48.12 369.3z"/></svg>
                                                        </a>
                                                    {/if}
                                                    {if $agency['fax_number']}
                                                        <a href="tel:{$agency['fax_number']};fax=true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M352 432h32c8.875 0 16-7.125 16-16v-32c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C336 424.9 343.1 432 352 432zM352 336h32c8.875 0 16-7.125 16-16V288c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C336 328.9 343.1 336 352 336zM256 336h32c8.875 0 16-7.125 16-16V288c0-8.875-7.125-16-16-16h-32C247.1 272 240 279.1 240 288v32C240 328.9 247.1 336 256 336zM464 192H176L175.1 48h222.1L432 81.94V160H480V81.94c0-12.73-5.057-24.94-14.06-33.94l-33.94-33.94C423 5.057 410.8 0 398.1 0H175.1c-26.51 0-48 21.49-48 48l.0059 82.26C122.9 128.9 117.6 128 112 128H64C28.65 128 0 156.7 0 192v256c0 35.35 28.65 64 64 64h400c26.47 0 48-21.53 48-48v-224C512 213.5 490.5 192 464 192zM128 448c0 8.822-7.178 16-16 16H64c-8.822 0-16-7.178-16-16V192c0-8.822 7.178-16 16-16h48C120.8 176 128 183.2 128 192V448zM464 464H173.7C175.1 458.9 176 453.6 176 448V240h288V464zM256 432h32c8.875 0 16-7.125 16-16v-32c0-8.875-7.125-16-16-16h-32c-8.875 0-16 7.125-16 16v32C240 424.9 247.1 432 256 432z"/></svg>
                                                        </a>
                                                    {/if}
                                                    {if $agency['email']}
                                                        <a href="mailto:{$agency['email']}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 128C0 92.65 28.65 64 64 64H448C483.3 64 512 92.65 512 128V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V128zM48 128V150.1L220.5 291.7C241.1 308.7 270.9 308.7 291.5 291.7L464 150.1V127.1C464 119.2 456.8 111.1 448 111.1H64C55.16 111.1 48 119.2 48 127.1L48 128zM48 212.2V384C48 392.8 55.16 400 64 400H448C456.8 400 464 392.8 464 384V212.2L322 328.8C283.6 360.3 228.4 360.3 189.1 328.8L48 212.2z"/></svg>
                                                        </a>
                                                    {/if}

                                                </div>
                                            </div>
                                        {/if}
                                    {/foreach}

                                </div>
                            </div>
                            {$counter = $counter + 1}
                        {/foreach}

                    </div>
                </div>
            {/if}
        {/foreach}
    {else}
        <div class="agencyList_404">
            <img src="assets/images/agencyList.png" alt='agencyList'>
            <h2>##rpresentivesError##</h2>
            <h3>##rpresentivesErrorDescription##</h3>
            <div class="link">
                <a href="{$smarty.const.ROOT_ADDRESS}/requestAgent">
                    ##NasimBeheshtAgent##
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M166.5 424.5l-143.1-152c-4.375-4.625-6.562-10.56-6.562-16.5c0-5.938 2.188-11.88 6.562-16.5l143.1-152c9.125-9.625 24.31-10.03 33.93-.9375c9.688 9.125 10.03 24.38 .9375 33.94l-128.4 135.5l128.4 135.5c9.094 9.562 8.75 24.75-.9375 33.94C190.9 434.5 175.7 434.1 166.5 424.5z"/></svg>
                </a>
            </div>
        </div>
    {/if}
</section>
