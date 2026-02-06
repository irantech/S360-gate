function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

const vv = async () => {


    setCookie("pwa-app","set",30);
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js?v211', {
             // <--- THIS BIT IS REQUIRED
        }).then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    }



   /* if ('serviceWorker' in navigator) {

        navigator.serviceWorker.register('/service-worker.js?v999',{
            scope: '.'
        })
          .then(function(registration) {
              registration.addEventListener('updatefound', function() {
                  // If updatefound is fired, it means that there's
                  // a new service worker being installed.
                  var installingWorker = registration.installing;
                  console.log('A new service worker is being installed:',
                    installingWorker);

                  // You can listen for changes to the installing service worker's
                  // state via installingWorker.onstatechange
              });
          })
          .catch(function(error) {
              console.log('Service worker registration failed:', error);
          });
    } else {
        console.log('Service workers are not supported.');
    }*/

};

// ...

vv();
function addMonths(d,n){
    var dt=new Date(d.getTime());
    dt.setMonth(dt.getMonth()+n);
    return dt;
}

function dateNow(mode,next_month=null) {

    let dateNow = new Date()
    if(next_month){
        dateNow=addMonths(dateNow,3);
    }
    dateNow=dateNow.toLocaleDateString('fa-IR').replace(/([۰-۹])/g, token => String.fromCharCode(token.charCodeAt(0) - 1728));
    let dateNowSplit = [];
    let year = '';
    let month = '';
    let day = '';

    dateNowSplit = dateNow.split('/');

    year = dateNowSplit[0];
    month = (parseInt(dateNowSplit[1]) <= 9) ? '0' + dateNowSplit[1] : dateNowSplit[1];
    day = (parseInt(dateNowSplit[2]) <= 9) ? '0' + dateNowSplit[2] : dateNowSplit[2];
    return year + mode + month + mode + day

}

jalaliObject = {
    g_days_in_month: [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
    j_days_in_month: [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29]
};
jalaliObject.jalaliToGregorian = function(j_y, j_m, j_d) {
    j_y = parseInt(j_y);
    j_m = parseInt(j_m);
    j_d = parseInt(j_d);
    var jy = j_y - 979;
    var jm = j_m - 1;
    var jd = j_d - 1;

    var j_day_no = 365 * jy + parseInt(jy / 33) * 8 + parseInt((jy % 33 + 3) / 4);
    for (var i = 0; i < jm; ++i) j_day_no += jalaliObject.j_days_in_month[i];

    j_day_no += jd;

    var g_day_no = j_day_no + 79;

    var gy = 1600 + 400 * parseInt(g_day_no / 146097); /* 146097 = 365*400 + 400/4 - 400/100 + 400/400 */
    g_day_no = g_day_no % 146097;

    var leap = true;
    if (g_day_no >= 36525) /* 36525 = 365*100 + 100/4 */
    {
        g_day_no--;
        gy += 100 * parseInt(g_day_no / 36524); /* 36524 = 365*100 + 100/4 - 100/100 */
        g_day_no = g_day_no % 36524;

        if (g_day_no >= 365) g_day_no++;
        else leap = false;
    }

    gy += 4 * parseInt(g_day_no / 1461); /* 1461 = 365*4 + 4/4 */
    g_day_no %= 1461;

    if (g_day_no >= 366) {
        leap = false;

        g_day_no--;
        gy += parseInt(g_day_no / 365);
        g_day_no = g_day_no % 365;
    }

    for (var i = 0; g_day_no >= jalaliObject.g_days_in_month[i] + (i == 1 && leap); i++)
        g_day_no -= jalaliObject.g_days_in_month[i] + (i == 1 && leap);
    var gm = i + 1;
    var gd = g_day_no + 1;

    gm = gm < 10 ? "0" + gm : gm;
    gd = gd < 10 ? "0" + gd : gd;

    return [gy, gm, gd];
}
function jalaliToGreg(jDate,delimiter){
    if(typeof delimiter === 'undefided'){
        delimiter = '-';
    }
    dateSplitted = jDate.split(delimiter)
    gD = jalaliObject.jalaliToGregorian(dateSplitted[0], dateSplitted[1], dateSplitted[2]);
    gResult = gD[0] + "-" + gD[1] + "-" + gD[2];
    // console.log(gResult);
    return gResult;
}
function convertJalaliToGregorian(jDate,elem) {
    var date1 = elem;
    var date2 = jDate;
    // var jqXHR1 = date1
    // var jqXHR2 = date2
    // var res1 = jqXHR1.replaceAll("-", "/");
    // var res2 = jqXHR2.replaceAll("-", "/");
    // var startDate = new Date(res1);
    // var endDate = new Date(res2);
    var res1 = jalaliToGreg(date1,'-');
    var res2 = jalaliToGreg(date2,'-');
    var startDate = new Date(res1);
    var endDate = new Date(res2);

    var fullDaysSinceEpochStart = Math.floor(startDate/8.64e7);
    var fullDaysSinceEpochEnd = Math.floor(endDate/8.64e7);

    var diffTime = Math.abs(endDate - startDate);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    var result = fullDaysSinceEpochEnd - fullDaysSinceEpochStart;

    return result;

}
