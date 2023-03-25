require('./bootstrap');

var Inputmask = require('inputmask');
var moment = require('moment');

$(function(){

	Ladda.bind('.ladda-button');

	Inputmask({
		'alias': 'datetime',		
		'placeholder': 'dd/mm/yyyy',
		'inputFormat': 'dd/mm/yyyy',
		'inputmode': 'numeric',
		"max": moment().format('DD-MM-YYYY'),
		'clearIncomplete': true
	}).mask($('.input-mask--dob'));

	Inputmask({
		'mask': '999 999 9999',
		'autoUnmask': true,
		'removeMaskOnSubmit': true,
		'inputmode': 'numeric',
		onUnMask: function(maskedValue, unmaskedValue) {
			return unmaskedValue.replace(/\s+/g, '');
		}
	}).mask($('.input-mask--phone'));	

	Inputmask({
		'mask': '9',
		'repeat': 10,
		'greedy': true,
		'inputmode': 'numeric',
	}).mask($('.input-mask--phone-remote'));

	$('form[action$="backend/logout"]').submit(function(){
		return confirm('Do you want to logout?');
	});

	$('body').on('click', '.form-confirm-del', function(e){
	    e.preventDefault();

	    let $this = $(this),
	        formDel = $this.closest('form')

	    if (confirm(formDel.data('text-confirm'))) {
	        formDel.attr('action', $this.attr('href')).submit();
	    }
	});

	$('.reset-form').on('click', function(){
		$(this).closest('form')[0].reset();
	})

	// for treeview
	$('ul.nav-treeview a.active').parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
})