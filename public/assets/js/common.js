(function($) {

	// ______________Active Class
	$(document).ready(function() {
        $('div[id^="notification_logout_"]').click(function(){
            var oid = $(this).attr("id");
            var user_type = oid.split('_')[2];
            if (user_type == 'admin') {
                $.ajax({
                    url: 'admin.logout',
                    headers: {'Authorization': `Bearer ${window.localStorage.authToken}`},
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'admin';
                        } else {
                            console.log('err');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            }
            else if (user_type == 'user') {
                $.ajax({
                    url: 'user.userLogout',
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'user';
                        } else {
                            console.log('err');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            }
        });

        $('div[id^="mobile_notification_logout_"]').click(function(){
            var oid = $(this).attr("id");
            var user_type = oid.split('_')[3];
            if (user_type == 'admin') {
                $.ajax({
                    url: 'admin.logout',
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'admin';
                        } else {
                            console.log('err');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            }
            else if (user_type == 'user') {
                $.ajax({
                    url: 'user.userLogout',
                    type: 'POST',
                    success: function (data) {
                        if (data.msg === "ok") {
                            window.location.href = 'user';
                        } else {
                            console.log('err');
                        }
                    },
                    error: function (jqXHR, errdata, errorThrown) {
                        console.log(errdata);
                    }
                });
            }
        });
	});


})(jQuery);
