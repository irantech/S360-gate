{load_presentation_object filename="resultLocal" assign="objResult"}
{$objResult->getFlightRule({$smarty.post.RelId},{$smarty.post.Address},{$smarty.post.Office})} 


<div class="parentHorizontalTab">
  <ul class="resp-tabs-list hor_1">
  	  {if $smarty.post.numAdult} <li><i class="fa fa-adult"></i><span>ADT</span></li> {/if}
      {if $smarty.post.numChild}<li><i class="fa fa-kid"></i><span>CHD</span></li>{/if}
      {if $smarty.post.numInfant}<li><i class="fa fa-baby"></i><span>INF</span></li>{/if}           
  </ul>
  <div class="resp-tabs-container hor_1 resp-tab-content-active " >
  
  {if $smarty.post.numAdult}
    <div class="resp-tab-content-active ">
        <div class="ChildVerticalTab_1">         
          <div class="resp-tabs-container ver_1 resp-tab-content-active ">
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['adult']['rule']}</p>
              </div>  
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['adult']['baggage']}</p>
              </div>         
          </div>
        </div>
    </div>
   {/if}


	{if $smarty.post.numChild}
   <div class="resp-tab-content-active ">
        <div class="ChildVerticalTab_1">         
          <div class="resp-tabs-container ver_1 resp-tab-content-active ">
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['child']['rule']}</p>
              </div>  
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['child']['baggage']}</p>
              </div>         
          </div>
        </div>
    </div>
   {/if}
	
	{if $smarty.post.numInfant}
    <div class="resp-tab-content-active ">
        <div class="ChildVerticalTab_1">         
          <div class="resp-tabs-container ver_1 resp-tab-content-active ">
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['infant']['rule']}</p>
              </div>  
              <div class="resp-tab-content-a ctive ">
                <p>{$objResult->flightRules['infant']['baggage']}</p>
              </div>         
          </div>
        </div>
    </div>
   {/if}



  </div>
</div>   


{literal}
<script type="text/javascript">
$('.parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activetab_bg: '#5AB1D0',
             inactive_bg: '#ccc',
            // activate: function (event) {
            //     var $tab = $(this);
            //     var $info = $('#nested-tabInfo');
            //     var $name = $('span', $info);
            //     $name.text($tab.text());
            //     $info.show();
            // }
        });

        $('.ChildVerticalTab_1').easyResponsiveTabs({
            width: 'auto',
            fit: true,
            tabidentify: 'ver_1',
            activetab_bg: '#4dd0e1',
             inactive_bg: '#bbb',
              // The tab groups identifier
             // background color for active tabs in this group
            // background color for inactive tabs in this group
        });
 </script>       
{/literal}        
