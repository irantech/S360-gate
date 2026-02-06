<script src="project_files/js/bootstrap.bundle.min.js"></script>
<script src="project_files/js/mega-menu.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
    <script src="project_files/js/owl.carousel.min.js"></script>
    <script src="project_files/js/select2.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{else}
    {if $smarty.const.GDS_SWITCH neq 'app'}
        <script type="text/javascript" src="project_files/js/modernizr.js"></script>
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
    {/if}
{/if}
<script src="project_files/js/script.js"></script>
<script>
    $(document).ready(function () {

        var owl = $('#owl-demo1');
        owl.owlCarousel({
            rtl: true,
            dots: true,
            loop: false,
            margin: 10,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            mouseDrag: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 4,
                    nav: true
                },
                600: {
                    items: 6,
                    nav: true
                },
                1000: {
                    items: 10,
                    nav: true,
                    loop: true,
                    margin: 5
                }
            }
        });


    })
</script>
<script type="text/javascript" src="assets/main-asset/js/public-main.js"></script>
</html>
