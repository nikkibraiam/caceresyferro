(function ($) {
    "use strict";
    $(document).ready(function () {

        var $window = $(window),
            $body = $('body'),
            isRtl = $body.hasClass('rtl');

		/*-----------------------------------------------------------------*/
        /* Mortgage Calculator
        /*-----------------------------------------------------------------*/
		if( $('.rh_property__mc_wrap').length ) {

			const mcState = {};
			mcState.fields = {
				'term': $('select.mc_term'),
				'interest_text': $('.mc_interset'),
				'interest_slider': $('.mc_interset_slider'),
				'price_text': $('.mc_home_price'),
				'price_slider': $('.mc_home_price_slider'),
				'downpayment_text': $('.mc_downpayment'),
				'downpayment_text_p': $('.mc_downpayment_percent'),
				'downpayment_slider': $('.mc_downpayment_slider'),
				'tax': $('.mc_cost_tax_value'),
				'hoa': $('.mc_cost_hoa_value'),
				'currency_sign': $('.mc_currency_sign'),
				'info_term': $('.mc_term_value'),
				'info_interest': $('.mc_interest_value'),
				'info_cost_interst': $('.mc_cost_interest span'),
				'info_cost_total': $('.mc_cost_total span'),
				'graph_interest': $('.mc_graph_interest'),
				'graph_tax': $('.mc_graph_tax'),
				'graph_hoa': $('.mc_graph_hoa'),
			}

			if ( $('.mc_cost_over_graph').length > 0 ) {
				mcState.fields.info_cost_total = $('.mc_cost_over_graph');
			}

			mc_calculate(); // Initiate Mortgage Calculator.
			mc_input_blur(); // Format the amounts in the text fields.

			// Apply calculation action on calculator values change.
			$('.rh_mc_field select, .rh_mc_field input[type=range]').on('change', mc_update_fields_values);
			$('.rh_mc_field input[type=range]').on('input', mc_update_fields_values);
			$('.rh_mc_field input[type=text]').on('keyup', mc_update_fields_values);

			// Add focus and blur actions on text input fields.
			$('.rh_mc_field input[type=text]').on('focus', mc_input_focus);
			$('.rh_mc_field input[type=text]').on('blur', mc_input_blur);

			function mc_reassign_fields($this = null) {
				if ( 'object' === typeof $this && typeof $this.closest( '.rh_property__mc' ) ) {
					$this = $this.closest( '.rh_property__mc' );
					mcState.fields = {
						'term': $this.find('select.mc_term'),
						'interest_text': $this.find('.mc_interset'),
						'interest_slider': $this.find('.mc_interset_slider'),
						'price_text': $this.find('.mc_home_price'),
						'price_slider': $this.find('.mc_home_price_slider'),
						'downpayment_text': $this.find('.mc_downpayment'),
						'downpayment_text_p': $this.find('.mc_downpayment_percent'),
						'downpayment_slider': $this.find('.mc_downpayment_slider'),
						'tax': $this.find('.mc_cost_tax_value'),
						'hoa': $this.find('.mc_cost_hoa_value'),
						'currency_sign': $this.find('.mc_currency_sign'),
						'info_term': $this.find('.mc_term_value'),
						'info_interest': $this.find('.mc_interest_value'),
						'info_cost_interst': $this.find('.mc_cost_interest span'),
						'info_cost_total': $this.find('.mc_cost_total span'),
						'graph_interest': $this.find('.mc_graph_interest'),
						'graph_tax': $this.find('.mc_graph_tax'),
						'graph_hoa': $this.find('.mc_graph_hoa'),
					}
					
					if ( $('.mc_cost_over_graph').length > 0 ) {
						mcState.fields.info_cost_total = $this.find('.mc_cost_over_graph');
					}
				}
			}

			function mc_only_numeric(data){
				if('string' === typeof data) {
					return (data.replace(/[^0-9-.]/g,'')).replace(/^\./, ''); // leave only numeric value.
				}
				return data;
			}

			function mc_input_focus(){
				$(this).val( mc_only_numeric( $(this).val() ) ); // leave only numeric value.
			}

			function mc_input_blur(){
				// percentage value.
				mcState.fields.interest_text.val( mc_only_numeric( mcState.fields.interest_text.val() ) + '%');
				mcState.fields.downpayment_text_p.val( mc_only_numeric( mcState.fields.downpayment_text_p.val() ) + '%');
				
				// formatted amount value.
				mcState.fields.price_text.val(mc_format_amount( mcState.fields.price_text.val()));
				mcState.fields.downpayment_text.val(mc_format_amount(mcState.fields.downpayment_text.val()));
			}

			function mc_format_amount(amount) {
				return mcState.values.currency_sign + new Intl.NumberFormat().format( mc_only_numeric( amount ) );
			}

			function mc_update_fields_values(){

				const $this = $(this);
				mc_reassign_fields($this);
				mcState.values = mc_get_input_values(); // get all input values to be used for the calculation.

				if( 'range' === $this.attr('type') ) {

					if($this.hasClass('mc_interset_slider')) { // Interest slider changed.

						mcState.fields.interest_text.val($this.val() + '%'); // update interest percentage text field value.

					} else if ($this.hasClass('mc_home_price_slider')) { // Price slider changed.

						mcState.fields.price_text.val(mc_format_amount($this.val())); // update price text field value.

						// update downpayment amount text field value according to the selected percentage.
						let home_price = $this.val();
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = Math.round((home_price * dp_percent) / 100);

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment_slider')) { // Downpayment slider.

						mcState.fields.downpayment_text_p.val($this.val() + '%');
						
						let home_price = mcState.values.price;
						let dp_percent = $this.val();
						let downpayment = Math.round((home_price * dp_percent) / 100);
						
						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));
					}
				} else if( 'text' === $this.attr('type') ) {

					if($this.hasClass('mc_interset')) {

						mcState.fields.interest_slider.val( mcState.values.interest );

					} else if ($this.hasClass('mc_home_price')) {

						mcState.fields.price_slider.val( mcState.values.price );

						let home_price = mcState.values.price;
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = Math.round(( home_price * dp_percent ) / 100);

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment_percent')) {

						mcState.fields.downpayment_slider.val( mcState.values.downpayment_percent );

						let home_price = mcState.values.price;
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = ( home_price * dp_percent ) / 100;

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment')) {

						let home_price = mcState.values.price;
						let downpayment = mcState.values.downpayment;

						let price = ( home_price < downpayment ) ? downpayment : home_price;
						let dp_percent = ((downpayment * 100) / price).toFixed(2).replace(/[.,]00$/, "");

						mcState.fields.downpayment_text_p.val(dp_percent + '%');
						mcState.fields.downpayment_slider.val(dp_percent);

					}
				}

				mc_calculate();
			}

			function mc_get_input_values(){
				let interest = mc_only_numeric( mcState.fields.interest_text.val() );
				let price = mc_only_numeric( mcState.fields.price_text.val() );
				let downpayment = mc_only_numeric( mcState.fields.downpayment_text.val() );
				let downpayment_percent = mc_only_numeric( mcState.fields.downpayment_text_p.val() );
				let tax = mc_only_numeric( mcState.fields.tax.val() );
				let hoa = mc_only_numeric( mcState.fields.hoa.val() );
				let currency_sign = mcState.fields.currency_sign.val();

				let mcInputVals = {
					term: parseInt(mcState.fields.term.val()),
					interest: ('' === interest.replace('-', '')) ? 0 : parseFloat(interest),
					price: ('' === price.replace('-', '')) ? 0 : parseFloat(price),
					downpayment: ( '' === downpayment.replace('-', '') ) ? 0 : parseFloat(downpayment),
					downpayment_percent: ( '' === downpayment_percent.replace('-', '') ) ? 0 : parseFloat(downpayment_percent),
					tax: ('' === tax.replace('-', '')) ? 0 : parseFloat(tax),
					hoa: ('' === hoa.replace('-', '')) ? 0 : parseFloat(hoa),
					currency_sign: ('' === currency_sign) ? '$' : currency_sign,
				};

				return mcInputVals;
			}

			function mc_get_principle_interest(){

				let home_price = parseFloat(mcState.values.price);
				let downpayment = parseFloat(mcState.values.downpayment);
				let loanBorrow = home_price - downpayment;
				let totalTerms = 12 * mcState.values.term;
				
				if ( 0 === parseInt( mcState.values.interest ) ) {
					return loanBorrow / totalTerms;
				}

				let interestRate = parseFloat(mcState.values.interest) / 1200;
				return Math.round(loanBorrow * interestRate / (1 - (Math.pow(1/(1 + interestRate), totalTerms))));
			}

			function mc_get_payment_per_month(){

				let principal_interest = parseFloat(mcState.princial_interest);
				let property_tax = parseFloat(mcState.values.tax);
				let hoa_dues = parseFloat(mcState.values.hoa);
				
				return Math.round(principal_interest + property_tax + hoa_dues);
			}

			function mc_get_data_percentage(){

				let principal_interest = mcState.princial_interest;
				let property_tax = mcState.values.tax;
				let hoa_dues = mcState.values.hoa;

				let p_i = (principal_interest*100)/mcState.payment_per_month;
				let tax = (property_tax*100)/mcState.payment_per_month;
				let hoa = (hoa_dues*100)/mcState.payment_per_month;

				let data_percentage = {
					p_i,
					tax,
					hoa
				};

				return data_percentage;
			}

			function mc_render_information(){

				// Update calculated information.
				mcState.fields.info_term.text(mcState.values.term);
				mcState.fields.info_interest.text(mcState.values.interest);
				mcState.fields.info_cost_interst.text(mc_format_amount(Math.round(mcState.princial_interest)));
		 
				if ( $('.mc_cost_over_graph').length > 0 ) {
					
					// Update circle graph and total cost.
					let cost_prefix = mcState.fields.info_cost_total.attr('data-cost-prefix');
					mcState.fields.info_cost_total.html('<strong>' + mc_format_amount(mcState.payment_per_month) + '</strong>' + cost_prefix);

					var $circle = mcState.fields.graph_interest;
					var circle_pct = mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

					var $circle = mcState.fields.graph_tax;
					var circle_pct = mcState.percentage.tax + mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

					var $circle = mcState.fields.graph_hoa;
					var circle_pct = mcState.percentage.hoa + mcState.percentage.tax + mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

				} else {
					// Update bar graph and total cost.
					mcState.fields.info_cost_total.text(mc_format_amount(mcState.payment_per_month));
					mcState.fields.graph_interest.css( 'width', (mcState.percentage.p_i) + '%');
					mcState.fields.graph_tax.css( 'width', (mcState.percentage.tax) + '%');
					mcState.fields.graph_hoa.css( 'width', (mcState.percentage.hoa) + '%');
				}	

			}

			function mc_calculate(){
				mcState.values = mc_get_input_values(); // get all input vaues to be used for the calculation.
				mcState.princial_interest = mc_get_principle_interest(); // caclcualte and get the principle and interest amount.
				mcState.payment_per_month = mc_get_payment_per_month(); // calculate and get the per month payment to be paid.
				mcState.percentage = mc_get_data_percentage(); // calculate and get the percentages of the data for the graph display.
				mc_render_information(); // Display the information on frontend side.
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/*	Language Switcher
		/*-----------------------------------------------------------------------------------*/
        $body.on('click','.inspiry-language',function (e) {

            if($('.inspiry-language-switcher').find('.rh_languages_available').children('.inspiry-language').length > 0){

                $('.rh_wrapper_language_switcher').toggleClass('parent_open');
                $(this).toggleClass('open');
                if($(this).hasClass('open')){
                    $('.rh_languages_available').fadeIn(200);
                }else{
                    $('.rh_languages_available').fadeOut(200);
                }
            }

            e.stopPropagation();
        });

        $('html').on('click',function () {
            $('.rh_wrapper_language_switcher').removeClass('parent_open');
            $('html .inspiry-language').removeClass('open');
            $('.rh_languages_available').fadeOut(200);
        });

        /*-----------------------------------------------------------------------------------*/
        /*	Owl Carousel
         /*-----------------------------------------------------------------------------------*/
        if (jQuery().owlCarousel) {
            $('.brands-owl-carousel').owlCarousel({
                nav: true,
                dots: false,
                navText: ['<i class="fas fa-caret-left"></i>', '<i class="fas fa-caret-right"></i>'],
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
                margin: 0,
                rtl: isRtl,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    },
                    1199: {
                        items: 5
                    }
                }
            });
        }

        /*-----------------------------------------------------------------------------------*/
        /*	VenoBox - Just another responsive jQuery lightbox plugin.
         /*-----------------------------------------------------------------------------------*/
        $window.on('load', function () {

            if (jQuery().venobox) {
                $('.clone .venobox').removeClass('venobox');
                $('.inspiry-lightbox-item, .venobox').venobox({
                    // autoplay : true,
                    // infinigall: true,
                    numeratio: true,
                    numerationPosition: 'bottom',
                    titlePosition: 'bottom'
                });
            }

            if (jQuery().swipebox) {
                $('a[data-swipebox-rel]').each(function () {
                    $(this).attr('rel', $(this).data('swipebox-rel'));
                });
            }
        });



        /*-----------------------------------------------------------------------------------*/
        /* Agent forms validation script for property detail page.
        /*-----------------------------------------------------------------------------------*/
        function inspiryValidateForm(form) {

            var $form = $(form),
                submitButton = $form.find('.submit-button'),
                ajaxLoader = $form.find('.ajax-loader'),
                messageContainer = $form.find('.message-container'),
                errorContainer = $form.find(".error-container"),
                formOptions = {
                    beforeSubmit: function () {
                        submitButton.attr('disabled', 'disabled');
                        ajaxLoader.fadeIn('fast');
                        messageContainer.fadeOut('fast');
                        errorContainer.fadeOut('fast');
                    },
                    success: function (ajax_response, statusText, xhr, $form) {
                        var response = $.parseJSON(ajax_response);
                        ajaxLoader.fadeOut('fast');
                        submitButton.removeAttr('disabled');
                        if (response.success) {
                            $form.resetForm();
                            messageContainer.html(response.message).fadeIn('fast');

                            // call reset function if it exists
                            if (typeof inspiryResetReCAPTCHA == 'function') {
                                inspiryResetReCAPTCHA();
                            }

                            if( typeof agentData !== 'undefined' ){
                                setTimeout(function(){
                                    window.location.replace(agentData.redirectPageUrl);
                                },1000);
                            }
                        } else {
                            errorContainer.html(response.message).fadeIn('fast');
                        }
                    }
                };

            $form.validate({
                errorLabelContainer: errorContainer,
                submitHandler: function (form) {
                    $(form).ajaxSubmit(formOptions);
                }
            });
        }

        if (jQuery().validate && jQuery().ajaxSubmit) {
            if ($body.hasClass('single-property')) {
                var getAgentForms = $('.agent-form');
                if (getAgentForms.length) {
                    $.each(getAgentForms, function (i, form) {
                        var id = $(form).attr("id");
                        inspiryValidateForm('#' + id);
                    });
                }
            }
        }


        /*-----------------------------------------------------------------------------------*/
        /*	Login Required Function
        /*-----------------------------------------------------------------------------------*/
        $('body').on('click','.inspiry_submit_login_required',function (e) {
            e.preventDefault();
            $('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
        });




        /*-----------------------------------------------------------------------------------*/
        /*	BootStrap Select
        /*-----------------------------------------------------------------------------------*/
        var inspirySelectPicker = function (id) {
            if (jQuery().selectpicker) {
                jQuery(id).selectpicker({
                    iconBase: 'fas',
                    dropupAuto: 'true',
					width: "100%",
                    size: 5,
                    tickIcon: 'fa-check',
                    selectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_select">' +
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><polygon points="22.1 9 20.4 7.3 14.1 13.9 15.8 15.6 "/><polygon points="27.3 7.3 16 19.3 9.6 12.8 7.9 14.5 16 22.7 29 9 "/><polygon points="1 14.5 9.2 22.7 10.9 21 2.7 12.8 "/></svg>' +
						'</span>',
                    deselectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_deselect"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><style type="text/css">  \n' +
                        '\t.rh-st0{fill:none;stroke:#000000;stroke-width:2;stroke-miterlimit:10;}\n' +
                        '</style><path class="inspiry_des rh-st0" d="M3.4 10.5H20c3.8 0 7 3.1 7 7v0c0 3.8-3.1 7-7 7h-6"/><polyline class="inspiry_des rh-st0" points="8.4 15.5 3.4 10.5 8.4 5.5 "/></svg></span>',

                });
            }
        };


        // if ($('.dsidx-resp-search-form')) {
        //     $('.dsidx-resp-search-form select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
		//
        //     if ($('.dsidx-sorting-control')) {
        //         $('.dsidx-sorting-control select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
        //     if ($('#dsidx-search-form-main')) {
        //         $('#dsidx-search-form-main select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
        //     if ($('#dsidx.dsidx-details')) {
        //         $('.dsidx-contact-form-schedule-date-row select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
		//
        //     inspirySelectPicker('body .inspiry_select_picker_trigger');
        // }


        inspirySelectPicker('body .inspiry_select_picker_trigger');
        inspirySelectPicker('body .widget_categories select');
        inspirySelectPicker('body .widget_archive select');



        // inspirySelectPicker('.inspiry_select_picker_mod');

        $(".inspiry_multi_select_picker_location").on('change', function () {
            $('.inspiry_multi_select_picker_location').selectpicker('refresh');
        });

        $(".inspiry_bs_submit_location").on('change', function () {
            $('.inspiry_bs_submit_location').selectpicker('refresh');
        });

        $(".inspiry_select_picker_status").on('change', function () {
            $('.inspiry_select_picker_price').selectpicker('refresh');
        });


        $('.inspiry_select_picker_trigger').on('show.bs.select', function () {
            $(this).parents('.rh_prop_search__option').addClass('inspiry_bs_is_open')
        });

        $('.inspiry_select_picker_trigger').on('hide.bs.select', function () {
            $(this).parents('.rh_prop_search__option').removeClass('inspiry_bs_is_open')
        });


        var inspiryAjaxSelect = function (parent, id) {


            var farmControl = $(parent).find('.form-control');

            var thisParent = $(id);

            farmControl.on('keyup', function (e) {


                var fieldValue = $(this).val();


                fieldValue = fieldValue.trim();

                var wordcounts = jQuery.trim(fieldValue).length;


                if (wordcounts > 0) {

                    $.ajax({
                        url: localizeSelect.ajax_url,
                        dataType: 'json',
                        delay: 250, // delay in ms while typing when to perform a AJAX search

                        data: {
                            action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                            keyword: fieldValue,
                            // hideemptyfields: localizeSelect.hide_empty_locations,
                            // sortplpha: localizeSelect.sort_location,
                        },
                        success: function (data) {
                            thisParent.find('option').not(':selected, .none').remove().end();
                            // var options = [];
                            if (fieldValue && data) {
                                var getSelected = $(thisParent).val();


                                jQuery.each(data, function (index, text) {

                                    if (getSelected) {
                                        if (getSelected.indexOf(text[0]) < 0) {
                                            thisParent.append(
                                                $('<option value="' + text[0] + '">' + text[1] + '</option>')
                                            );
                                        }
                                    } else {
                                        thisParent.append(
                                            $('<option value="' + text[0] + '">' + text[1] + '</option>')
                                        );
                                    }
                                });
                                thisParent.selectpicker('refresh');
                                $(parent).find('ul.dropdown-menu li:first-of-type a').focus();

                                $(parent).find('input').focus();

                            } else {
                                thisParent.find('option').not(':selected, .none').remove().end();
                                thisParent.selectpicker('refresh');

                                $(parent).find('ul.dropdown-menu li:first-of-type a').focus();

                                $(parent).find('input').focus();

                            }

                        },

                    });
                } else {
                    thisParent.find('option').not(':selected, .none').remove().end();
                    thisParent.selectpicker('refresh');
                }

            });

        };


        inspiryAjaxSelect('.inspiry_ajax_location_wrapper', 'select.inspiry_ajax_location_field');

    });

    $(window).on('load',function () {
        $('.inspiry_select_picker_trigger').selectpicker('refresh');
    });


    $(document).on('ready',function () {

        $('.inspiry_show_on_doc_ready').show();

    })

	/*-----------------------------------------------------------------------------------*/
	/* Favorite Properties
	/*-----------------------------------------------------------------------------------*/
		
	// Add to favorite.
	var addToFavorites = function (e) {
		e.preventDefault();

		if ($(this).hasClass('require-login')) {

			var loginBox = $('.rh_menu__user_profile');
			var loginModel = loginBox.find('.rh_modal');

			if (loginModel.length) {
				$('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
			} else {
				window.location = $(this).data('login');
			}
		} else {
			var favorite_link = $(this);
			var span_favorite = $(this).parent().find('span.favorite-placeholder');

			var propertyID = favorite_link.data('propertyid');
			var ajax_url   = ajaxurl;
			
			if ( propertyID !== '' ) {
				if(favorite_link.hasClass('user_logged_in')){
					var add_to_favorite_options = {
						type : 'post',
						url : ajax_url,
						data : {
							action: 'add_to_favorite',
							property_id : propertyID,
						},
						success: function(response) {
							if('false' !== response) {
								$(favorite_link).addClass('hide');
								$(span_favorite).delay(200).removeClass('hide');
							}
						}
					};
					$.ajax(add_to_favorite_options);
				} else {
					var currentIDs = window.localStorage.getItem('inspiry_favorites');

					if ( currentIDs ) {
						window.localStorage.setItem('inspiry_favorites', currentIDs + ',' + propertyID);
					} else {
						window.localStorage.setItem('inspiry_favorites', propertyID);
					}

					$(favorite_link).addClass('hide');
					$(span_favorite).delay(200).removeClass('hide');
				}
			}
			
		}
	};
	$('body').on('click', 'a.add-to-favorite', addToFavorites);
	
	var favorite_properties = window.localStorage.inspiry_favorites; // Get local favorite properties data.

	// Display favorited button and favorite properties on favorite page.
	if ( favorite_properties && ! $('body').hasClass( 'logged-in' ) ) {

		// To display favorited button on page load.
		var property_ids = favorite_properties.split(',');
		property_ids.forEach(function(element,index){
			var favorite_btn_wrap = $('.favorite-btn-' + element);
			var favorite_link = favorite_btn_wrap.find('a.add-to-favorite');
			var span_favorite = favorite_btn_wrap.find('span.favorite-placeholder');
			
			$(favorite_link).addClass('hide');
			$(span_favorite).delay(200).removeClass('hide');
		});

		// Display favorite properties on the favorites page.
		var favorite_prop_page = $('.favorite_properties_ajax');
		if(favorite_prop_page.length) {

			var design_variation = 'classic';
			if($('body').hasClass('design_modern')){
				design_variation = 'modern';
			}

			var favorite_prop_options = {
				type : 'post',
				dataType : 'html',
				url : ajaxurl,
				data : {
					action: 'display_favorite_properties',
					prop_ids : favorite_properties.split(','),
					design_variation
				},
				success: function(response) {
					favorite_prop_page.html(response);
					remove_from_favorite($('a.remove-from-favorite'), true);
				}
			};
			$.ajax(favorite_prop_options);
		}			
	}

	// Migrate favorite properties from local to server.
	if(favorite_properties && $('body').hasClass('logged-in')){
		var migrate_prop_options = {
			type : 'post',
			url : ajaxurl,
			data : {
				action: 'inspiry_favorite_prop_migration',
				prop_ids : favorite_properties.split(','),
			},
			success: function(response) {
				if ( 'true' === response ) {
					window.localStorage.removeItem('inspiry_favorites');
				}
			}
		};
		$.ajax(migrate_prop_options);
	}

	// Remove favorite properties.
	remove_from_favorite($('a.remove-from-favorite'));
	function remove_from_favorite(remove_button, localFavorite = false){
		remove_button.on('click', function (event) {
			event.preventDefault();

			var $this = $(this);
			var property_item = $this.closest('article');

			if( localFavorite ) {
				var favorite_properties = window.localStorage.inspiry_favorites;
				if(favorite_properties){
					var prop_ids = favorite_properties.split(',');
					var prop_ids = $.map(favorite_properties.split(','), function(value){
						return parseInt(value);
					});
					const index = prop_ids.indexOf( $this.data('property-id'));
					if (index > -1) {
						property_item.remove();
						prop_ids.splice(index, 1);
						window.localStorage.setItem('inspiry_favorites', prop_ids);
					}
				}
				
				return;
			}
			
			var close = $(this).find('i');

			close.addClass('fa-spin');

			var remove_favorite_request = $.ajax({
				url: $this.attr('href'),
				type: "POST",
				data: {
					property_id: $this.data('property-id'),
					action: "remove_from_favorites"
				},
				dataType: "json"
			});

			remove_favorite_request.done(function (response) {
				close.removeClass('fa-spin');
				if (response.success) {
					property_item.delay(200).remove();
				}
			});

			remove_favorite_request.fail(function (jqXHR, textStatus) {
			});
		});
	}

})(jQuery);