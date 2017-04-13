$(document).ready(function() {
	var limit = 80,
		evt = document.createEvent('Event'),
		oldValue_date = '',
		oldValue_area = '';

	evt.initEvent('autosize:update');

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

	$('.description').each(function(index, element) {
		if (element.innerText.length > limit) {
			element.innerHTML = element.innerHTML.substring(0, limit) + '<span class="overflow">' + element.innerHTML.substring(limit) + '</span><span>...</span>';
			$(element).css('cursor', 'pointer');
			$(element).click(function(event) {
				$(this).children('.overflow').toggleClass('expanded');
			});
		}
	});

	$('#add').click(function() {
		$('#add-row').children().toggleClass('hidden');
		$('button').toggleClass('hidden');
	});

	$('.add').on('input', function(e) {
		this.value = this.value.replace(/\n/g, '');
		this.dispatchEvent(evt);
		this.setCustomValidity('');
		$(this).parent().css('background-color', 'initial');
	}).keypress(function(e) {
		if (e.key === 'Enter') e.preventDefault();
	}).on('invalid', function(e) {
		this.setCustomValidity(' ');
		$(this).parent().css('background-color', '#FFA09C');
	}).on('autosize:resized', function(e) {
		var largest = $(this).parent('td').index();
		$('#add-row').children('td').each(function(index, el) {
			if (index === largest) {
				$(el).children('textarea').css('min-height', 'initial');
			} else if (index !== 0) {
				$(el).children('textarea').css('min-height', $('#add-row').children('td').eq(largest).children('textarea').css('height'));
			}
		});
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