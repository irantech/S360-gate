{load_presentation_object filename="video" assign="objVideo"}
{assign var="info_video" value=$objVideo->getVideo($smarty.const.VIDEO_ID)}
<div class="container">
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-12"  style='margin-top: 40px'>

                <div class="box_citydetail" id="HistoryOfTheProvince">

                    <h2> {$info_video['title']}</h2>
                    <div>
                        <iframe  src="{$info_video['iframe_code']}" style='margin: 0 auto;'></iframe>

                        <p>
                            <br>
                            {$info_video['description']}
                        </p>
                    </div>
                </div>


        </div>
    </div>
</div>
