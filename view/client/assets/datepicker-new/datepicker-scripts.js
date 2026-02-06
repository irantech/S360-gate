function e(n) {
    setTimeout(function() {
        var i = $(n).datepicker("widget").find(".ui-datepicker-buttonpane"),
            t = $('<button class="btn" type="button"><\/button>');
        $.cookie("datepickerRegional") == null || $.cookie("datepickerRegional") == "fa" ? (t.html('میلادی'), t.attr("data-regional", "en")) : (t.html('شمسی'), t.attr("data-regional", "fa"));
        t.unbind("click").bind("click", function() {
            var t = $(this).attr("data-regional");
            $.cookie("datepickerRegional") == null && $.cookie("datepickerRegional", "fa", {
                path: "/",
                expires: 365
            });
            t == "en" ? ($.cookie("datepickerRegional", "en", {
                path: "/",
                expires: 365
            }), o("en")) : ($.cookie("datepickerRegional", "fa", {
                path: "/",
                expires: 365
            }), o("fa"));
            $(n).datepicker("hide");
            $(n).datepicker("show")
        });
        t.appendTo(i)
    }, 1)
}

function o(n) {
    $(".hasDatepicker").each(function(t, i) {
        var r = $(i),
            s = r.datepicker("option", "dateFormat"),
            u = r.datepicker("option", "dateFormat", "yy/mm/dd").val(),
            e = r.datepicker("option", "maxDate"),
            o = r.datepicker("option", "minDate");
        r.datepicker("option", "maxDate", null);
        r.datepicker("option", "minDate", null);
        n === "en" ? (r.datepicker("option", $.datepicker.regional[""]), u && (u.substr(0, 2) === "13" || u.substr(0, 2) === "14") && r.datepicker("setDate", new Date(f(u.split("/")).join("/"))), e && (e.substr(0, 2) === "13" || e.substr(0, 2) === "14") && r.datepicker("option", "maxDate", new Date(f(e.split("/")).join("/"))), o && (o.substr(0, 2) === "13" || o.substr(0, 2) === "14") && r.datepicker("option", "minDate", new Date(f(o.split("/")).join("/"))), s && r.datepicker("option", "dateFormat", s)) : (r.datepicker("option", $.datepicker.regional.fa), u && (u.substr(0, 2) === "19" || u.substr(0, 2) === "20") && r.datepicker("setDate", new Date(u)), e && (e.substr(0, 2) === "19" || e.substr(0, 2) === "20") && r.datepicker("option", "maxDate", new Date(e)), o && (o.substr(0, 2) === "19" || o.substr(0, 2) === "20") && r.datepicker("option", "minDate", new Date(o)), s && r.datepicker("option", "dateFormat", s))
    })
}
function n(n, t) {
    return n - t * Math.floor(n / t)
}

function s(n) {
    return n % 4 == 0 && !(n % 100 == 0 && n % 400 != 0)
}

function t(n, t, i) {
    return GREGORIAN_EPOCH - 1 + 365 * (n - 1) + Math.floor((n - 1) / 4) + -Math.floor((n - 1) / 100) + Math.floor((n - 1) / 400) + Math.floor((367 * t - 362) / 12 + (t <= 2 ? 0 : s(n) ? -1 : -2) + i)
}

function r(i) {
    var u, f, l, e, o, h, a, v, c, r, y, p;
    return u = Math.floor(i - .5) + .5, f = u - GREGORIAN_EPOCH, l = Math.floor(f / 146097), e = n(f, 146097), o = Math.floor(e / 36524), h = n(e, 36524), a = Math.floor(h / 1461), v = n(h, 1461), c = Math.floor(v / 365), r = l * 400 + o * 100 + a * 4 + c, o == 4 || c == 4 || r++, y = u - t(r, 1, 1), p = u < t(r, 3, 1) ? 0 : s(r) ? 1 : 2, month = Math.floor(((y + p) * 12 + 373) / 367), day = u - t(r, month, 1) + 1, [r, month, day]
}

function c(n) {
    return ((n - (n > 0 ? 474 : 473)) % 2820 + 474 + 38) * 682 % 2816 < 682
}

function i(t, i, r) {
    var u, f;
    return u = t - (t >= 0 ? 474 : 473), f = 474 + n(u, 2820), r + (i <= 7 ? (i - 1) * 31 : (i - 1) * 30 + 6) + Math.floor((f * 682 - 110) / 2816) + (f - 1) * 365 + Math.floor(u / 2820) * 1029983 + (PERSIAN_EPOCH - 1)
}

function u(t) {
    var r, e, c, o, l, u, s, h, a, f;
    return t = Math.floor(t) + .5, o = t - i(475, 1, 1), l = Math.floor(o / 1029983), u = n(o, 1029983), u == 1029982 ? s = 2820 : (h = Math.floor(u / 366), a = n(u, 366), s = Math.floor((2134 * h + 2816 * a + 2815) / 1028522) + h + 1), r = s + 2820 * l + 474, r <= 0 && r--, f = t - i(r, 1, 1) + 1, e = f <= 186 ? Math.ceil(f / 31) : Math.ceil((f - 6) / 30), c = t - i(r, e, 1) + 1, [r, e, c]
}

function f(n) {
    return r(i(+n[0], +n[1], +n[2]))
}
$.cookie("datepickerRegional", "fa", {
    path: "/"
});

// window.addEventListener('load', function (e) {
//     let datePicker = document.querySelector('.ui-datepicker');
//
//     const observer = new MutationObserver(() => {
//         observer.disconnect();
//
//         console.log('changed');
//         const miladi = document.querySelector('.ui-datepicker-buttonpane .btn[data-regional="en"]');
//         const shamsi = document.querySelector('.ui-datepicker-buttonpane .btn[data-regional="fa"]');
//
//         if (shamsi) {
//             document.querySelectorAll('.ui-widget-content .ui-state-default').forEach(el => {
//                 el.classList.add('robotoFont');
//             });
//             document.querySelectorAll('.ui-datepicker-year').forEach(el => {
//                 el.classList.add('robotoFont');
//             });
//         } else if (miladi) {
//             document.querySelectorAll('.ui-widget-content .ui-state-default').forEach(el => {
//                 el.classList.remove('robotoFont');
//             });
//             document.querySelectorAll('.ui-datepicker-year').forEach(el => {
//                 el.classList.remove('robotoFont');
//             });
//         }
//
//         observer.observe(datePicker, {
//             childList: true,
//             attributes: true,
//             subtree: true,
//             characterData: true
//         });
//     });
//
//     observer.observe(datePicker, {
//         childList: true,
//         attributes: true,
//         subtree: true,
//         characterData: true
//     });
// });
