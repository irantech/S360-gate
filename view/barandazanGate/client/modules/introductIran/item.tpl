{load_presentation_object filename="introductIran" assign="objAboutIran"}
{assign var="about_info" value=$objAboutIran->getProvince($smarty.const.INTRODUCT_IRAN_ID)}
{assign var="type_data" value=['is_active'=>1 , 'provinceId'=>$smarty.const.INTRODUCT_IRAN_ID]}
{assign var="getAncient" value=$objAboutIran->getListAncient($type_data)}
{*{$smarty.const.INTRODUCT_IRAN_ID|var_dump}*}
{*{$about_info|var_dump}*}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/introductIran-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/introductIran.css'>
{/if}



<div class="container py-3">
    <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="parent-sidebar">
                <div class="sidebar-box">
                    <h3>##QuickAccess##</h3>
                    <div class="parent-link-data">
                        {if $about_info.history_province}
                            <button onclick="clickScroll('HistoryOfTheProvince')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M173 131.5C229.2 75.27 320.3 75.27 376.5 131.5C430 185 432.9 270.9 383 327.9L377.7 334C368.9 344 353.8 345 343.8 336.3C333.8 327.6 332.8 312.4 341.5 302.4L346.9 296.3C380.1 258.3 378.2 201.1 342.5 165.4C305.1 127.1 244.4 127.1 206.1 165.4L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.3 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.6 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L173 131.5zM467 380.5C410.8 436.7 319.7 436.7 263.5 380.5C209.1 326.1 207.1 241.1 256.9 184.1L261.6 178.7C270.3 168.7 285.5 167.7 295.5 176.4C305.5 185.1 306.5 200.3 297.8 210.3L293.1 215.7C259.8 253.7 261.8 310.9 297.4 346.6C334.9 384 395.6 384 433.1 346.6L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.7C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.3 377.7 62.58L383.9 57.22C440.9 7.348 526.8 10.21 580.3 63.76C636.5 119.9 636.5 211 580.3 267.2L467 380.5z"/></svg>
                                ##HistoryProvince##
                            </button>
                        {/if}
                        {if $about_info.museums_province}
                            <button onclick="clickScroll('MuseumsOfTheProvince')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M173 131.5C229.2 75.27 320.3 75.27 376.5 131.5C430 185 432.9 270.9 383 327.9L377.7 334C368.9 344 353.8 345 343.8 336.3C333.8 327.6 332.8 312.4 341.5 302.4L346.9 296.3C380.1 258.3 378.2 201.1 342.5 165.4C305.1 127.1 244.4 127.1 206.1 165.4L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.3 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.6 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L173 131.5zM467 380.5C410.8 436.7 319.7 436.7 263.5 380.5C209.1 326.1 207.1 241.1 256.9 184.1L261.6 178.7C270.3 168.7 285.5 167.7 295.5 176.4C305.5 185.1 306.5 200.3 297.8 210.3L293.1 215.7C259.8 253.7 261.8 310.9 297.4 346.6C334.9 384 395.6 384 433.1 346.6L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.7C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.3 377.7 62.58L383.9 57.22C440.9 7.348 526.8 10.21 580.3 63.76C636.5 119.9 636.5 211 580.3 267.2L467 380.5z"/></svg>
                                ##MuseumProvince##
                            </button>
                        {/if}
                        {if $about_info.handicrafts_province}
                            <button onclick="clickScroll('HandicraftsOfTheProvince')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M173 131.5C229.2 75.27 320.3 75.27 376.5 131.5C430 185 432.9 270.9 383 327.9L377.7 334C368.9 344 353.8 345 343.8 336.3C333.8 327.6 332.8 312.4 341.5 302.4L346.9 296.3C380.1 258.3 378.2 201.1 342.5 165.4C305.1 127.1 244.4 127.1 206.1 165.4L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.3 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.6 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L173 131.5zM467 380.5C410.8 436.7 319.7 436.7 263.5 380.5C209.1 326.1 207.1 241.1 256.9 184.1L261.6 178.7C270.3 168.7 285.5 167.7 295.5 176.4C305.5 185.1 306.5 200.3 297.8 210.3L293.1 215.7C259.8 253.7 261.8 310.9 297.4 346.6C334.9 384 395.6 384 433.1 346.6L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.7C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.3 377.7 62.58L383.9 57.22C440.9 7.348 526.8 10.21 580.3 63.76C636.5 119.9 636.5 211 580.3 267.2L467 380.5z"/></svg>
                                ##Handicrafts##
                            </button>
                        {/if}

                        {if $getAncient}
                            <button onclick="clickScroll('AntiquitiesOfTheProvince')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M173 131.5C229.2 75.27 320.3 75.27 376.5 131.5C430 185 432.9 270.9 383 327.9L377.7 334C368.9 344 353.8 345 343.8 336.3C333.8 327.6 332.8 312.4 341.5 302.4L346.9 296.3C380.1 258.3 378.2 201.1 342.5 165.4C305.1 127.1 244.4 127.1 206.1 165.4L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.3 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.6 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L173 131.5zM467 380.5C410.8 436.7 319.7 436.7 263.5 380.5C209.1 326.1 207.1 241.1 256.9 184.1L261.6 178.7C270.3 168.7 285.5 167.7 295.5 176.4C305.5 185.1 306.5 200.3 297.8 210.3L293.1 215.7C259.8 253.7 261.8 310.9 297.4 346.6C334.9 384 395.6 384 433.1 346.6L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.7C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.3 377.7 62.58L383.9 57.22C440.9 7.348 526.8 10.21 580.3 63.76C636.5 119.9 636.5 211 580.3 267.2L467 380.5z"/></svg>
                                ##Antiquities##
                            </button>
                        {/if}

                        {if $about_info.video_url}
                        <button onclick="clickScroll('VideoClipsOfTheProvince')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M173 131.5C229.2 75.27 320.3 75.27 376.5 131.5C430 185 432.9 270.9 383 327.9L377.7 334C368.9 344 353.8 345 343.8 336.3C333.8 327.6 332.8 312.4 341.5 302.4L346.9 296.3C380.1 258.3 378.2 201.1 342.5 165.4C305.1 127.1 244.4 127.1 206.1 165.4L93.63 278.7C56.19 316.2 56.19 376.9 93.63 414.3C129.3 449.1 186.6 451.9 224.5 418.7L230.7 413.3C240.6 404.6 255.8 405.6 264.5 415.6C273.3 425.5 272.2 440.7 262.3 449.4L256.1 454.8C199.1 504.6 113.2 501.8 59.69 448.2C3.505 392.1 3.505 300.1 59.69 244.8L173 131.5zM467 380.5C410.8 436.7 319.7 436.7 263.5 380.5C209.1 326.1 207.1 241.1 256.9 184.1L261.6 178.7C270.3 168.7 285.5 167.7 295.5 176.4C305.5 185.1 306.5 200.3 297.8 210.3L293.1 215.7C259.8 253.7 261.8 310.9 297.4 346.6C334.9 384 395.6 384 433.1 346.6L546.4 233.3C583.8 195.8 583.8 135.1 546.4 97.7C510.7 62.02 453.4 60.11 415.5 93.35L409.3 98.7C399.4 107.4 384.2 106.4 375.5 96.44C366.7 86.47 367.8 71.3 377.7 62.58L383.9 57.22C440.9 7.348 526.8 10.21 580.3 63.76C636.5 119.9 636.5 211 580.3 267.2L467 380.5z"/></svg>
                            ویدئوی استان
                        </button>
                        {/if}

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-12">
            {if $about_info.history_province}
                <div class="box_citydetail" id="HistoryOfTheProvince">
                    <h2> ##History## {$about_info.title}</h2>
                    <div>
                        <p>
                            {$about_info.history_province}
                        </p>
                    </div>
                </div>
            {/if}
            {if $about_info.museums_province}
                <div class="box_citydetail" id="MuseumsOfTheProvince">
                    <h2>##Museums## {$about_info.title}</h2>
                    <div>
                        {$about_info.museums_province}
                    </div>
                </div>
            {/if}
            {if $about_info.handicrafts_province}
                <div class="box_citydetail" id="HandicraftsOfTheProvince">
                    <h2>##Handicrafts## {$about_info.title}</h2>
                    <div>
                        <p>
                            {$about_info.handicrafts_province}
                        </p>
                    </div>
                </div>
            {/if}

           {if $getAncient}
               <div class="box_citydetail" id="AntiquitiesOfTheProvince">
                   <h2>##Antiquities## {$about_info.title}</h2>
                   <div>
                       <div class="box_citydetail_grid">
                           {foreach $getAncient as $key => $itemAncient}
                               <a href="{$smarty.const.ROOT_ADDRESS}/introductIran/ancient/citydetail/tourismdetail/{$itemAncient.id}">
                                   <div class="img_box"><img src="{$itemAncient.pic_show}" alt="{$itemAncient.title}" title='{$itemAncient.title}'></div>
                                   <h2>{$itemAncient.title}</h2>
                                   <p>{$objAboutIran->my_substr(strip_tags($itemAncient.content) , 0 , 100)}</p>
                                   <button>##ReadMore##</button>
                               </a>
                           {/foreach}
                       </div>
                   </div>
               </div>
           {/if}
            {if $about_info.video_url}
            <div class="box_citydetail" id="VideoClipsOfTheProvince">
                <h2>ویدئوی استان {$about_info.title}</h2>
                <div>

                    <iframe src="{$about_info.video_url}" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>

                </div>
            </div>
            {/if}




        </div>
    </div>
</div>

