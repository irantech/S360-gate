/*Global*/
var CountPicForm=0;
/* End Global */

$(document).ready(function() {

	$('.menu-login').click(function (e) {
		e.stopPropagation();
		$('.main-navigation__sub-menu2').toggleClass('active_log');
	});
$("body").click(function(){
	$('.main-navigation__sub-menu2').removeClass('active_log');
})




	$(".select2").select2();
    $('#owl-banner').owlCarousel({
        rtl: true,
        dots: false,
        loop: false,
        margin: 0,
        nav: true,
        autoplay: true,
        lazyLoad: true,
        autoplayTimeout: 30000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                nav: true,
                dots: false,
                items: 1,
            },
            600: {
                items: 1,
            },
            10000: {

                items: 1,

            }
        }
    });
    $('#owl-adv').owlCarousel({
		rtl: true,
		dots: false,
		loop: false,
		margin: 0,
		nav: true,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		responsiveClass: true,
		responsive: {
			0: {
				nav: true,
				dots: false,
				items: 1,
			},
			600: {
				items: 2,
			},
			1000: {

				items: 3,

			}
		}
	});


	var owl = $('#owl-gardesh.owl-carousel');
	 $('#owl-gardesh').owlCarousel({
		rtl: true,
		dots: false,
		loop: false,
		margin: 0,
		nav: true,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		responsiveClass: true,
		responsive: {
			0: {
				nav: true,
				dots: false,
				items: 1,
			},
			600: {
				items: 1,
			},
			1000: {

				items: 1,

			}
		}
	});
//***********************************
    $('#owl-example1').owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 0,
        padding: 0,
        nav:true,
        autoplay: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {

                items: 4,

            }
        }
    });
    $('#owl-example2').owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 0,
        padding: 0,
        nav:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {

                items: 4,

            }
        }
    });
    $('#owl-example3').owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 5,
        padding: 0,
        nav:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            }
        }
    });
    $('#owl-example4').owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 10,
        padding: 0,
        nav:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {

                items: 4,

            }
        }
    });
    $('#owl-example5').owlCarousel({
        rtl: true,
        dots:false,
        loop: true,
        margin: 0,
        padding: 0,
        nav:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {

                items: 4,

            }
        }
    });
	$('#owl-example6').owlCarousel({
		rtl: true,
		dots:false,
		loop: true,
		margin: 0,
		padding: 0,
		nav:true,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 1,
			},
			600: {
				items: 2,
			},
			1000: {

				items: 4,

			}
		}
	});
	// popup
	if($('.p-popup-container').length > 0 || $('.p-close-popup').length > 0){
		$('.p-popup-container').on("click",function(){
			$(this).fadeOut();
		});
		$('.p-close-popup').on("click",function(){
			$('.p-popup-container').fadeOut();
		});
		$('.p-popup-container .p-popup-wrapper').click(
		    function(e) {
		        e.stopPropagation();
		    }
		);
	}
	
	
	// health tour accordion
	if($('.h-a-btn').length > 0){
		$('.h-a-btn').click(function(){
			$(this).toggleClass('close-accordion');
			$(this).parent().find('.h-a-inner-items').toggleClass('h-a-open');
		})
	}


	<!--calander for reservs-->
	if($('#txtCalendarFrom1').length > 0 || $('#txtCalendarFrom2').length > 0){
		$('#txtCalendarFrom1').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#txtCalendarFrom2').datepicker({
			changeMonth: true,
			changeYear: true
		});
	}
	<!--End calander-->
	
	
	<!--calander for reservs hotel(gds)-->
	$('#startDateForHotelLocal').datepicker({
        numberOfMonths:monthNum,
        minDate:"Y/M/D",
        onSelect: function(dateText){
            $("#endDateForHotelLocal").datepicker('option', 'minDate', dateText);
        }

    });

    $('#endDateForHotelLocal').datepicker({
        numberOfMonths:monthNum,
        onSelect: function(dateText){

            var StartDate = $('#startDateForHotelLocal').val();
            var EndDate = dateText;

            var day_raft = StartDate.substr(8, 2);
            var mounth_raft = StartDate.substr(5, 2);
            var year_raft = StartDate.substr(0, 4);
            var raft = year_raft + mounth_raft + day_raft;

            var day_bargasht = EndDate.substr(8,2);
            var mounth_bargasht = EndDate.substr(5,2);
            var year_bargasht = EndDate.substr(0,4);
            var bargasht = year_bargasht + mounth_bargasht + day_bargasht;

            var lastDay=""; var  forosh_shab="";
                        
            if (mounth_raft!=mounth_bargasht)
            {
                if (mounth_raft=='12'){ 

                    // a=> تعریف متغیر برای برسی دوره ۸ ساله
                    // b=> متغیر شروع سال کبیسه
                    // year_raft=> متغیر  ساب ورودی توسط کاربر
                    var a = 0; var b = 1309 ;
                    //
                    for (var i =1309 ; i <= year_raft - 4; i += 4)
                    {
                        // اضافه کردن یک دوره سال کبیسه
                        b += 4;
                        // اضافه کردن یک دوره برای برسی دوره ۸ ساله
                        a += 1;
                        //
                        if (a % 8 == 0){ b++; }
                    }
                    // اگر عدد به دست آمده‌ی ما با سال ورودی یکسان بود آن سال کبیسه می‌باشد در غیر اینصورت کبیسه نمی‌باشد
                    if (year_raft == b){ lastDay=30; } else { lastDay=29; }

                }else if (mounth_raft<='06'){
                    lastDay=31;
                }else{
                    lastDay=30;
                }
                
                forosh_shab = parseInt(day_bargasht)+(parseInt(lastDay)-parseInt(day_raft));
            }
            else{
                forosh_shab = parseInt(day_bargasht)-parseInt(day_raft);
            }
            
            $('#ClassNightCount').removeClass("Ndisplay");
            $('#stayingTimeForHotelLocal').html(forosh_shab);
            $('#NightsForHotelLocal').attr("value",forosh_shab);
            
//            $('#stayingTimeForHotelLocal').val(forosh_shab + " شب ");

        }

    });
    <!--End calander for reservs hotel(gds)-->
	
	<!--calander for safar360 and gds search-->
	if($('.txtCalendar').length > 0 || $('.txtBirthdayCalendar').length > 0 || $('#went_date').length > 0 || $('#out_date').length > 0){
		
		if ($(window).width() > 768) {
			var monthNum = 2;
		}
		else{
			var monthNum = 1;
		}
		$('body').on('focus','.txtCalendar', function(){
			$(this).datepicker({
				minDate: "Y/M/D",
				numberOfMonths: monthNum
			});
		});
		
		$('body').on('focus','.txtBirthdayCalendar', function(){
			$(this).datepicker({
				minDate: "-100Y",
				maxDate: "Y/M/D",
				changeMonth: true,
				changeYear: true
			});
		});
	
		$("#went_date").datepicker({
			numberOfMonths:monthNum,
			minDate:"Y/M/D",
			onSelect: function(dateText){
				$("#out_date").datepicker('option', 'minDate', dateText);
			}
		});
		
		$("#out_date").datepicker({
			numberOfMonths:monthNum
		});
		
		
		//no focus datepicker
	    $(".txtCalendar, #went_date, #out_date").focus(function(){
	        $(this).blur();
	    });
	}
	<!--End calander-->
	
	
	// fancybox
	$('body').delegate('.fancybox-buttons', 'click', function(e){
	    $('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},
				afterLoad : function() {
					this.title = 'تصویر ' + (this.index + 1) + ' از ' + this.group.length + (this.title ? ' <br/>' + this.title : '');
				}
		});
    });

	// book now scroll
	if($('.m-u-book-now').length > 0){
		$(".m-u-book-now").click(function() {
		    $('html, body').animate({
		        scrollTop: $("#name-hotel").offset().top
		    }, 1000);
		});
	}
	
	// Result Ajax
	if($('.ClsBut').length > 0){
		$('.ClsBut').click(function(){
			  $('#HolderResultAjax').css('display','none');
			  $("#Result").html('');
		});
	}
	
	if($('.BottonGallery').length > 0){
		$(".BottonGallery").click(function(){
			var Id=$(this).attr("id");
			var arr=Id.split("/");
			$.post(masir_commands+"GlobalFile/Ajax.php",{"Id":arr[0],"Type":arr[1]},function(data){
				$('#HolderResultAjax').css('display','block');
				$("#Result").html(data);	
			});
		});
	}
	
	if($('#IconAppendPic').length > 0){
		$("#IconAppendPic").click(function(){
			
			CountPicForm=parseInt($('#countpic').val())+1;
			$("#AppendPic").append('<label>عکس '+CountPicForm+'</label><input type="file" value="" name="pic'+CountPicForm+'" id="pic'+CountPicForm+'" class="Left"/><span></span><div class="Clr"></div>');
			$('#countpic').val(CountPicForm);
			
		});
	}
	
	<!--Employement-->
	$("body").delegate(".m-u-del-savabegh, .m-u-del-takhasos","click",function(){
		$(this).closest('.m-u-h-s-input').remove();
	});
	
	$(".m-u-add-savabegh").click(function(){
        $("<div class='m-u-h-s-input'>"+
	        "<p><input type='text' name='experience_job_title[]' id='experience_job_title[]'></p>"+
	        "<p><input type='text' name='experience_co_name[]' id='experience_co_name[]'></p>"+
	        "<p><input type='text' name='experience_co_tel[]' id='experience_co_tel[]'></p>"+
	        "<p><input type='text' name='experience_length[]' id='experience_length[]'></p>"+
	        "<p><input type='text' name='experience_salary[]' id='experience_salary[]'></p>"+
	        "<p><input type='text' name='experience_reason[]' id='experience_reason[]'></p>"+
	        "<p> <span class='m-u-del-savabegh'></span> </p>"+
        "</div>" ).insertAfter( ".m-u-h-s-savabegh:last" );
    });
	
	$(".m-u-add-takhasos").click(function(){
        $("<div class='m-u-h-s-input m-u-h-s-specialize'>"+
	        "<p><input type='text' name='specialize_type[]' id='specialize_type[]'></p>"+
	        "<p><select name='specialize_level[]' id='specialize_level[]'>"+
	            "<option value='ضعیف'>ضعیف</option>"+
	            "<option value='متوسط'>متوسط</option>"+
	            "<option value='خوب'>خوب</option>"+
	            "<option value='عالی'>عالی</option>"+
	        "</select></p>"+
	        "<p class='last'> <span class='m-u-del-takhasos'></span> </p>"+
	   "</div>" ).insertAfter( ".m-u-h-s-specialize:last" );
    });
	<!--End Employement-->
	
	<!--Faq-->
	$('.Question').click(function(){
		var selector=$(this).siblings('.Answer');
		$('.Answer').not($(selector)).hide('slow');
		$(this).siblings('.Answer').slideToggle('slow');
	});
	<!--End Faq-->
	
	<!--Hotel in tour details-->
	$("body").delegate(".head","click",function(e)
    {
        var selected=$(this);
        selected.siblings(".extra_bed_content").fadeIn('fast');
        selected.addClass('head_active').removeClass('head');
        selected.find('.arrowdown').removeClass('arrowdown').addClass('arrowup');
    });
    $("body").delegate(".head_active","click",function(e)
    {
        var selected=$(this);
        selected.siblings(".extra_bed_content").fadeOut('fast');
        selected.addClass('head').removeClass('head_active');
        selected.find('.arrowup').removeClass('arrowup').addClass('arrowdown');
    });
	<!--End Hotel in tour details-->
	
	<!--Tabs in All Tours-->
	if($('#parentHorizontalTab').length>0){
		// Horizontal Tab
		$('#parentHorizontalTab').easyResponsiveTabs({
			type: 'default', // Types: default, vertical, accordion
			width: 'auto', // auto or any width like 600px
			fit: true, // 100% fit in a container
			tabidentify: 'hor_1', // The tab groups identifier
			activate: function (event) { // Callback function if tab is switched
			  var $tab = $(this);
			  var $info = $('#nested-tabInfo');
			  var $name = $('span', $info);
			  $name.text($tab.text());
			  $info.show();
			}
		});
		
		// Child Tab
		$('.ChildVerticalTab_1').easyResponsiveTabs({
			type: 'vertical',
			width: 'auto',
			fit: true,
			tabidentify: 'ver_1', // The tab groups identifier
			activetab_bg: '#fff', // background color for active tabs in this
									// group
			inactive_bg: '#F5F5F5', // background color for inactive tabs in this
									// group
			active_border_color: '#c1c1c1', // border color for active tabs heads in
											// this group
			active_content_border_color: '#5AB1D0' // border color for active tabs
													// contect in this group so that
													// it matches the tab head
													// border
		});
		
		// Vertical Tab
		$('#parentVerticalTab').easyResponsiveTabs({
			type: 'vertical', // Types: default, vertical, accordion
			width: 'auto', // auto or any width like 600px
			fit: true, // 100% fit in a container
			closed: 'accordion', // Start closed if in accordion view
			tabidentify: 'hor_1', // The tab groups identifier
			activate: function (event) { // Callback function if tab is switched
			  var $tab = $(this);
			  var $info = $('#nested-tabInfo2');
			  var $name = $('span', $info);
			  $name.text($tab.text());
			  $info.show();
			}
		});
	}
	<!--End Tabs in All Tours-->

});

function SubMenoProject(){ 
  $.post(masir_commands+"GlobalFile/Ajax.php",{'SubMenoProject':'yes'},function(data){
		if(data!=''){
			var Link='';
			var SubMenu = data.split('/*/');
			for (var i = 0; i < SubMenu.length; i++)
			{
				Link = SubMenu[i].split(',');
				$("."+Link[0]).attr("href", Link[1]);
				
			}// end for
		}
		else{alert(' خطایی در بارگذاری منوها رخ داده است ');}
  });
}// end fun

function security_code(){ 
  $.post(masir_commands+"GlobalFile/code_amniyat/chek.php",{"code":$('#code').val()},function(data){
		if(data=="1"){$('#AlertButton').html('کد امنیتی را درست وارد نمائید');}
		else{ document.FormPrj.submit();}
  });
}// end fun

function Email(str,NameDiv) {
	var at="@";
	var dot=".";
	var lat=str.indexOf(at);
	var lstr=str.length;
	var ldot=str.indexOf(dot);
	
	$('#alert_email').html('');
	if (str.indexOf(at)==-1){
		if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	    else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	}

	else if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	    else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
	   return false
	}

	else if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		 if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	     else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	}

	else if (str.indexOf(at,(lat+1))!=-1){
		 if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	     else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	 }

	else if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		 if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	     else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	 }

	else if (str.indexOf(dot,(lat+2))==-1){
		 if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	     else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	 }
	
	else if (str.indexOf(" ")!=-1){
		 if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	     else{$('#AlertEmaile').html('ایمیل وارد شده صحیح نمی باشد ');}
		return false
	 }
 	 
	 if(NameDiv!=""){$('#'+NameDiv).html('');}
	 else{$('#AlertEmaile').html('');}
	 
	 return true;					
}// end fun

function Mobile(str,NameDiv){
	if(str.length!=11 || str.slice(0,2)!="09"){
		if(NameDiv!=""){$('#'+NameDiv).html('yes');}
	    else{$('#AlertMobile').html('شماره موبایل وارد شده صحیح نمی باشد');}
	}
	else{
		if(NameDiv!=""){$('#'+NameDiv).html('');}
	    else{$('#AlertMobile').html('');}
	}
}// end fun

function getUrlParameter(sParam){
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}// end fun

function Isset_CoseOzviyat(){
  $.post(masir_commands+"GlobalFile/Ajax.php",{"coseozviyat":$('#code_ozve').val()},function(data){
		if(data=="no"){$('#FormPrj h4').html('کد عضویت شما ثبت نشده است'); return false;}
		else{
			  $('#FormPrj h4').html(''); 
			  var arr= data.split('/*/');
			  $("#name").val(arr[0]);
			  $("#cell").val(arr[1]);
			  return true;
		}
  });
}// end fun

function Control_CoseOzviyat(){
	if($('#code_ozve').val().length>0){
		$("#name").prop('disabled', true);
		$("#tel").prop('disabled', true);
		$("#cell").prop('disabled', true);
		$("#email").prop('disabled', true);
		$("#adres").prop('disabled', true);
		$("#company").prop('disabled', true);
		
		$("#name").css('background', "#EEEEEE");
		$("#tel").css('background', "#EEEEEE");
		$("#cell").css('background', "#EEEEEE");
		$("#email").css('background', "#EEEEEE");
		$("#adres").css('background', "#EEEEEE");
		$("#company").css('background', "#EEEEEE");
		
		$("#name").val('');
		$("#tel").val('');
		$("#cell").val('');
		$("#email").val('');
		$("#adres").val('');
		$("#company").val('');
	}
	else{
		$("#name").prop('disabled', false);
		$("#tel").prop('disabled', false);
		$("#cell").prop('disabled', false);
		$("#email").prop('disabled', false);
		$("#adres").prop('disabled', false);
		$("#company").prop('disabled', false);

		
		$("#name").css('background', "#fff");
		$("#tel").css('background', "#fff");
		$("#cell").css('background', "#fff");
		$("#email").css('background', "#fff");
		$("#adres").css('background', "#fff");
		$("#company").css('background', "#fff");		
	}
}// end fun

function RTKH(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun


////////////////////////////////////////
function refreshCaptcha(imageId, formId){
	$('#'+formId)[0].reset(); 
	document.getElementById(imageId).src = masir_commands+'GlobalFile/code_amniyat/securimage_show.php?sid=' + Math.random(); 
	return false;
}
////////////////////////////////////////
function submit_order_form(){
	
	$("#AlertButton").html('');	
	 if($('#order_count').val()=="" || $('#order_count').val()=="تعداد" ||  $('#order_name').val()=="" || $('#order_name').val()=="نام و نام خانوادگی" 
		 ||  $('#order_phone').val()=="تلفن" || $('#order_phone').val()=="" || $('#order_comment').val()=="" || $('#order_comment').val()=="توضیحات" 
		 || $('#code').val()=="" || $('#code').val()=="کد امنیتی" ){
		$("#AlertButton").html('لطفا  فیلدهای ستاره دار را پر نمائید'); 
	 }else{ 
	 	$.post(masir_commands+"GlobalFile/code_amniyat/chek.php",{"code":$('#code').val()},function(data){
		if(data=="1"){$('#AlertButton').html('کد امنیتی را درست وارد نمائید');}else{ 
			
			$.post(masir_commands+"GlobalFile/Ajax.php", {"idlevel2":$("#order_idlevel2").val(), "product_cost":$("#product_cost").val(), "order_count":$("#order_count").val(), "order_name":$("#order_name").val(), "order_email":$("#order_email").val(), "order_phone":$("#order_phone").val(), "order_address":$("#order_address").val(), "order_comment":$("#order_comment").val(), "txtCalendarFrom1":$("#txtCalendarFrom1").val(), "txtCalendarFrom2":$("#txtCalendarFrom2").val()}, function(data){
    			$("#AlertButton").html(data);
    		});
			refreshCaptcha('siimage', 'form_contact');
			//document.FormPrj.submit();}
		}
		});
	 }

} 



function RTLOC(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');
 setTimeout(function(){ $('#AlertMobile').html(''); $('#AlertEmaile').html(''); }, 1000); }
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function RHLOC(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun
 
function RHKH(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function NHotel(){
 $("#AlertButtonNext").html('');
 
 if ($('#AlertHiddenNazar').html()!=""){$("#AlertEmaileNazar").html('ایمیل وارد شده صحیح نمی باشد');}
 else{$("#AlertEmaileNazar").html('');}
 
 if($('#nameNazar').val()=="" || $('#commentNazar').val()==""){
	$("#AlertButtonNext").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertEmaileNazar').html()!="" || $('#Form2Prj h4').html()!=""){$("#AlertButtonNext").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButtonNext').html()=="" && $('#AlertEmaileNazar').html()==""){document.Form2Prj.submit();}
}// end fun

function RTNMSH(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function IdVisa(Id){
	if(Id!=''){
		var type_user=getUrlParameter('reserve_direct');
		if(type_user==''){$('#FormPrj h4').html('');}// agar az package amad
														// form alertash khali
														// nashavd
		
		$('#Id_Visa_Order').val(Id);
		$('#DivBlack').css("display","block");
	}
	else{
		$('#FormPrj h4').html('');
		$('#Id_Visa_Order').val('');
		$('#DivBlack').css("display","none");
	}
}

function RVisa(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#family').val()=="" || $('#cell').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Contact(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#cell').val()=="" || $('#comment').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function SmsTemp(){
	 if($('#NameSms').val()=='' ||  $('#CellSms').val()=='' || $('#EmailSms').val()==''){
		$("#AlertSmsTemp").html('لطفا تمام فیلد ها را پر کنید'); 
		 return false;
	 }
	 else if ($('#SpamCell').html()!=""){$("#AlertSmsTemp").html('شماره موبایل وارد شده صحیح نمی باشد');  return false;}
	 else if ($('#SpamEmail').html()!=""){$("#AlertSmsTemp").html('ایمیل وارد شده صحیح نمی باشد');  return false;}
	 else if ($('#CodeSms').val()!=$('#ShowCodeSms').html()){
		 $("#AlertSmsTemp").html('لطفا کد امنیتی را درست وارد نمائید'); 
		 return false;
	 }
	 else{
			var IdGroupsSms="";
			for(var i=0;i<parseInt($('#HidCountGroupSms').val());i++){
				if($('#ChkSms'+i).prop('checked')){
					IdGroupsSms+=$('#ChkSms'+i).val()+",";
				}
			}
	
			$.post(masir_commands+"GlobalFile/Ajax.php",{"NameSms":$('#NameSms').val(),"EmailSms":$('#EmailSms').val(),"CellSms":$('#CellSms').val(),"IdGroups":IdGroupsSms,"RojoSms":$('#RojoSms').val()},function(data){
				if(data=="Yes"){$('#AlertSmsTemp').html('اطلاعات شما با موفقیت ثبت گردید');}
				else{$('#AlertSmsTemp').html('در انتقال داده ها خطایی رخ داده است');}
				$('#NameSms').val('');
				$('#CellSms').val('');
				$('#EmailSms').val('');
				$('#CodeSms').val('');
				
				for(var i=0;i<parseInt($('#HidCountGroupSms').val());i++){
					if($('#ChkSms'+i).prop('checked',''));
				}
	
			});
		 
	}// end else
 
}// end fun

function Safarname(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#family').val()=="" ||  $('#tel').val()=="" || $('#comment').val()=="" || $('#email').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Online(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#amount').val()=="" || $('#varizbabat').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#amount').val()==0){$("#AlertButton").html('هنوز مدیریت مبلغی برای پرداخت تعیین نکرده است');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#amount').val()!=0){security_code();}
}// end fun

function Faq(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#family').val()=="" ||  $('#tel').val()=="" || $('#commant').val()=="" || $('#email').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Darkhast(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" || $('#family').val()=="" || $('#tel').val()=="" || $('#commant').val()=="" || $('#email').val()=="" ||
	$('#tedad').val()=="" || $('#keshavr').val()=="" || $('#selectorder').val()=="" || $('#txtCalendarFrom1').val()=="" ||
	$('#txtCalendarFrom2').val()==""
 ){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Minute90(){
 $("#AlertButton").html('');
 var chk='no';
 for(var i=1;i<=parseInt($('#count_chk').val());i++){
	 if($('#chk'+i).prop('checked')===true){chk='yes'; break;}
 }
 	
 if($('#name').val()=="" ||  $('#cell').val()=="" || $('#email').val()=="" || chk=='no'){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function IdTicket(Id){
	if(Id!=''){
		$('#Id_Ticket_Order').val(Id);
		$('#FormPrj h4').html('');
		$('#DivBlack').css("display","block");
	}
	else{
		$('#Id_Ticket_Order').val('');
		$('#DivBlack').css("display","none");
		$('#FormPrj h4').html('');
	}
}// end fun

function RTicket(){
 $("#AlertButton").html('');	
 if($('#code_ozve').val()=="" && ($('#name').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || $('#txtCalendarFrom2').val()=="")){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');
 setTimeout(function(){ $('#AlertMobile').html(''); $('#AlertEmaile').html(''); }, 1000); }
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function RMember(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#sex').val()=="" ||  $('#cell').val()=="" ||  $('#txtCalendarFrom1').val()=="" || 
   ($('#email').length>0 && $('#email').val()=="") || 
   ($('#pass').length>0 && $('#pass').val()=="") || 
   ($('#pass2').length>0 &&  $('#pass2').val()=="")
 ){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#pass').length>0 && $('#pass2').length>0 &&  $('#pass').val()!=$('#pass2').val()){$("#AlertButton").html('تکرار کلمه عبور اشتباه می باشد'); }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Branches(){
 $("#AlertButton").html('');	
 if($('#company').val()=="" ||  $('#company_en').val()=="" || $('#manager').val()=="" || $('#email').val()=="" || $('#cell').val()=="" || $('#address').val()=="" ){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Competition(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||  $('#email').val()=="" || $('#cell').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function ClubLogin(){
	
	//برای محاسبه طول تعداد کاراکتر باید حتما آن را در یک متغیر ریخت 
	var UsernameCustomer = $('#UsernameCustomer').val();
	var type_login = '';
	
	if($('#ServicerLogin').length>0 && $('#ServicerLogin').prop('checked')===true){
		type_login = 'servicer';
	}
	else{
		type_login = 'customer';
	}
	
	//control form
	if($('#UsernameCustomer').val()=='' || $('#PasswordCustomer').val()==''){
		Lobibox.notify('error',{
            size: 'mini',
            position: 'top right',
            class: 'animated-fast',
            icon : false,
            delay:3500,
            msg: 'لطفا نام کاربری و رمز عبور را وارد کنید'
        });
		return false;
	}
	else if((type_login == 'servicer' || (type_login == 'customer' && UsernameField == 'yahoo')) && validateEmail($('#UsernameCustomer').val()) === false){
		Lobibox.notify('error',{
            size: 'mini',
            position: 'top right',
            class: 'animated-fast',
            icon : false,
            delay:3500,
            msg: 'فرمت ایمیل در نام کاربری رعایت نشده است'
        });
		return false;
	}
	else if(UsernameField == 'mobile' && (UsernameCustomer.length != 11 || UsernameCustomer.slice(0,2) != '09')){
		Lobibox.notify('error',{
            size: 'mini',
            position: 'top right',
            class: 'animated-fast',
            icon : false,
            delay:3500,
            msg: 'فرمت موبایل در نام کاربری رعایت نشده است'
        });
		return false;
	}
	else if(UsernameField == 'shomare_cart' && UsernameCustomer.length != 16){
		Lobibox.notify('error',{
            size: 'mini',
            position: 'top right',
            class: 'animated-fast',
            icon : false,
            delay:3500,
            msg: 'فرمت شماره کارت در نام کاربری رعایت نشده است'
        });
		return false;
	}
	else{
		$.post(masir_commands+"GlobalFile/Ajax.php",{"UserCustomer":$('#UsernameCustomer').val(),"PassCustomer":$('#PasswordCustomer').val(),"TypeLogin":type_login},function(data){
			if(data=="Yes"){
				var FormAction = '';
				Lobibox.notify('error',{
		            size: 'mini',
		            position: 'top right',
		            class: 'animated-fast',
		            icon : false,
		            delay:3500,
		            msg: 'در حال ورود به پنل کاربری، لطفا صبر کنید...'
		        });
				$('#UsernameCustomer').val('');
				$('#PasswordCustomer').val('');
				
				if(type_login=="servicer"){FormAction = "../panel/panel.php?irantech_agency=600";}
				else if(type_login=="customer"){FormAction = "../panel/panel.php?irantech_agency=108";}
				$("#FormCustomerPrj").attr("action", FormAction);
				document.FormCustomerPrj.submit();
			}
			else{
				Lobibox.notify('error',{
		            size: 'mini',
		            position: 'top right',
		            class: 'animated-fast',
		            icon : false,
		            delay:3500,
		            msg: 'نام کاربری و یا رمز عبور را اشتباه وارد نمودید'
		        });
			}
		});
		 
	}// end else
	
}// end fun

function ColleagueLogin(){
	if($('#UsernameColleague').val()=='' || $('#PasswordColleague').val()==''){
		$("#AlertColleagueLogin").html('لطفا نام کاربری و رمز عبور را پر کنید'); 
		return false;
	}
	else{
		$.post(masir_commands+"GlobalFile/Ajax.php",{"UserColleague":$('#UsernameColleague').val(),"PassColleague":$('#PasswordColleague').val()},function(data){
			if(data=="No"){$('#AlertColleagueLogin').html('نام کاربری و یا رمز عبور را اشتباه وارد نمودید');}
			else if(data=="NoTaeed"){$('#AlertColleagueLogin').html('متأسفانه اطلاعات شما هنوز به تأیید مدیریت نرسیده است');}
			else{
				var FormAction = 'temp.php?irantech_parvaz=package';
				$('#AlertColleagueLogin').html('در حال ورود به سیستم پکیج ها، لطفا صبر کنید...');
				$('#UsernameColleague').val('');
				$('#PasswordColleague').val('');
				$("#FormColleaguePrj").attr("action", FormAction);
				document.FormColleaguePrj.submit();
			}
		});
	}// end else
}// end fun

function getUrlParameter(sParam){
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++)
	{
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}// end fun

function ShowInformation(rahgiri){
	$("#amount").val('');
	$("#showamount").val('');
	$("#name").val('');
	$("#cell").val('');
	
	if(rahgiri.length>5){
		$.post(masir_commands+"GlobalFile/Ajax.php",{"CodeRahgiri":rahgiri},function(data){
			$('#Alertpay').html('');
			$('#btnpay').attr('onclick','Online()');

			if(data=="No"){
				$('.HolderPart h4').html('کد رهگیری به این شماره وجود ندارد');
				return false;
			}
			else{
				var arr = data.split('/*/');
				$('.HolderPart h4').html('');
				$("#amount").val(arr[0]);
				$("#showamount").val(arr[0]+' ریال');
				$("#varizbabat").val(arr[1]+' با کد رهگیری '+rahgiri);
				$("#name").val(arr[2]);
				$("#cell").val(arr[3]);
				if(arr[4]>0){
					$('#Alertpay').html('وجه این کد رهگیری قبلا پرداخت گردیده است ');
					$('#btnpay').attr('onclick','false');
				}
				return true;
			}
		});
	}
}// end fun

function feedback(){
	$("#AlertButton").html('');	
	if($('#name').val()=="" ||  $('#cell').val()=="" || $('#comment').val()==""){
		$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
	}
	else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){
		$("#AlertButton").html('لطفا به خطاها توجه کنید');
	}
	else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun

function Vote(){
	$("#FormVotePrj span").html('');
	if($('input[name="VoteReply"]:checked').length){
		$.post(masir_commands+"GlobalFile/Ajax.php",{"voteReply":$('input[name="VoteReply"]:checked').val(),"questionID":$('#hidQuestionID').val()},function(data){
			if(data=="no"){$("#FormVotePrj span").html('ایجاد خطا در ارسال پاسخ'); return false;}
			else{
				$("#FormVotePrj span").html('با تشکر! پاسخ شما ثبت گردید');
				return true;
			}
		});
	}
	else{
		$("#FormVotePrj span").html('شما باید یکی از پاسخ ها را انتخاب نمایید');
	}
}

function PackageRegister(){
	$("#AlertButton").html('');	
	if($('#company').val()=="" ||  $('#manager').val()=="" || $('#email').val()=="" || $('#username').val()=="" || $('#password').val()=="" || $('#repassword').val()==""){
		$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
	}
	else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){
		$("#AlertButton").html('لطفا به خطاها توجه کنید');
	}
	else if($('#password').val()!=$('#repassword').val()){
		$("#AlertButton").html('تکرار رمز عبور اشتباه است'); 
	}
	else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){
		security_code();
	}
}// end fun

function ShowPopUpProject(targetPage){ 
  $.post(masir_commands+"GlobalFile/Ajax.php",{'targetPage':targetPage},function(data){
		if(data!=''){
			$("#ShowPopup").html(data);
			$('.p-popup-container').css('display','block');
		}
		else{
			$('.p-popup-container').css('display','none');
		}
  });
}// end fun

function ConvertDate(convertType){ 
	var dateValue;
	var displayHtml;
	if(convertType=='fa'){
		dateValue = $('#txtShamsiCalendar').val();
		displayHtml = '#showShamsiResult';
	}
	else if(convertType=='en'){
		dateValue = $('#txtMiladiCalendar').val();
		displayHtml = '#showMiladiResult';
	}
	
	$.post(masir_commands+"GlobalFile/Ajax.php",{'convertDateType':convertType, 'date':dateValue},
	function(data){
		if(data!=''){
			$(displayHtml).html(data);
		}
	});
}// end fun




// get sanie!!
// faghat agar khasti az in function estefade koni, setInterval ro az comment
// kharej kon
function GetSecond() {
	$.post(masir_commands+'GlobalFile/Ajax.php', {
		"TimeSecondTemp" : '1'
	}, function(data) {
		$('#TimeSecondTemp').html(data);
	});
}

// in function vase fieldie k faghar number migire
// nahve estefade: onkeypress="return isNumberKeyFields(event,'Name Input')"
function isNumberKeyFields(evt,Input)
{
   var charCode = (evt.which) ? evt.which : event.keyCode
   // ascii code ro check mikone
   if ((charCode > 31 && (charCode < 48 || charCode > 57)) || $('#'+Input).val().length>=11){
      return false;
   }
   return true;
}
////////////////////////////////////////////////
function aaa(c){ 

		row=document.getElementById('indexhotel').value;
		
		var html="<select name='hotel_sale' id='hotel_sale' class='Right'>";
		var nameHotelReserv="nameHotelReserv"+c;
		var name=document.getElementById(nameHotelReserv).value;
		var idHotelReserv="idHotelReserv"+c;
		var val=document.getElementById(idHotelReserv).value;
				

		html=html+"<option value='"+val+"'>"+name+"</option>";
		
		for(i=1;i<row;i++){
			if(i!=c){
				nameHotelReserv="nameHotelReserv"+i;
				name=document.getElementById(nameHotelReserv).value;
				idHotelReserv="idHotelReserv"+i;
				val=document.getElementById(idHotelReserv).value;
				html=html+"<option value='"+val+"'>"+name+"</option>";
				}
			}
		html=html+"</select>";	
		document.getElementById('selectHotel').innerHTML=html;
}


function PassReminder(){
	 $("#AlertButton").html('');
	 if($('#club_user').val()==""){
		$("#AlertButton").html('لطفا نام کاربری خود را وارد نمایید'); 
	 }
	 else if ($('#AlertButton').html()==""){security_code();}
}// end fun

//////////////////////////////////////////////////////////////////////
function validateEmail(field) {
	if (!((field.indexOf(".") > 0) && (field.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(field))
		return false;
	return true;
}

//////////////////////////////////////////////////////////////////////
function Employment(){
 $("#AlertButton").html('');	
 if($('#name').val()=="" ||   $('#birth_date').val()=="" || $('#gender').val()=="" || $('#mobile').val()=="" || $('#mail').val()==""){
	$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
 }
 else if ($('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
 else if ($('#AlertButton').html()=="" && $('#AlertEmaile').html()==""){security_code();}
}// end fun




////////////////////////////////////////////////////////////////////////
function safar360_ticket_check(){
	if($('#source_city').val()=="" || $('#source_city').val()=="انتخاب مبدا" || $('#destination_city').val()==""  || $('#destination_city').val()=="انتخاب مقصد" || $('#went_date').val()==""  || $('#number_of_adults').val()==""  || $('#number_of_infants').val()=="" ){
		alert("لطفا تمامی فیلدها را تکمیل نمایید"); return false; 
	}
	if($('#source_city').val() == $('#destination_city').val()){alert('شهر مبدا و مقصد نباید یکسان باشد'); return false;}
	if(parseInt($('#number_of_adults').val())>10 || parseInt($('#number_of_adults').val())<1){alert('تعداد افراد بزرگسال باید بین 1 تا 9 نفر باشد'); return false;}
	if((parseInt($('#number_of_childs').val()) + parseInt($('#number_of_adults').val())) > 9){alert('مجموع تعدا بزرگسال و کودک نباید بیش از 9 نفر باشد'); return false;}
	if(parseInt($('#number_of_infants').val()) > parseInt($('#number_of_adults').val())){alert('تعدا نوزاد نباید بیش از تعداد بزرگسال باشد'); return false;}
	
	return document.safar360_ticket.submit();
}


function safar360_insurance_check() {

    if ($('#insurance_locality').val() == "" || $('#insurance_locality').val() == "انتخاب نوع بیمه" || $('#destination_country').val() == "" || $('#destination_country').val() == "انتخاب مقصد" || $('#travel_time').val() == "" || $('#number_of_adults_insurance').val() == "") {
       alert("لطفا تمامی فیلدها را تکمیل نمایید");
       return false;
    }

    var count = parseInt($("#number_of_adults_insurance").val());
    for (var i = 1; i <= count; i++) {
        if ($('#txt_went_insurance' + i).val() == "") {
        	alert("لطفا تمامی فیلدها را تکمیل نمایید");
            return false;
        }
    }
    
    return document.safar360_insurance.submit();
}

function gds_insurance_destinations() {
    $.post(masir_commands + 'GlobalFile/Ajax.php',
        {
            insurance_locality: $("#insurance_locality").val()
        },
        function (data) {
            var arrdata = data.split(",");
            var opts = '<option value="">انتخاب مقصد</option>';
            for (var i = 0; i < arrdata.length - 1; i++) {
                list = arrdata[i].split("##");
                opts += '<option  value="' + list[0] + '">' + list[1] + '</option>';
            }
            $("#destination_country").html(opts);
        }
    );
}

////////////////////////////////////////////////////////////////////////
function GetPortalAirport() {
    var DeparturePortal = $('#OriginAirportPortal').val();

    $.post(masir_commands + "GlobalFile/Ajax.php",
        {
            departure: DeparturePortal,
            usage: "gds_routs_portal"
        },
        function (data) {

            $('#DestinationAirportPortal').html(data);

        });
}



function get_gds_routs()
{
    var departure = $('#gds_origin_local').val();
    $.post(masir_commands+"GlobalFile/Ajax.php",
    {
        departure: departure,
        usage: "gds_routs",
    },
    function (data) {

        $('#gds_destination_local').html(data);

    });
}

function gds_ticket_local_check() {
    var origin = $("#gds_origin_local").val();
    var destination = $("#gds_destination_local").val();
    var dept_date = $("#gds_dept_date_local").val();
    var adult = Number($("#qty4").val());
    var child = Number($("#qty5").val());
    var infant = Number($("#qty6").val());
    if($("#gds_seat_local").length > 0){
    	var classf = $("#gds_seat_local").val();
    } else{
    	var classf = 'Y';
    }
    
    if (origin == "" || destination == "" || dept_date == "" || adult == "")
    {
        alert("لطفا فیلدهای مورد نیاز را وارد نمایید");
    	return false;
    }
    else if (infant > adult || adult < 0) {
    	alert("تعداد نوزاد نباید از بزرگسال بیشتر باشد");
    	return false;
    }
    else if ((adult + child + infant) > 9) {
    	alert("مجموع افراد نباید از نه بیشتر باشد");
    	return false;
    } else {
        if (dept_date.indexOf('/') > -1)
        {
        	dept_date = dept_date.toString().replace(/\//g, '-');
        }

        var ori_dep = origin + "-" + destination;
        var num = adult + "-" + child + "-" + infant;
        var domain = $("#gds_local").attr('action');
        var url = domain + "gds/local/1/" + ori_dep + "/" + dept_date + "/" + classf + "/" + num + "/";

        window.location.href = url;
    }
}

function gds_ticket_portal_check() {
    var origin = $("#OriginAirportPortal").val();
    var destination = $("#DestinationAirportPortal").val();
    var dept_date = $("#gds_dept_date_Portal").val();
    var classf = $("#gds_seat_portal").val();
    var adult = Number($("#qtyadt").val());
    var child = Number($("#qtychd").val());
    var infant = Number($("#qtyinf").val());
    if (origin == "" || destination == "" || dept_date == "" || adult == "") {
    	 alert("لطفا فیلدهای مورد نیاز را وارد نمایید");
     	return false;
    }
    else if (infant > adult || adult < 0) {
    	alert("تعداد نوزاد نباید از بزرگسال بیشتر باشد");
    	return false;
    }
    else if ((adult + child + infant) > 9) {
    	alert("مجموع افراد نباید از نه بیشتر باشد");
    	return false;
    } else {
        if (dept_date.indexOf('/') > -1) {
            var dept_date_aa = dept_date.replace('/', '-');
            var date_final = dept_date_aa.replace('/', '-');
        } else {
            var date_final = dept_date;
        }
        var ori_dep = origin + "-" + destination;
        var num = adult + "-" + child + "-" + infant;
        var domain = $("#gds_local").attr('action');
        var url = domain + "gds/local/2/" + ori_dep + "/" + date_final + "/" + classf + "/" + num + "/";
        window.location.href = url;
    }
}

//search box for hotel(gds)
function gds_hotel_local_check() {

    var city = $("#cityForHotelLocal").val();
    var StartDate = $("#startDateForHotelLocal").val();
    var EndDate = $("#endDateForHotelLocal").val();
    var Nights = $("#NightsForHotelLocal").val();

    if (city == "" || StartDate == "" || EndDate == "")
    {
    	alert("لطفا فیلدهای مورد نیاز را وارد نمایید");
    	return false;
    	
    } else {
        if (StartDate.indexOf('/') > -1)
        {
            var date = StartDate.toString().replace(/\//g, '-');
        }

        var domain = $("#gdsHotelLocal").attr('action');
        var url = domain + city + "/" + date + "/" + Nights;
        
        $("#gdsHotelLocal").attr('action',url);
        return document.gdsHotelLocal.submit();
    }
}


function gds_insurance_check() {

    var locality = $("#insurance_locality").val();
    var destination = $("#destination_country").val();
    var duration = $("#travel_time").val();
    var count = parseInt($("#number_of_passengers").val());
    var birthdates = '';

    if (locality == "" || locality == "انتخاب نوع بیمه" || destination == "" || destination == "انتخاب مقصد" || duration == "" || count == "") {
        alert("لطفا تمامی فیلدها را تکمیل نمایید");
        return false;
    }

    for (var i = 1; i <= count; i++) {
        if ($('#txt_birth_insurance' + i).val() == "") {
            alert("لطفا تمامی فیلدها را تکمیل نمایید");
            return false;
        }
        birthdates += $('#txt_birth_insurance' + i).val().toString().replace(/\//g, '-') + '/';
    }

    var domain = $("#gdsInsurance").attr('action');
    var url = domain + 'gds/resultInsurance/2/' + destination + "/" + duration + "/" + count + "/" + birthdates;

    $("#gdsInsurance").attr('action',url);
    return document.gdsInsurance.submit();
}


function RSign(){
	 $("#AlertButton").html('');	
	 if($('#agency_name').val()=="" ||  $('#manager_name').val()=="" ||  $('#license').val()=="" ||  $('#manager_mobail').val()=="" || 
	   $('#manager_email').val()=="" || $('#cell').val()=="" || 
	   $('#fax').val()=="" || $('#pass').val()=="" || 
	   $('#Name_Agent').val()=="" ||  $('#Mobile_Agent').val()=="" ||
	   $('#User_email').val()=="" ||  $('#username').val()=="" ||
	   $('#password').val()=="" ||  $('#password2').val()=="" ||
	   $('#Agency_Address').val()=="" ||  $('#registerar_name').val()=="" ||
	   $('#registerar_Position').val()=="" )
	 {
		$("#AlertButton").html('فیلدهای ستاره دار را پر نمائید'); 
	 }
	 else if ($('#password').length>0 && $('#password2').length>0 &&  $('#password').val()!=$('#password2').val()){$("#AlertButton").html('تکرار کلمه عبور اشتباه می باشد'); }
	 else if ($('#AlertMobile').html()!="" || $('#AlertEmaile').html()!="" || $('#FormPrj h4').html()!=""){$("#AlertButton").html('لطفا به خطاها توجه کنید');}
	 else if ($('#AlertButton').html()=="" && $('#AlertMobile').html()=="" && $('#AlertEmaile').html()==""){security_code();}
	}// end fun