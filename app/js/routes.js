routes = [
    {
        path: '/',
        url: './AppHome.php',
        
        on: {
            pageInit: function (event, page) {

                var today = new Date();
                var weekLater = new Date().setDate(today.getDate() - 1);
                today3 = new Date().setDate(today.getDate() - 1);
                var calendarDefault = app.calendar.create({
                    calendarType: 'jalali',
                    weekendDays: [1],
                    firstDay: 7,
                    monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    inputEl: '#demo-calendar-default',
                    disabled: {
                        to: weekLater
                    },
                    minDate: weekLater,
                    closeOnSelect: true,
                    on: {
                        dayClick: function (a, b, c, d, e) {
                            $$("#demo-calendar-default2").val('');
                            if ($$(".hidden-bargasht-input").val() == 0) {
                                $$(".hidden-bargasht-input").val("1");
                            } else {
                                calendarDefault2.destroy();
                            }
                            dd = d + 1;
                            var salam = jalali_to_gregorian(c, dd, e);
                            salamm = salam[1] - 1;
                            salamm2 = salam[2] - 1;
                            today3 = new Date(salam[0], salamm, salamm2);

                            calendarDefault2 = app.calendar.create({
                                calendarType: 'jalali',
                                inputEl: '#demo-calendar-default2',

                                disabled: {
                                    to: today3
                                },
                                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                dayNames: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                dayNamesShort: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                firstDay: 7, // Saturday
                                weekendDays: [1], // Friday
                                closeOnSelect: true,
                            });

                        }
                    }

                });

                var today = new Date();
                var weekLater = new Date().setDate(today.getDate() - 1);
                today3 = new Date().setDate(today.getDate() - 1);
                var calendarDefaultForeign = app.calendar.create({
                    calendarType: 'jalali',
                    weekendDays: [1],
                    firstDay: 7,
                    monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    inputEl: '#demo-calendar-default-foreign',
                    disabled: {
                        to: weekLater
                    },
                    minDate: weekLater,
                    closeOnSelect: true,
                    on: {
                        dayClick: function (a, b, c, d, e) {
                            $$("#demo-calendar-default2-foreign").val('');
                            if ($$(".hidden-bargasht-input-foreign").val() == 0) {
                                $$(".hidden-bargasht-input-foreign").val("1");
                            } else {
                                calendarDefault2.destroy();
                            }
                            dd = d + 1;
                            var salam = jalali_to_gregorian(c, dd, e);
                            salamm = salam[1] - 1;
                            salamm2 = salam[2] - 1;
                            today3 = new Date(salam[0], salamm, salamm2);

                            calendarDefault2 = app.calendar.create({
                                calendarType: 'jalali',
                                inputEl: '#demo-calendar-default2-foreign',

                                disabled: {
                                    to: today3
                                },
                                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                dayNames: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                dayNamesShort: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                firstDay: 7, // Saturday
                                weekendDays: [1], // Friday
                                closeOnSelect: true,
                            });

                        }
                    }

                });
                if ($$(".hidden-raft-input").val() == 0) {
                    $$(".hidden-raft-input").val("1");
                } else {
                    calendarDefault.destroy();
                }
                if ($$(".hidden-raft-input-foreign").val() == 0) {
                    $$(".hidden-raft-input-foreign").val("1");
                } else {
                    calendarDefault.destroy();
                }



                var autocompleteStandaloneAjax1 = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Origin', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید(تهران-THR-TEHRAN)',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'Departure_Code', //object's "value" property name
                    textProperty: 'Departure_City', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        var dataSample = [
                            {
                                "Departure_Code": 'THR',
                                "Departure_City": "تهران"
                            },
                            {
                                "Departure_Code": 'MHD',
                                "Departure_City": "مشهد"
                            },
                            {
                                "Departure_Code": 'SYZ',
                                "Departure_City": "شیراز"
                            },
                            {
                                "Departure_Code": 'KIH',
                                "Departure_City": "کیش"
                            },
                            {
                                "Departure_Code": 'IFN',
                                "Departure_City": "اصفهان"
                            },
                            {
                                "Departure_Code": 'TBZ',
                                "Departure_City": "تبریز"
                            },
                            {
                                "Departure_Code": 'GSM',
                                "Departure_City": "قشم"
                            },
                            {
                                "Departure_Code": 'BND',
                                "Departure_City": "بندرعباس"
                            },
                            {
                                "Departure_Code": 'KSH',
                                "Departure_City": "کرمانشاه"
                            },
                            {
                                "Departure_Code": 'AWZ',
                                "Departure_City": "اهواز"
                            }];
                        var autocomplete = this;
                        var results = [];


                        if (query.length === 0) {
                            results = dataSample;
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Local',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].Departure_Code.toLowerCase().indexOf(query) >= 0 || data[i].Departure_City.toLowerCase().indexOf(query) >= 0 || data[i].Departure_CityEn.toLowerCase().toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            console.log(value);
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].Departure_City);
                                inputValue.push(value[i].Departure_Code);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Origin').find('.item-after').text(itemText.join('- '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Origin').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Origin').find('input').attr('id', 'DepartureCode');

                            $$('#autocomplete-standalone-Origin').find('input').attr('name', 'DepartureCode');
                        },
                    },
                });

                var autocompleteStandaloneAjax2 = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Destination', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مقصد را وارد کنید(تهران-THR-TEHRAN)',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'Departure_Code', //object's "value" property name
                    textProperty: 'Departure_City', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        var dataSampleArrival = [
                            {
                                "Departure_Code": 'THR',
                                "Departure_City": "تهران"
                            },
                            {
                                "Departure_Code": 'MHD',
                                "Departure_City": "مشهد"
                            },
                            {
                                "Departure_Code": 'SYZ',
                                "Departure_City": "شیراز"
                            },
                            {
                                "Departure_Code": 'KIH',
                                "Departure_City": "کیش"
                            },
                            {
                                "Departure_Code": 'IFN',
                                "Departure_City": "اصفهان"
                            },
                            {
                                "Departure_Code": 'TBZ',
                                "Departure_City": "تبریز"
                            },
                            {
                                "Departure_Code": 'GSM',
                                "Departure_City": "قشم"
                            },
                            {
                                "Departure_Code": 'BND',
                                "Departure_City": "بندرعباس"
                            },
                            {
                                "Departure_Code": 'KSH',
                                "Departure_City": "کرمانشاه"
                            },
                            {
                                "Departure_Code": 'AWZ',
                                "Departure_City": "اهواز"
                            }];
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            results = dataSampleArrival;
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Local',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].Departure_Code.toLowerCase().indexOf(query) >= 0 || data[i].Departure_City.toLowerCase().indexOf(query) >= 0 || data[i].Departure_CityEn.toLowerCase().toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].Departure_City);
                                inputValue.push(value[i].Departure_Code);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Destination').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Destination').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Destination').find('input').attr('id', 'ArrivalCode');

                            $$('#autocomplete-standalone-Destination').find('input').attr('name', 'ArrivalCode');
                        },
                    },
                });

                var autocompleteStandaloneAjax3 = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Origin-foreign', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: true,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'DepartureCode', //object's "value" property name
                    textProperty: 'DepartureCityFa', //object's "text" property name
                    limit: 150,
                    preloader: true, //enable preloader
                    source: function (query, render) {
                        var autocomplete = this;
                        var results = [];
                        var resultCustom  = [];
                        if (query.length === 0) {
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Foreign',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                console.log(data)
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].DepartureCode.indexOf(query) >= 0 || data[i].DepartureCityFa.toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items


                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].DepartureCityFa);
                                inputValue.push(value[i].DepartureCode);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Origin-foreign').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Origin-foreign').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Origin-foreign').find('input').attr('id', 'DepartureCode');

                            $$('#autocomplete-standalone-Origin-foreign').find('input').attr('name', 'DepartureCode');
                        },
                    },
                });

                var autocompleteStandaloneAjax4 = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Destination-foreign', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: true,
                    searchbarPlaceholder: 'شهر مقصد را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'DepartureCode', //object's "value" property name
                    textProperty: 'DepartureCityFa', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    source: function (query, render) {
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Foreign',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].DepartureCode.indexOf(query) >= 0 || data[i].DepartureCityFa.toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].DepartureCityFa);
                                inputValue.push(value[i].DepartureCode);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Destination-foreign').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Destination-foreign').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Destination-foreign').find('input').attr('id', 'ArrivalCode');

                            $$('#autocomplete-standalone-Destination-foreign').find('input').attr('name', 'ArrivalCode');
                        },
                    },
                });



                //for search Internal Hotel
                var today = new Date();
                var weekLater = new Date().setDate(today.getDate());
                var deptCalendarHotel = app.calendar.create({
                    calendarType: 'jalali',
                    weekendDays: [1],
                    firstDay: 7,
                    monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    inputEl: '#shamsiDeptCalendarToCalculateNights',
                    disabled: {
                        to: weekLater
                    },
                    minDate: weekLater,
                    closeOnSelect: true,
                    on: {
                        dayClick: function (a, b, c, d, e) {
                            $$("#shamsiReturnCalendarToCalculateNights").val('');
                            if ($$(".hidden-bargasht-hotel").val() == 0) {
                                $$(".hidden-bargasht-hotel").val("1");
                            } else {
                                returnCalendarHotel.destroy();
                            }
                            dd = d + 1;
                            var dateMiladi = jalali_to_gregorian(c, dd, e);
                            var month = dateMiladi[1] - 1;
                            var day = dateMiladi[2];
                            var dateTo = new Date(dateMiladi[0], month, day);

                            returnCalendarHotel = app.calendar.create({
                                calendarType: 'jalali',
                                inputEl: '#shamsiReturnCalendarToCalculateNights',

                                disabled: {
                                    to: dateTo
                                },
                                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                dayNames: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                dayNamesShort: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                firstDay: 7, // Saturday
                                weekendDays: [1], // Friday
                                closeOnSelect: true,
                                on: {
                                    dayClick: function (a, b, y, m, d) {

                                        var deptCalendar = $$("#shamsiDeptCalendarToCalculateNights").val();
                                        var arrayStartDate = deptCalendar.split('-');
                                        var startDate_y = parseInt(arrayStartDate[0]);
                                        if (parseInt(arrayStartDate[1]) < 10) {
                                            var startDate_m = parseInt(arrayStartDate[1].substr(1, 1));
                                        } else {
                                            var startDate_m = parseInt(arrayStartDate[1]);
                                        }
                                        if (parseInt(arrayStartDate[2]) < 10) {
                                            var startDate_d = parseInt(arrayStartDate[2].substr(1, 1));
                                        } else {
                                            var startDate_d = parseInt(arrayStartDate[2]);
                                        }

                                        var startDateGreg = jalali_to_gregorian(startDate_y, startDate_m, startDate_d);
                                        var mm = m + 1;
                                        var endDateGreg = jalali_to_gregorian(y, mm, d);

                                        var startDate = new Date(startDateGreg[0], startDateGreg[1], startDateGreg[2]);
                                        var endDate = new Date(endDateGreg[0], endDateGreg[1], endDateGreg[2]);

                                        var fullDaysSinceEpochStart = Math.floor(startDate / 8.64e7);
                                        var fullDaysSinceEpochEnd = Math.floor(endDate / 8.64e7);
                                        var dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

                                        $$('.staying-time').addClass('active-night');
                                        $$('.staying-time').html('<span>' + dayDiff + ' شب' + '</span>');
                                        $$("#nights").val(dayDiff);


                                    }
                                }

                            });

                        }
                    }

                });

                if ($$(".hidden-raft-hotel").val() == 0) {
                    $$(".hidden-raft-hotel").val("1");
                } else {
                    deptCalendarHotel.destroy();
                }

                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#search-city-hotel', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'id', //object's "value" property name
                    textProperty: 'name', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        var dataSample = [
                            {
                                "id": '1',
                                "name": "تهران"
                            },
                            {
                                "id": '66',
                                "name": "مشهد"
                            },
                            {
                                "id": '8',
                                "name": "شیراز"
                            },
                            {
                                "id": '56',
                                "name": "کیش"
                            },
                            {
                                "id": '2',
                                "name": "اصفهان"
                            },
                            {
                                "id": '6',
                                "name": "تبریز"
                            },
                            {
                                "id": '10',
                                "name": "قشم"
                            },
                            {
                                "id": '26',
                                "name": "بندرعباس"
                            },
                            {
                                "id": '75',
                                "name": "کرمانشاه"
                            }];
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            results = dataSample;
                            render(results);
                            return;
                        }

                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../hotel_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: 'getAllCity',
                                cityName: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].name.indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].name);
                                inputValue.push(value[i].id);
                            }
                            // Add item text value to item-after
                            $$('#search-city-hotel').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#search-city-hotel').find('input').val(inputValue.join(', '));

                            $$('#search-city-hotel').find('input').attr('id', 'id');

                            $$('#search-city-hotel').find('input').attr('name', 'name');
                        }
                    }
                });
                // end search Internal Hotel

            },
        }
    },
    {
        path: '/ruls',
        url: './pages/Ruls.php'

    },  {
        path: '/PdfViewer',
        url: './pages/flight/PdfViewer.php'

    },
    {
        path: '/message',
        url: './pages/Message.php'

    },
    {
        path: '/contactus',
        url: './pages/ContactUs.php'
    },
    {
        path: '/aboutMe',
        url: './pages/AboutMe.php'

    },
    {
        path: '/ticketHistory',
        url: './pages/flight/TicketHistoryApp.php'

    },
    {
        path: '/requestOfflineTicket',
        url: './pages/flight/requestOfflineTicket.php'

    },
    {
        path: '/showTicket',
        url: './pages/flight/ShowTicket.php'

    },
    {
        path: '/cancelTicket',
        url: './pages/flight/CancelTicketApp.php'

    },
    {
        path: '/SearchInternalApp/',
        url: './pages/flight/SearchInternalApp.php',
        on: {
            pageInit: function (event, page) {
                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Origin', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید(تهران-THR-TEHRAN)',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'Departure_Code', //object's "value" property name
                    textProperty: 'Departure_City', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        query = query.toLowerCase();
                        var dataSample = [
                            {
                                "Departure_Code": 'THR',
                                "Departure_City": "تهران"
                            },
                            {
                                "Departure_Code": 'MHD',
                                "Departure_City": "مشهد"
                            },
                            {
                                "Departure_Code": 'SYZ',
                                "Departure_City": "شیراز"
                            },
                            {
                                "Departure_Code": 'KIH',
                                "Departure_City": "کیش"
                            },
                            {
                                "Departure_Code": 'IFN',
                                "Departure_City": "اصفهان"
                            },
                            {
                                "Departure_Code": 'TBZ',
                                "Departure_City": "تبریز"
                            },
                            {
                                "Departure_Code": 'GSM',
                                "Departure_City": "قشم"
                            },
                            {
                                "Departure_Code": 'BND',
                                "Departure_City": "بندرعباس"
                            },
                            {
                                "Departure_Code": 'KSH',
                                "Departure_City": "کرمانشاه"
                            },
                            {
                                "Departure_Code": 'AWZ',
                                "Departure_City": "اهواز"
                            }];
                        var autocomplete = this;
                        var results = [];


                        if (query.length === 0) {
                            results = dataSample;
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Local',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].Departure_Code.toLowerCase().indexOf(query) >= 0 || data[i].Departure_City.toLowerCase().indexOf(query) >= 0 || data[i].Departure_CityEn.toLowerCase().toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            console.log(value);
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].Departure_City);
                                inputValue.push(value[i].Departure_Code);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Origin').find('.item-after').text(itemText.join('- '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Origin').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Origin').find('input').attr('id', 'DepartureCode');

                            $$('#autocomplete-standalone-Origin').find('input').attr('name', 'DepartureCode');
                        },
                    },
                });
                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Destination', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مقصد را وارد کنید(تهران-THR-TEHRAN)',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'Departure_Code', //object's "value" property name
                    textProperty: 'Departure_City', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        query = query.toLowerCase();
                        var dataSampleArrival = [
                            {
                                "Departure_Code": 'THR',
                                "Departure_City": "تهران"
                            },
                            {
                                "Departure_Code": 'MHD',
                                "Departure_City": "مشهد"
                            },
                            {
                                "Departure_Code": 'SYZ',
                                "Departure_City": "شیراز"
                            },
                            {
                                "Departure_Code": 'KIH',
                                "Departure_City": "کیش"
                            },
                            {
                                "Departure_Code": 'IFN',
                                "Departure_City": "اصفهان"
                            },
                            {
                                "Departure_Code": 'TBZ',
                                "Departure_City": "تبریز"
                            },
                            {
                                "Departure_Code": 'GSM',
                                "Departure_City": "قشم"
                            },
                            {
                                "Departure_Code": 'BND',
                                "Departure_City": "بندرعباس"
                            },
                            {
                                "Departure_Code": 'KSH',
                                "Departure_City": "کرمانشاه"
                            },
                            {
                                "Departure_Code": 'AWZ',
                                "Departure_City": "اهواز"
                            }];
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            results = dataSampleArrival;
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Local',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].Departure_Code.toLowerCase().indexOf(query) >= 0 ||  data[i].Departure_City.toLowerCase().indexOf(query) >= 0 || data[i].Departure_CityEn.toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].Departure_City);
                                inputValue.push(value[i].Departure_Code);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Destination').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Destination').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Destination').find('input').attr('id', 'ArrivalCode');

                            $$('#autocomplete-standalone-Destination').find('input').attr('name', 'ArrivalCode');
                        },
                    },
                });
            },
        }

    },
    {
        path: '/SearchForeignApp/',
        url: './pages/flight/SearchForeignApp.php',
        on: {
            pageInit: function (event, page) {
                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Origin-foreign', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: true,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'DepartureCode', //object's "value" property name
                    textProperty: 'DepartureCityFa', //object's "text" property name
                    limit: 150,
                    preloader: true, //enable preloader
                    source: function (query, render) {
                        query = query.toLowerCase();
                        var autocomplete = this;
                        var results = [];
                        var resultCustom  = [];
                        if (query.length === 0) {
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Foreign',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].DepartureCode.indexOf(query) >= 0 || data[i].DepartureCityFa.toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items


                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].DepartureCityFa);
                                inputValue.push(value[i].DepartureCode);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Origin-foreign').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Origin-foreign').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Origin-foreign').find('input').attr('id', 'DepartureCode');

                            $$('#autocomplete-standalone-Origin-foreign').find('input').attr('name', 'DepartureCode');
                        },
                    },
                });




                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#autocomplete-standalone-Destination-foreign', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: true,
                    searchbarPlaceholder: 'شهر مقصد را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'DepartureCode', //object's "value" property name
                    textProperty: 'DepartureCityFa', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    source: function (query, render) {
                        query = query.toLowerCase();
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            render(results);
                            return;
                        }

                        var TypeZone = $$('#TypeZoneFlight').val();
                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../user_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: TypeZone,
                                Type: 'Foreign',
                                Code: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].DepartureCode.indexOf(query) >= 0 || data[i].DepartureCityFa.toLowerCase().indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].DepartureCityFa);
                                inputValue.push(value[i].DepartureCode);
                            }
                            // Add item text value to item-after
                            $$('#autocomplete-standalone-Destination-foreign').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#autocomplete-standalone-Destination-foreign').find('input').val(inputValue.join(', '));

                            $$('#autocomplete-standalone-Destination-foreign').find('input').attr('id', 'ArrivalCode');

                            $$('#autocomplete-standalone-Destination-foreign').find('input').attr('name', 'ArrivalCode');
                        },
                    },
                });
            },
        }

    },
    {
        path: '/TicketInternalApp/',
        url: './pages/flight/TicketInternalApp.php',
        on: {
            pageInit: function (event, page) {

                var origin = $$('#origin').val();
                var destination = $$('#destination').val();
                var dept_date = $$('#dept_date').val();
                var return_date = $$('#return_date').val();
                var classf = "Y";
                var adult = $$('#adult').val();
                var child = $$('#child').val();
                var infant = $$('#infant').val();
                var foreign = $$('#foreign').val();
                app.request({
                    url: '../user_ajax.php',
                    method: 'post',
                    dataType: 'json',
                    //send "query" to server. Useful in case you generate response dynamically
                    data: {
                        flag: 'getResultTicketLocalApp',
                        origin: origin,
                        destination: destination,
                        dept_date: dept_date,
                        return_date: return_date,
                        classf: classf,
                        adult: adult,
                        child: child,
                        infant: infant,
                        foreign: foreign,
                    },
                    success: function (data) {
                        $$('.first-preloader').show(); //var app is initialized by now
                        setTimeout(function () {
                            $$('.first-preloader').addClass("hide");
                            $$('#TicketInternal').html('');
                            $$('#TicketInternal').html(data);
                        }, 1000);

                    }
                });
            }
        }
    },
    {
        path: '/TicketForeignApp/',
        url: './pages/flight/TicketForeignApp.php',
        on: {
            pageInit: function (event, page) {

                var origin = $$('#origin').val();
                var destination = $$('#destination').val();
                var dept_date = $$('#dept_date').val();
                var return_date = $$('#return_date').val();
                var classf = "Y";
                var adult = $$('#adult').val();
                var child = $$('#child').val();
                var infant = $$('#infant').val();
                var foreign = $$('#foreign').val();
                app.request({
                    url: '../user_ajax.php',
                    method: 'post',
                    dataType: 'json',
                    //send "query" to server. Useful in case you generate response dynamically
                    data: {
                        flag: 'getResultTicketForeignApp',
                        origin: origin,
                        destination: destination,
                        dept_date: dept_date,
                        return_date: return_date,
                        classf: classf,
                        adult: adult,
                        child: child,
                        infant: infant,
                        foreign: foreign,
                    },
                    success: function (data) {
                        $$('.first-preloader').show(); //var app is initialized by now
                        setTimeout(function () {
                            $$('.first-preloader').addClass("hide");
                            $$('#TicketInternal').html('');
                            $$('#TicketInternal').html(data);
                        }, 1000);

                    }
                });
            }
        },
    },
    {
        path: '/TicketDetailApp/',
        url: './pages/flight/TicketDetailApp.php',
        on: {
            pageInit: function (event, page) {


            }
        }
    },
    {
        path: '/ChooseBank/',
        url: './pages/ChooseBank.php',
        on: {
            pageInit: function (event, page) {
                $$('.pay-method-checkbox').on('change', function (ev) {
                    if ($$(this).val() == 'online') {
                        if ($$(this).parents('.choose-bank').find('.banks-method').hasClass('myhidden')) {
                            $$(this).parents('.choose-bank').find('.banks-method').removeClass('myhidden');
                        }
                        if ($$(this).parents('.blit-info-page').find('.online-pay').hasClass('myhidden')) {
                            $$(this).parents('.blit-info-page').find('.online-pay').removeClass('myhidden');
                        }
                        if (!$$(this).parents('.blit-info-page').find('.etebari-pay').hasClass('myhidden')) {
                            $$(this).parents('.blit-info-page').find('.etebari-pay').addClass('myhidden');
                        }
                    }
                    if ($$(this).val() == 'credit') {
                        if (!$$(this).parents('.choose-bank').find('.banks-method').hasClass('myhidden')) {
                            $$(this).parents('.choose-bank').find('.banks-method').addClass('myhidden');
                        }
                        if (!$$(this).parents('.blit-info-page').find('.online-pay').hasClass('myhidden')) {
                            $$(this).parents('.blit-info-page').find('.online-pay').addClass('myhidden');
                        }
                        if ($$(this).parents('.blit-info-page').find('.etebari-pay').hasClass('myhidden')) {
                            $$(this).parents('.blit-info-page').find('.etebari-pay').removeClass('myhidden');
                        }

                    }
                });


            }
        }
    },
    {
        path: '/login/',
        url: './pages/login.php'
    },
    {
        path: '/Register/',
        url: './pages/Register.php'
    },
    {
        path: '/Gobank/',
        url: './pages/Gobank.php'
    },
    {
        path: '/PassengersDetailApp/',
        url: './pages/flight/PassengersDetailApp.php',
        on: {
            pageInit: function (event, page) {

                var now = new Date();
                var today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                var passportengheza = app.calendar.create({
                    disabled: {
                        to: today,
                    },
                    inputEl: '.passportengheza',
                    closeOnSelect: true,
                });

                $$('.nationality-choose').on('change', function (ev) {
                    var TypeFlight = $$('#TypeZoneFlightDetail').val();
                    if ($$(this).val() == '0' || TypeFlight=='Foreign') {
                        if ($$(this).parents('.list-passenger ul').find('.shamsi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.shamsi-bd').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.code-melli').removeClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.miladi-bd').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.country-passport').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportNumber').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportExpire').addClass('myhidden');
                        }
                    }
                    if ($$(this).val() == '1' && TypeFlight !='Foreign') {
                        if (!$$(this).parents('.list-passenger ul').find('.shamsi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.shamsi-bd').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.code-melli').addClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.miladi-bd').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.country-passport').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportNumber').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportExpire').removeClass('myhidden');
                        }

                    }
                });
            },
        }
    },
    {
        path: '/TicketFactor/',
        url: './pages/flight/TicketFactor.php',
    },
    {
        path: '/searchInternalHotel/',
        url: './pages/hotel/searchInternalHotel.php',
        on: {
            pageInit: function (event, page) {


                var today = new Date();
                var weekLater = new Date().setDate(today.getDate());
                var deptCalendarHotel = app.calendar.create({
                    calendarType: 'jalali',
                    weekendDays: [1],
                    firstDay: 7,
                    monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                    dayNames: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    dayNamesShort: ['شنبه', 'یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'],
                    inputEl: '#shamsiDeptCalendarToCalculateNights',
                    disabled: {
                        to: weekLater
                    },
                    minDate: weekLater,
                    closeOnSelect: true,
                    on: {
                        dayClick: function (a, b, c, d, e) {
                            $$("#shamsiReturnCalendarToCalculateNights").val('');
                            if ($$(".hidden-bargasht-input").val() == 0) {
                                $$(".hidden-bargasht-input").val("1");
                            } else {
                                returnCalendarHotel.destroy();
                            }
                            dd = d + 1;
                            var dateMiladi = jalali_to_gregorian(c, dd, e);
                            var month = dateMiladi[1] - 1;
                            var day = dateMiladi[2];
                            var dateTo = new Date(dateMiladi[0], month, day);

                            returnCalendarHotel = app.calendar.create({
                                calendarType: 'jalali',
                                inputEl: '#shamsiReturnCalendarToCalculateNights',

                                disabled: {
                                    to: dateTo
                                },
                                monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                monthNamesShort: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
                                dayNames: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                dayNamesShort: ['یک‌شنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'],
                                firstDay: 7, // Saturday
                                weekendDays: [1], // Friday
                                closeOnSelect: true,
                                on: {
                                    dayClick: function (a, b, y, m, d) {

                                        var deptCalendar = $$("#shamsiDeptCalendarToCalculateNights").val();
                                        var arrayStartDate = deptCalendar.split('-');
                                        var startDate_y = parseInt(arrayStartDate[0]);
                                        if (parseInt(arrayStartDate[1]) < 10) {
                                            var startDate_m = parseInt(arrayStartDate[1].substr(1, 1));
                                        } else {
                                            var startDate_m = parseInt(arrayStartDate[1]);
                                        }
                                        if (parseInt(arrayStartDate[2]) < 10) {
                                            var startDate_d = parseInt(arrayStartDate[2].substr(1, 1));
                                        } else {
                                            var startDate_d = parseInt(arrayStartDate[2]);
                                        }

                                        var startDateGreg = jalali_to_gregorian(startDate_y, startDate_m, startDate_d);
                                        var mm = m + 1;
                                        var endDateGreg = jalali_to_gregorian(y, mm, d);

                                        var startDate = new Date(startDateGreg[0], startDateGreg[1], startDateGreg[2]);
                                        var endDate = new Date(endDateGreg[0], endDateGreg[1], endDateGreg[2]);

                                        var fullDaysSinceEpochStart = Math.floor(startDate / 8.64e7);
                                        var fullDaysSinceEpochEnd = Math.floor(endDate / 8.64e7);
                                        var dayDiff = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

                                        $$('.staying-time').addClass('active-night');
                                        $$('.staying-time').html('<span>' + dayDiff + ' شب' + '</span>');
                                        $$("#nights").val(dayDiff);


                                    }
                                }

                            });

                        }
                    }

                });

                if ($$(".hidden-raft-input").val() == 0) {
                    $$(".hidden-raft-input").val("1");
                } else {
                    deptCalendarHotel.destroy();
                }

                var autocompleteStandaloneAjax = app.autocomplete.create({
                    openIn: 'page', //open in page
                    openerEl: '#search-city-hotel', //link that opens autocomplete
                    popupCloseLinkText: 'بستن',
                    autoFocus: false,
                    searchbarPlaceholder: 'شهر مبدا را وارد کنید',
                    searchbarDisableText: 'پاک کردن',
                    closeOnSelect: true, //go back after we select something
                    multiple: false, //allow multiple values
                    valueProperty: 'id', //object's "value" property name
                    textProperty: 'name', //object's "text" property name
                    limit: 50,
                    preloader: true, //enable preloader
                    requestSourceOnOpen: true,
                    source: function (query, render) {
                        var dataSample = [
                            {
                                "id": '1',
                                "name": "تهران"
                            },
                            {
                                "id": '66',
                                "name": "مشهد"
                            },
                            {
                                "id": '8',
                                "name": "شیراز"
                            },
                            {
                                "id": '56',
                                "name": "کیش"
                            },
                            {
                                "id": '2',
                                "name": "اصفهان"
                            },
                            {
                                "id": '6',
                                "name": "تبریز"
                            },
                            {
                                "id": '10',
                                "name": "قشم"
                            },
                            {
                                "id": '26',
                                "name": "بندرعباس"
                            },
                            {
                                "id": '75',
                                "name": "کرمانشاه"
                            }];
                        var autocomplete = this;
                        var results = [];
                        if (query.length === 0) {
                            results = dataSample;
                            render(results);
                            return;
                        }

                        // Show Preloader
                        autocomplete.preloaderShow();
                        // Do Ajax request to Autocomplete data
                        app.request({
                            url: '../hotel_ajax.php',
                            method: 'post',
                            dataType: 'json',
                            //send "query" to server. Useful in case you generate response dynamically
                            data: {
                                flag: 'getAllCity',
                                cityName: query
                            },
                            success: function (data) {
                                // data = $$.getJSON(data);
                                // Find matched items
                                for (var i = 0; i < data.length; i++) {
                                    if (data[i].name.indexOf(query) >= 0) {
                                        results.push(data[i]);
                                    }
                                }
                                // Hide Preoloader
                                autocomplete.preloaderHide();
                                // Render items by passing array with result items

                                render(results);
                            }
                        });
                    },
                    on: {
                        change: function (value) {
                            var itemText = [],
                                inputValue = [];
                            for (var i = 0; i < value.length; i++) {
                                itemText.push(value[i].name);
                                inputValue.push(value[i].id);
                            }
                            // Add item text value to item-after
                            $$('#search-city-hotel').find('.item-after').text(itemText.join(', '));
                            // Add item value to input value
                            $$('#search-city-hotel').find('input').val(inputValue.join(', '));

                            $$('#search-city-hotel').find('input').attr('id', 'id');

                            $$('#search-city-hotel').find('input').attr('name', 'name');
                        }
                    }
                });

            }
        }
    },
    {
        path: '/searchHotel/',
        url: './pages/hotel/hotelList.php',
        on: {
            pageInit: function (event, page) {

                // نمایش لیست هتل ها
                showListHotel();



                app.picker.create({
                    inputEl: '#blit-hotel-sorting',
                    toolbarCloseText: 'بستن',
                    cols: [
                        {
                            textAlign: 'center',
                            values: ['بیشترین ستاره', 'کمترین ستاره', 'بیشترین قیمت', 'کمترین قیمت'],
                            onChange: function (picker, value) {
                                //alert(value);
                                picker.setValue(value);
                                sortHotel(value);
                            }
                        }
                    ]
                });





            }
        }
    },
    {
        path: '/hotelDetail/',
        url: './pages/hotel/hotelDetail.php',
        on: {
            pageInit: function (event, page) {

                $$('.my-sheet').on('sheet:open', function (e, sheet) {
                    $$('.sheet-modal-bg').toggleClass('sm-show');
                });
                $$('.sheet-modal-bg').on('click', clickHandler);

                function clickHandler() {
                    $$('.sheet-modal-bg').removeClass('sm-show');
                    app.sheet.close('.my-sheet');
                };

                $$('.my-sheet').on('sheet:close', function (e, sheet) {
                    $$('.sheet-modal-bg').removeClass('sm-show');
                });

                $$('.hotel-room-auto .hri-rezerv span').on('click', function () {
                    $$(this).parents('.hotel-room-item').addClass('choosen-room-rezervasyon');
                    $$(this).addClass('myhidden');
                    $$(this).parents('.hotel-room-item').find('.hri-rezerv .change-room-number').removeClass('myhidden');
                });

                $$('.hotel-room-item .stepper-input-wrap input ').on('change', function () {
                    if ($$(this).val() == 0) {
                        $$(this).parents('.hotel-room-item').removeClass('choosen-room-rezervasyon');
                        $$(this).parents('.hotel-room-item').find('.hri-rezerv span').removeClass('myhidden');
                        $$(this).parents('.hotel-room-item').find('.change-room-number').addClass('myhidden');
                        //$$('.continue-rezerv-hotel').addClass('myhidden');

                    }
                });

            },

        }
    },
    {
        path: '/passengerHotel/',
        url: './pages/hotel/passengerHotel.php',
        on: {
            pageInit: function (event, page) {


                $$('.nationality-choose').on('change', function (ev) {

                    if ($$(this).val() == '0') {
                        if ($$(this).parents('.list-passenger ul').find('.shamsi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.shamsi-bd').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.code-melli').removeClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.miladi-bd').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.country-passport').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportNumber').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportExpire').addClass('myhidden');
                        }
                    }
                    if ($$(this).val() == '1') {
                        if (!$$(this).parents('.list-passenger ul').find('.shamsi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.shamsi-bd').addClass('myhidden');
                        }
                        if (!$$(this).parents('.list-passenger ul').find('.code-melli').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.code-melli').addClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.miladi-bd').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.miladi-bd').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.country-passport').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.country-passport').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.passportNumber').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportNumber').removeClass('myhidden');
                        }
                        if ($$(this).parents('.list-passenger ul').find('.passportExpire').hasClass('myhidden')) {
                            $$(this).parents('.list-passenger ul').find('.passportExpire').removeClass('myhidden');
                        }

                    }
                });


            }
        }
    },
    {
        path: '/factorHotel/',
        url: './pages/hotel/factorHotel.php'
    },
    {
        path: '/hotelHistory',
        url: './pages/hotel/hotelHistory.php'

    },
    {
        path: '/hotelBookingInfo',
        url: './pages/hotel/hotelBookingInfo.php'

    },
    {
        path: '/sendCode/',
        url: './pages/sendCode.php'

    },
    {
        path: '/getCode/',
        url: './pages/getCode.php'

    }
];
