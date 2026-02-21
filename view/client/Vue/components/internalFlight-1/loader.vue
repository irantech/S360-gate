<template>
	<div class="loader-section">
		<div id="loader-page" class="lazy-loader-parent ">
			<div class="loader-page container site-bg-main-color">
				<div class="parent-in row">

					<div class="loader-txt">
						<div id="flight_loader">
                          <span class="loader-date">
                              {{data_search.DateFlightWithName}}
                          </span>
							<div class="wrapper">

								<div class="locstart"></div>
								<div class="flightpath">
									<div class="airplane"></div>
								</div>
								<div class="locend"></div>
							</div>
						</div>

						<div class="loader-distinc">
							{{ useXmltag('Searching')}}
							{{ useXmltag('Flight')}}
							{{ useXmltag('From')}}
							<span>
                                  {{ data_search.name_departure}}
                            </span>
							{{ useXmltag('On')}}
							<span>
                                   {{ data_search.name_arrival}}
                                </span>
							{{ useXmltag('ForYou')}}
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: "loader",
	    props:['dataSearch'],
	    data(){
          return{
              data_search:[]
          }
	    },
	    watch:{
            dataSearch() {
                let _this = this;
                if (_this.dataSearch) {
                    _this.data_search = _this.dataSearch.dataSearch;
                }
            },
	    }
    }
</script>

<style scoped>

</style>