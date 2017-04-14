$(document).ready(function() {
	var limit = 80,
		update = document.createEvent('Event'),
		oldValue_date = '',
		oldValue_area = '';

	update.initEvent('autosize:update');

	function validateDate(date) {
		var max = 0;
		switch (date.substring(5, 7)) {
			case '02':
				max = 29;
				break;
			case '04':
			case '06':
			case '09':
			case '11':
				max = 30;
				break;
			default:
				max = 31;
				break;
		}

		if (!/^\d{4}-\d{2}-\d{2}$/.test(date) || /\b(?:00){1,2}\b/.test(date) || date.substring(5, 7) > 12 || date.substring(8) > max) {
			return false;
		}

		return true;
	}

	function isEllipsisActive(e) {
	     return (e.offsetWidth < e.scrollWidth);
	}

	function largestTextarea() {
		var maxHeight = 0;

		$('.add').each(function(index, el) {
			if (parseInt($(el).css('height')) > maxHeight) maxHeight = parseInt($(el).css('height'));
		});

		return maxHeight;
	}

	$('.text-collapse').each(function(index, el) {
		if (isEllipsisActive(el)) {
			$(el).children('.content-text').css('cursor', 'pointer')
			.click(function() {
				$(this).parent('td').toggleClass('text-collapse');
			});
		}
	});

	$('#add').click(function() {
		$('#add-row').children().toggleClass('hidden');
		$('button').toggleClass('hidden');
		$('.add').css('height', '');
	});

	$('.add').on('input', function(e) {
		var minheight;
		this.value = this.value.replace(/\n/g, '');
		$('.add').css('min-height', '');
		$('.add').each(function(index, el) {
			el.dispatchEvent(update);
		});
		minHeight = largestTextarea();
		$('.add').css('min-height', minHeight)
		.each(function(index, el) {
			el.dispatchEvent(update);
		});
		this.setCustomValidity('');
		$(this).parent().css('background-color', 'initial');
	}).keypress(function(e) {
		if (e.key === 'Enter') e.preventDefault();
	}).on('invalid', function(e) {
		this.setCustomValidity(' ');
		$(this).parent().css('background-color', '#FFA09C');
	});

	$('#add-date').on('input', function(e) {
		this.value = this.value.replace(/[^\d-]/g, '');
		if (!/^(?:\d{0,4}|\d{4}-(?:\d{1,2}|\d{2}-(?:\d{1,2})?)?)$/.test(this.value)) {
			this.value = oldValue_date;
		} else {
			oldValue_date = this.value;
		}
	}).keypress(function(e) {
		if (/[^\d-]/.test(e.key)) e.preventDefault();
	}).change(function() {
		if (!validateDate(this.value) && this.value !== '') {
			this.setCustomValidity(' ');
			$(this).parent().css('background-color', '#F2BB6E');
		}
	});

	$('#add-area').on('input', function() {
		this.value = this.value.replace(/[^\d\.]/g, '');
		this.value = this.value.replace(/^00+/, '0');
		this.value = this.value.replace(/^0(\d)/, '$1');
		this.value = this.value.replace(/^\./, '0.');
	}).keypress(function(e) {
		if (!/[\d\.]/.test(e.key) || (/\./.test(this.value) && e.key == '.')) e.preventDefault();
	}).change(function() {
		if (/\./.test(this.value)) {
			var decimals = this.value.substring(this.value.indexOf('.') + 1);
			decimals = decimals.replace(/\./g, '');
			decimals = decimals.replace(/0+$/, '');
			this.value = this.value.substring(0, this.value.indexOf('.') + 1) + decimals;
		}
		this.value = this.value.replace(/\.$/, '');
		this.value = this.value.replace(/^\./, '0.');
		if (!/^\d+(?:\.\d+)?$/.test(this.value) && this.value !== '') {
			this.setCustomValidity(' ');
			$(this).parent().css('background-color', '#F2BB6E');
		}
	});

	autosize($('.add'));
});