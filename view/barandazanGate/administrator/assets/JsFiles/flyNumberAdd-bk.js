$(document).ready(function() {
    // Handle form submission
    $('#FormFlyNumber').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var parts = response.split(':');
                if (parts[0].trim() === 'success') {
                    // Show success message
                    $.toast({
                        heading: 'افزودن شماره پرواز',
                        text: parts[1].trim(),
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                    
                    // If we have a fly_id, show option to add ticket
                    if (parts.length > 2 && parts[2].trim()) {
                        var flyId = parts[2].trim();
                        setTimeout(function() {
                            if (confirm('شماره پرواز با موفقیت ذخیره شد. آیا می‌خواهید بلیط برای این پرواز اضافه کنید؟')) {
                                window.location.href = 'ticketAdd?fly_id=' + flyId;
                            } else {
                                window.location.href = 'flyNumber';
                            }
                        }, 1000);
                    } else {
                        setTimeout(function() {
                            window.location.href = 'flyNumber';
                        }, 1000);
                    }
                } else {
                    // Show error message
                    $.toast({
                        heading: 'خطا در افزودن شماره پرواز',
                        text: parts[1].trim(),
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }
            },
            error: function() {
                $.toast({
                    heading: 'خطا در ارتباط',
                    text: 'خطا در ارتباط با سرور',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    });
}); 