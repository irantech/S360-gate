<template>
	<div class="loader-section">
		<div id="loader-page" class="lazy-loader-parent ">
			<div class="loader-page container site-bg-main-color">
				<div class="parent-in row">

					<div class="loader-txt">
						<div id="flight_loader">
              <span class="loader-date" v-if='dataSearch'>
                  {{dataSearch.DateFlightWithName}}
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
							<span v-if='dataSearch'>
                                  {{ dataSearch.name_departure}}
                            </span>
							{{ useXmltag('On')}}
							<span v-if='dataSearch'>
                                   {{ dataSearch.name_arrival}}
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
	    data(){
          return{
          }
	    },
      computed  :{
        dataSearch() {
          return this.$store.state.setDataSearch.dataSearch
        }
      }

    }
</script>

<style scoped>

</style>