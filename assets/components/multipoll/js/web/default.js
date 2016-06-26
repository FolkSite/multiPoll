$('.multipoll-item .vote').on('click touchend', function(e) {
	e.preventDefault();
	var _this = $(this);
	var parent = $(this).closest('.multipoll-item');
	var data = '&option_id=' + _this.val();
	$.ajax({
        type: "POST",
        url: multiPollConfig.actionUrl,
        data: data,
        success: function(html) {
            parent.html(html);
        }
    });
    return false;
});