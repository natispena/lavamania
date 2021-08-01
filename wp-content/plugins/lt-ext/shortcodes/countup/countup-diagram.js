"use strict";

jQuery(window).on('scroll', function (event) {

	ltxChartDoughnut();
}).scroll();


function ltxChartDoughnut() {

	var scroll = jQuery(window).scrollTop() + jQuery(window).height();

	if (jQuery(".ltx-chart-doughnut").length) {

		jQuery(".ltx-chart-doughnut:not(.inited)").each(function(i, el) {

			var canvasEl = jQuery(el).prev().get(0).getContext("2d"),
				value = jQuery(el).data('percent'),
				scrollEl = jQuery(el).offset().top,
				bodyStyles = window.getComputedStyle(document.body),
				colorMain = jQuery.trim(bodyStyles.getPropertyValue('--main')),
				colorSecond = jQuery.trim(bodyStyles.getPropertyValue('--gray'));

				if ( jQuery(el).hasClass('style-white') ) {

					colorMain = '#ffffff';
				}


			var gradient = canvasEl.createLinearGradient(0, 0, 0, 600);
			gradient.addColorStop(0, colorMain);

			var data = {
				datasets: [{
				    data: [value, 100-value],
				    borderWidth: 0,
				    backgroundColor: [
						gradient
				    ]
			    }]
			};

			if (scroll > scrollEl) {

				new Chart(canvasEl, {
					type: 'doughnut',
					data: data,
					options: {
						responsive: true,
						legend: {
						  display: false
						},
						cutoutPercentage: 94,
						tooltips: {enabled: false},
						hover: {mode: null},
					}
				});

				jQuery(el).addClass('inited');
			}
		});
	}
}