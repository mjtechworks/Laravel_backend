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

})