
<script src="project_files/js/bootstrap.min.js"></script><script src="project_files/js/select2.min.js"></script><script src="project_files/js/header.js"></script>
                            {if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
                                <script src="project_files/js/owl.carousel.min.js"></script><script src="project_files/js/searchBox.js"></script>
<script src="assets/js/jquery-confirm.min.js" type="text/javascript"></script>
                            {else}
                                {if $smarty.const.GDS_SWITCH neq 'app'}
                                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
                                {/if}
                            {/if}
                            <div class="after__all"></div>
<script src="project_files/js/mega-menu.js"></script>
{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
  particlesJS("particles-js", {
    particles: {
      number: {
        value: 200,
        density: {
          enable: true,
          value_area: 800,
        },
      },
      color: {
        value: "#f0c394",
      },
      opacity: {
        value: 0.4,
        random: false,
        anim: {
          enable: false,
          speed: 1,
          opacity_min: 0.1,
          sync: false,
        },
      },
      size: {
        value: 3,
        random: true,
        anim: {
          enable: false,
          speed: 40,
          size_min: 0.1,
          sync: false,
        },
      },
      line_linked: {
        enable: true,
        distance: 150,
        color: "#eee",
        opacity: 0.3,
        width: 1,
      },
      move: {
        enable: true,
        speed: 0.5,
        direction: "none",
        random: false,
        straight: false,
        out_mode: "out",
        bounce: false,
        attract: {
          enable: false,
          rotateX: 600,
          rotateY: 1200,
        },
      },
    },
    retina_detect: true,
  });
</script>
{/if}
<script src="assets/main-asset/js/public-main.js" type="text/javascript"></script>
<script src="project_files/js/script.js" type="text/javascript"></script>

{if $smarty.const.GDS_SWITCH eq 'mainPage' || $smarty.const.GDS_SWITCH eq 'page'}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`content-main-page-footer.tpl" info_access_client_to_service=$info_access_client_to_service}
{/if}