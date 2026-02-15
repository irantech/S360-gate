
{load_presentation_object filename="package" assign="objResult"}
{load_presentation_object filename="currencyEquivalent" assign="objCurrency"}
{*$objFunctions->LogInfo()*}
{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{assign var="InfoCounter" value=$objFunctions->infoCounterType($InfoMember.fk_counter_type_id)}

<div class="content_package" id="appPackage">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-padding-5">
                <div class="parent_sidebar">
                <search-box></search-box>
                </div>
            </div>
            <div class="col-md-9 col-padding-5">
                <form id="SendDataToDetailPage"></form>

                <components-package></components-package>

                {assign var="moduleData" value=[
                'service'=>'Package',
                'origin'=>$smarty.const.SEARCH_ORIGIN,
                'destination'=>$smarty.const.SEARCH_DESTINATION
                ]}


                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
                moduleData=$moduleData}
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
                moduleData=$moduleData}

            </div>
        </div>

    </div>

{*   <loader-search-package></loader-search-package>*}
</div>



<script src="assets/js/vue/axios.js"></script>
<script src="assets/js/tata.js"></script>
<script type="text/javascript">
    window.axios = axios;

    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
</script>
<script src="assets/js/vue/vue.min.js"></script>
<script src="assets/js/vue/package.js"></script>

<script>

    $(document).ready(function (){

        $('body').on('click', '.nav-tabs a', function(e){
            var tab  = $(this).parent(),
                tabIndex = tab.index(),
                tabPanel = $(this).closest('.panel'),
                tabPane = tabPanel.find('.tab-pane').eq(tabIndex);

            tabPanel.find('.active').removeClass('active');
            tab.addClass('active');
            tabPane.addClass('active');
        });


        $('body').on('click' ,'.reserve_room_tour' , function (){
            $(document).find('.show_More').removeClass('show_More');
            $(document).find('.loaderPublicForHotel').show();
            let roomsCount = $(this).parents('.content_tour').find('.rows .row').length;
            let parentsthis = $(this).parents('.content_tour');
            parentsthis.find('.roomCount').append(roomsCount);
            parentsthis.toggleClass('show_More')


        });
        $('body').on('click' ,'.more_room_div' , function (){
            $(this).parents('.content_tour').find('.rows').toggleClass('showAllRow');
            $(this).toggleClass('rotate_arrow')
        });


    })
</script>



