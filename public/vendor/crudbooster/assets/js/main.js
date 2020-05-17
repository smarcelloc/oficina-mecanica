Number.prototype.number_format = function (n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
	return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};

function beep() {

	$("#sound_beep").remove();
	$('body').append('<audio id="sound_beep" style="display:none" autoplay>' +
		+'<source src="' + ASSET_URL + '/vendor/crudbooster/assets/sound/bell_ring.ogg" type="audio/ogg">'
		+ '<source src="' + ASSET_URL + '/vendor/crudbooster/assets/sound/bell_ring.mp3" type="audio/mpeg">'
		+ 'Your browser does not support the audio element.</audio>');
}

$(function () {

	jQuery.fn.outerHTML = function (s) {
		return s
			? this.before(s).remove()
			: jQuery("<p>").append(this.eq(0).clone()).html();
	};



	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.treeview').each(function () {
		var active = $(this).find('.active').length;
		if (active) {
			$(this).addClass('active');
		}
	})


	$('input[type=text]').first().not(".notfocus").focus();

});