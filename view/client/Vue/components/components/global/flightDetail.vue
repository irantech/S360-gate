<template>
  <div class="parent-details-rules">

    <div class="child-details-rules">
      <div class="col-9 p-0">
        <ul class="nav nav-pills parent-tab-data-click-flight" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" :id="`tab-flight-${flight.flight_id}-information`"
                    data-toggle="pill" :data-target="`#flight-${flight.flight_id}-information-box`"
                    type="button" role="tab"
                    :aria-controls="`flight-${flight.flight_id}-information-box`" aria-selected="true">
              {{useXmltag('Informationflight')}}
            </button>
          </li>
          <li class="nav-item" role="presentation"  v-show="type == 'domestic' || (type == 'international' && flight.source_id=='14')">
            <button class="nav-link" :id="`tab-cancel-${flight.flight_id}`" data-toggle="pill"
                    :data-target="`#cancel-${flight.flight_id}-box`" type="button" role="tab"
                    :aria-controls="`cancel-${flight.flight_id}-box`" aria-selected="false"
                    @click="getAirRules()">
              {{useXmltag('Cancellationrules')}}
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" :id="`tab-general-${flight.flight_id}`" data-toggle="pill"
                    :data-target="`#general-${flight.flight_id}-box`" type="button" role="tab"
                    :aria-controls="`general-${flight.flight_id}-box`" aria-selected="false">
              {{useXmltag('publicRules')}}
            </button>
          </li>
        </ul>
        <div class="tab-content parent-box-data-click-flight" id="pills-tabContent">
          <div class="tab-pane fade show active" :id="`flight-${flight.flight_id}-information-box`"
               role="tabpanel" :aria-labelledby="`tab-flight-${flight.flight_id}-information`">
            <div v-if="type == 'domestic'">
              <detail-info :flight='flight'></detail-info>
            </div>
            <div v-else>

                  <detail-depart-flight  :dept_detail_flight="flight.output_routes_detail"/>


              <template v-if="flight.return_routes !=''">
                <detail-return-flight :return_detail_flight="flight.return_routes.return_route_detail"
                                      :dept_detail_flight="flight.output_routes_detail"/>
              </template>

            </div>
          </div>
          <div v-if="type == 'domestic' && flight.flight_type_li =='system'" class="tab-pane fade"
               :id="`cancel-${flight.flight_id}-box`" role="tabpanel" :aria-labelledby="`tab-${flight.flight_id}-cancel`" @click="getCancelFee()">
            <div class="parent-cancellation-rules-click" v-if="fee_cancel !='' " >
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3>{{useXmltag('Fromthetimeticketissueuntilnoondaysbeforeflight')}}</h3>
                <p v-if="isNaN(`'${fee_cancel.ThreeDaysBefore}'`)">
                  {{ fee_cancel.ThreeDaysBefore}}
                </p>
                <p v-else>
                  {{ fee_cancel.ThreeDaysBefore}} {{useXmltag('PenaltyPercent')}}
                </p>
              </div>
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3>{{useXmltag('Fromnoondaysbeforeflightnoondaybeforeflight')}}</h3>
                <p v-if="isNaN(`'${fee_cancel.OneDaysBefore}'`)">
                  {{ fee_cancel.OneDaysBefore}}
                </p>
                <p v-else>
                  {{ fee_cancel.OneDaysBefore}} {{useXmltag('PenaltyPercent')}}
                </p>
              </div>
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3>{{useXmltag('Fromnoondaybeforeflighthoursbeforeflight')}}</h3>
                <p  v-if="isNaN(`'${fee_cancel.ThreeHoursBefore}'`)">
                  {{ fee_cancel.ThreeHoursBefore}}
                </p>
                <p v-else>
                  {{ fee_cancel.ThreeHoursBefore}} {{useXmltag('PenaltyPercent')}}
                </p>
              </div>
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3> {{useXmltag('Fromhoursbeforeflighttominutesbeforeflight')}}</h3>
                <p   v-if="isNaN(`'${fee_cancel.ThirtyMinutesAgo}'`)">
                  {{ fee_cancel.ThirtyMinutesAgo}}
                </p>
                <p   v-else>
                  {{ fee_cancel.ThirtyMinutesAgo}} {{useXmltag('PenaltyPercent')}}
                </p>
              </div>
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3>{{ useXmltag('Minutesbeforetheflight')}}</h3>
                <p  v-if="isNaN(`'${fee_cancel.OfThirtyMinutesAgoToNext}'`)">
                  {{ fee_cancel.ThirtyMinutesAgo}}
                </p>
                <p   v-else>
                  {{ fee_cancel.ThirtyMinutesAgo}} {{useXmltag('OfThirtyMinutesAgoToNext')}}
                </p>
              </div>
            </div>
            <div class="parent-cancellation-rules-click" v-else>
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <h3>{{ useXmltag('DetailMoneyCancel')}}</h3>
                <p>
                  {{ useXmltag('Contactbackupunitinformationaboutamountconsignmentfines')}}
                </p>
              </div>
            </div>
          </div>
          <div v-else-if="type == 'international' &&  flight.source_id=='14'" class="tab-pane fade"
               :id="`cancel-${flight.flight_id}-box`" role="tabpanel" :aria-labelledby="`tab-${flight.flight_id}-cancel`" @click="getCancelFee()">

            <img :src="`${getUrlWithoutLang()}/view/client/assets/images/load21.gif`"
                 width="120px"
                 alt="" class="loaderDetail"
                 style="width: 50px;position: relative;"
                 :id="`loaderDetail${flight.flight_id}`" v-if="is_show_loader">

            <detail-rule :data_rules="data_rules" v-if='is_show_rules'></detail-rule>
          </div>
          <div v-else-if="type == 'domestic' && flight.flight_type_li =='charter'" class="tab-pane fade"
               :id="`cancel-${flight.flight_id}-box`" role="tabpanel" :aria-labelledby="`tab-${flight.flight_id}-cancel`">
            <div class="parent-cancellation-rules-click" >
              <div class="cancellation-rules-click-items">
                <div class="img-cancellation">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M312 24V34.5c6.4 1.2 12.6 2.7 18.2 4.2c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17c-10.9-2.9-21.1-4.9-30.2-5c-7.3-.1-14.7 1.7-19.4 4.4c-2.1 1.3-3.1 2.4-3.5 3c-.3 .5-.7 1.2-.7 2.8c0 .3 0 .5 0 .6c.2 .2 .9 1.2 3.3 2.6c5.8 3.5 14.4 6.2 27.4 10.1l.9 .3 0 0c11.1 3.3 25.9 7.8 37.9 15.3c13.7 8.6 26.1 22.9 26.4 44.9c.3 22.5-11.4 38.9-26.7 48.5c-6.7 4.1-13.9 7-21.3 8.8V232c0 13.3-10.7 24-24 24s-24-10.7-24-24V220.6c-9.5-2.3-18.2-5.3-25.6-7.8c-2.1-.7-4.1-1.4-6-2c-12.6-4.2-19.4-17.8-15.2-30.4s17.8-19.4 30.4-15.2c2.6 .9 5 1.7 7.3 2.5c13.6 4.6 23.4 7.9 33.9 8.3c8 .3 15.1-1.6 19.2-4.1c1.9-1.2 2.8-2.2 3.2-2.9c.4-.6 .9-1.8 .8-4.1l0-.2c0-1 0-2.1-4-4.6c-5.7-3.6-14.3-6.4-27.1-10.3l-1.9-.6c-10.8-3.2-25-7.5-36.4-14.4c-13.5-8.1-26.5-22-26.6-44.1c-.1-22.9 12.9-38.6 27.7-47.4c6.4-3.8 13.3-6.4 20.2-8.2V24c0-13.3 10.7-24 24-24s24 10.7 24 24zM568.2 336.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 485.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V416c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 384l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                </div>
                <p>
                  {{useXmltag('ThecharterflightscharterunderstandingCivilAviationOrganization')}}
                </p>
              </div>
            </div>

          </div>
          <div v-if="type == 'domestic'" class="tab-pane fade" :id="`general-${flight.flight_id}-box`" role="tabpanel" :aria-labelledby="`tab-${flight.flight_id}-general`">
            <div class="parent-general-regulations-click">
              <p>
                1- {{useXmltag('AccordingCivilAviationOrganizationResponsibilityResponsibleFlying')}}              </p>
              <p>
                2- {{useXmltag('ResponsibilityAllTravelInformationEntryIncorrectPassengerRePurchase')}}              </p>
              <p>
                3- {{useXmltag('MustEnterValidMobileNecessary')}}
              </p>
              <p>
                4- {{useXmltag('AviationRegulationsBabyChildAdultAges')}}
              </p>
              <p>
                5- {{useXmltag('CanNotBuyBabyChildTicketOnlineIndividuallySeparatelyAdultTickets')}}
              </p>
              <p>
                6- {{useXmltag('AircraftDeterminedAnyChangeAircraftCarrierHoldingFlight')}}
              </p>
              <p>
                7- {{useXmltag('PresenceDomesticFlightsRequiredForeignFlightsRequiredDocuments')}}
              </p>
            </div>
          </div>
          <div v-else class="tab-pane fade" :id="`general-${flight.flight_id}-box`" role="tabpanel" :aria-labelledby="`tab-${flight.flight_id}-general`">
            <div class="parent-general-regulations-click">
              <p>
                1- {{ useXmltag('Presencepassengerobligatoryhalfhoursbeforetimeflightairport')}}              </p>
              <p>
                2- {{ useXmltag('Havingvalididentificationdocumentboardingaircraft')}}         </p>
              <p>
                3- {{ useXmltag('Delayhurryflightnotificationmadeviamobilenumber')}}
              </p>
              <p>
                4-  {{ useXmltag('Theticketsissuedpassengersnon')}}
              </p>
              <p>
                5- {{ useXmltag('Youreceivehappysendemailsendusemail')}}
              </p>
              <p>
                6-  {{ useXmltag('Probabilitychangingcharterflightssystemcasesflightswillreturncharterercase')}}
              </p>
              <p>
                7- {{ useXmltag('ServiceslicensestoragesmaintenanceServicescustomshoistingtransportcargohandling')}}
              </p>
              <p>
                8- {{ useXmltag('PassengerwishesmakebetweenflightOtherwiseresponsibilitypassengercancelticket')}}
              </p>
              <p>
                9- {{ useXmltag('Shoulddifferentcancellationhourscancellationflightconsignmentfine')}}
              </p>
              <p>
                10-  {{ useXmltag('UnderpossiblenationalsAfghanistanBangladeshPakistanfutureresponsibilitiesuser')}}
              </p>
              <p>
                11- {{ useXmltag('ResponsibilityvisacontrolpassengerresponsibilityContactyoufurtherinformation')}}
              </p>
              <p>
                12- {{ useXmltag('Youhaveproblems')}}
              </p>
              <p>
                13- {{ useXmltag('RuleFlightAirPortIstanbul')}}
              </p>
            </div>
          </div>
        </div>
      </div>
        <detail-price  v-if="windowWidth > 576" :flight='flight'/>
    </div>
  </div>
</template>
<script>
import detailRule from './detailRules'
import detailInfo from './detailInfo'
import detailDepartFlight from './detailDepartFlight'
import detailReturnFlight from './detailReturnFlight'
import DetailPrice from './detailPrice'
export default  {
  name : 'price-detail' ,
  props : ['flight' , 'type'],
  components: {
    DetailPrice,
    'detail-rule': detailRule,
    'detail-info': detailInfo,
    'detail-depart-flight': detailDepartFlight,
    'detail-return-flight': detailReturnFlight,
  },
  data() {
    return {
      fee_cancel : '' ,
      data_rules : {},
      is_show_rules : false,
      is_show_loader : true ,
      windowWidth : window.innerWidth,

    }
  },
  filters: {
    formatNumber: function (value) {
      return Number(value).toLocaleString('en-US');
    }
  } ,
  methods: {
    getCancelFee () {
        axios.post(amadeusPath + 'ajax',
          {
            className: 'newApiFlight',
            method: 'getFeeCancel',
            airline : this.flight.airline,
            cabin_type : this.flight.cabin_type ,
            is_json: true,
          },
          {
            'Content-Type': 'application/json',
          }).then(function(response) {
          let data_fee =  response.data.data;

          console.log(data_fee)
          if(data_fee !==""){
            console.log(data_fee)

            this.fee_cancel  = data_fee ;
          }else{
            this.fee_cancel = '' ;
          }

        }).catch(function(error) {
          console.log(error)
        })
    } ,
    getAirRules(){

      let _this = this;
      axios.post(amadeusPath + 'ajax',
        {
          className: 'newApiFlight',
          method: 'getInfoRulesFlight',
          request_number: _this.flight.unique_code,
          agency_id:_this.flight.agency_id,
          fare_source_code :_this.flight.flight_id
        },
        {
          'Content-Type': 'application/json'
        }).then(function (response) {
        _this.data_rules = response.data.data ;
        _this.is_show_rules = true;
        _this.is_show_loader = false;
      }).catch(function (error) {
      });

    }
  }
}
</script>