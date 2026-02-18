{literal}
    <script type="text/javascript" src="assets/js/classie.js"></script>
    <script type="text/javascript" src="assets/js/sidebarEffects.js"></script>
    <script type="text/javascript" src="assets/js/jquery-asTabs.js"></script>
    <script type="text/javascript" src="assets/js/nanoscroller.min.js"></script>
    <script type="text/javascript" src="assets/js/Obj.min.js"></script>
    <script type="text/javascript" src="assets/js/addSlider.js"></script>
    <script type="text/javascript" src="assets/js/jquery.voteStar.js"></script>
    <script type="text/javascript" src="assets/js/hideMaxListItem.js"></script>
    <script type="text/javascript" src="assets/js/select2.min.js"></script>
  <script src="assets/plugins/switchery/dist/switchery.min.js"></script>

  <script type="text/javascript">
      $(document).ready(function() {

        $('.select2').select2()

        setTimeout(function(){
        $('.select2login').select2({
            placeholder: 'awdawd aw dawd ',
          minimumResultsForSearch: Infinity,
        })
        },300)

        $('.select2-num').select2({minimumResultsForSearch: Infinity})
        $('.select2-multiple-tags').select2({
          minimumResultsForSearch: Infinity,
          tags: true,
        })
      })

    </script>
    <script type="text/javascript">
      /*note : customized select2 for some results*/
      $(document).ready(function() {
        if ($('.select2SearchStations').length > 0) {
          $('.select2SearchStations').select2({
            ajax: {
              url: 'http://192.168.1.100/CoreTestDeveloper/V-1/ExternalTrain/stations/',
              type: 'GET',
              delay: 300,
              data: function(params) {
                return {
                  q: params.term,
                  page: params.page || 1,
                }
              },
              processResults: function(data, params) {
                params.page = params.page || 1
                var per_page = data.Result.per_page || 15
                params.per_page = per_page
                return {
                  results:
                    $.map(data.Result.items, function(item) {
                        return {
                          text: item.name,
                          id: item.code,
                          country_name: item.country_name,
                          country_name_fa: item.country_name_fa,
                        }
                      },
                    ),
                  pagination: {
                    more: (params.page * per_page) < data.Result.total,
                  },
                }
              },
            },
            minimumInputLength: 3,
            placeholder: 'Select an option',
            language: {
              inputTooShort: function() {
                return 'شما باید حداقل سه حرف وارد کنید'
              },
              loadingMore: function() {
                return 'بارگزاری موارد بیشتر ... '
              },
              searching: function() {
                return 'در حال جستجو ... '
              },
            },
            templateResult: function(res) {
              var $item_container = 'در حال بارگزاری ... '
              if (typeof (res.id) !== 'undefined') {
                $item_container = $(
                  '<div class=\'select2-result-item clearfix\'>' +
                  '<div class=\'select2-result-item__meta d-flex w-100\'>' +
                  '<div class=\'select2-result-item__code p-1\'></div>' +
                  '<div class=\'select2-result-item__title p-1 font-weight-normal\'></div>' +
                  '<div class=\'select2-result-item__country p-1 font-13\'></div>' +
                  '</div>' +
                  '</div>',
                )
                $item_container.find('.select2-result-item__code').html('<kbd class="border bg-secondary border text-white font-12">' + res.id + '</kbd>')
                $item_container.find('.select2-result-item__title').text(res.text + ', ')
                $item_container.find('.select2-result-item__country').append(res.country_name)
                return $item_container
              }
              return $item_container
            },
            templateSelection: function(res) {
              // console.log(res);
              if (res.id === '') { // adjust for custom placeholder values
                return 'جستجوی ایستگاه'
              }
              return res.text + ', ' +
                res.country_name +
                ', ' + res.id || 'test'
            },
          })
        }


      })
    </script>
    <script type="text/javascript" src="assets/js/customFooterJsForBus.js"></script>
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script type="text/javascript" src="assets/js/jquery.sliderPro.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function($) {
        $('#example3').sliderPro({
          width: 960,
          height: 449,
          fade: true,
          arrows: true,
          buttons: false,
          fullScreen: true,
          shuffle: true,
          smallSize: 500,
          mediumSize: 1000,
          largeSize: 3000,
          thumbnailArrows: true,
          autoplay: true,
        })
      })
    </script>
    <!-- lazyView -->
    <script type="text/javascript" src="assets/js/lazyView/jquery.lazyView.js"></script>
    <!-- lazyView -->
    <script type="text/javascript" src="assets/js/rater.js"></script>
{/literal}
<script type="text/javascript">
  $(document).ready(function($) {
      {if $smarty.const.GDS_SWITCH eq 'searchHotel'}

      {literal}
    if ($('.select2SearchHotelCities').length > 0) {
        {/literal}

        {assign var="selected_city" value=''}

        {if  isset($smarty.get.type) && $smarty.get.type neq '' && $smarty.get.type eq 'new'}
        {$selected_city = $smarty.get.city}
        {else}
        {$selected_city = $smarty.const.SEARCH_CITY}
        {/if}
      let selected_id = '{$selected_city}'
        {literal}
      console.log(selected_id)
      $('.select2SearchHotelCities').select2({
        data: all_cities,
        escapeMarkup: function(markup) {
          return markup
        },
        templateResult: function(item) {
          return item.html
        },
        templateSelection: function(item) {
          return item.text
        },
      }).val(selected_id).trigger('change')
    }
      {/literal}
      {/if}
      {literal}
    if($('#starSortSelect').length > 0){
      $("#starSortSelect").select2({
        placeholder: useXmltag('Starhotel'),
        allowClear: true,
      });
    }
    if($('#moveSortSelect').length > 0){
      $("#moveSortSelect").select2({
        placeholder: useXmltag('Timesort'),
        allowClear: true,
      });
    }
      {/literal}
      {literal}
    if($('#priceSortSelect').length > 0){
      $("#priceSortSelect").select2({
        placeholder: useXmltag('Price'),
        allowClear: true,
      });
    }
      {/literal}
  })

</script>
