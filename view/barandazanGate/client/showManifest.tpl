{load_presentation_object filename="manifestController" assign="objManifestController"}


{include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
<!-- Agency Passengers List -->
<div id="agency-passengers-section" class="passengers-section-agency" style="display: none;">
    <div id="passengers-content" class="passengers-content-agency">
        <!-- Passengers table will be populated here -->
    </div>
</div>
<script type="text/javascript" src="assets/js/manifest.js"></script>
<script>
   $(document).ready(function() {
      loadAgencyPassengers({$smarty.get.id})
   });
</script>