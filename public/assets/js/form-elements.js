$(function(e) {
	'use strict'

	// Toggles
	$('.toggle').toggles({
		on: true,
		height: 26
	});

	// Input Masks
	$('#dateMask').mask('99/99/9999');
	$('#phoneMask').mask('(999) 999-9999');
	$('#ssnMask').mask('999-99-9999');

	// Time Picker
	$('#tpBasic').timepicker();
	$('#tp2').timepicker({
		'scrollDefault': 'now'
	});

	$('#tp3').timepicker();

	$(document).on('click', '#setTimeButton', function() {
		$('#tp3').timepicker('setTime', new Date());
	});


	// Color picker
	$('#colorpicker').spectrum({
		color: '#0061da'
	});
	$('#showAlpha').spectrum({
		color: 'rgba(0, 97, 218, 0.5)',
		showAlpha: true
	});
	$('#showPaletteOnly').spectrum({
		showPaletteOnly: true,
		showPalette: true,
		color: '#DC3545',
		palette: [
			['#1D2939', '#fff', '#0866C6', '#23BF08', '#F49917'],
			['#DC3545', '#17A2B8', '#6610F2', '#fa1e81', '#72e7a6']
		]
	});

	//Date range picker
	$('#reservation').daterangepicker();

	// Datepicker
	// $('.fc-datepicker').datepicker({
	// 	showOtherMonths: true,
	// 	selectOtherMonths: true
	// });

    $('#input_date').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('#input_create_date').datepicker({
        monthNames: [ "1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월" ],
        //dayNamesShort: [ "월", "화", "수", "목", "금", "토", "일" ], // For formatting
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
        changeYear:true,
        showOtherMonths: true,
        selectOtherMonths: true
    });

	$('#input_from_date').datepicker({
		showOtherMonths: true,
		selectOtherMonths: true
	});
	$('#input_to_date').datepicker({
		showOtherMonths: true,
		selectOtherMonths: true
	});
	$('#datepickerNoOfMonths').datepicker({
		showOtherMonths: true,
		selectOtherMonths: true,
		numberOfMonths: 2
	});

	// Select2
	$('.select2').select2({
		minimumResultsForSearch: Infinity
	});
	// Select2 by showing the search
	$('.select2-show-search').select2({
		minimumResultsForSearch: ''
	});
});
