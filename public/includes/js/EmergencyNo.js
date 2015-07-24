var map
(function(jQuery) {
  function initialize() {
            var styles = [
                {
                  featureType: 'landscape',
                  elementType: "geometry",
                  stylers: [
                    { hue: "#fff" },
                    { lightness: 100 },
                    { saturation: -100 }
                  ]
                }, {
                  featureType: 'road',
                  stylers: [
                    {visibility: 'on'}
                  ]
                }, {
                  featureType: 'poi.park',
                  stylers: [{visibility: 'off'}]
                }, {
                  featureType: 'road.arterial',
                  stylers: [{visibility: 'on'}]
                }, {
                  featureType: 'road.local',
                  stylers: [{visibility: 'off'}]
                }      
            ];

    var mapOptions = {
      center: new google.maps.LatLng(23.7, 90.3833),
      zoom: 9,
      navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
     map = new google.maps.Map(document.getElementById("mapContainer"),
        mapOptions);
    map.setOptions({styles: styles});
  }
  jQuery(document).ready(initialize);
})(jQuery)
jQuery(document).ready(function() {  
 $('#landMarkTable').dataTable({
            "aLengthMenu": [
                [5, 10, 20, -1],
                [5, 10, 20, "All"] // change per page values here
            ],
            // set the initial value
            "iDisplayLength": 5,
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": "_MENU_ records",
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0]
                }
            ]
        });
        
     jQuery('#landMarkTable_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
     jQuery('#landMarkTable_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
     jQuery('#landMarkTable_wrapper .dataTables_length select').select2(); // initialize select2 dropdown 

jQuery("#mapBtn").click(function(){
        var markers = [];
        var infowindow =  new google.maps.InfoWindow({
                            content: ''
                        });

        $('#responsive').modal('show');   
        $.ajax({
            type : 'get',
            url : 'get-latl-long',
            data : {
            },
            dataType : 'json',
            success : function(data) {
                //alert(data);
                //alert(JSON.stringify(data[0]["zonename"]));
                //$('#mapContainer').html(data.landmarks[0]);

                    $.each(data, function(index, element) {
                        //alert(element.long);
                        var _color = "#DF0038";
                        var point = new google.maps.LatLng(
                            parseFloat(element.lat),
                            parseFloat(element.long));
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            title: element.landmarkname

                          });
                        markers.push(marker);
                        var landMarkInfo = element.id+'_'+element.landmarkname;
                        bindInfoWindow(marker, map, infowindow, landMarkInfo);
                    });


                $('#responsive').modal('show');     
                  google.maps.event.trigger(map, 'resize');
                  // also redefine center
                  map.setCenter(new google.maps.LatLng(23.7000, 90.3750));
            }
        });    
    });


    
});

function bindInfoWindow(marker, map, infowindow, html) { 
    google.maps.event.addListener(marker, 'click', function() { 

        //$('#remk').modal('hide');
        var landMarkInfo = html.split("_")
        $('#setLandID').val(landMarkInfo[0]);
        $('#remarkTitle').html('Landmark: '+landMarkInfo[1]);
        //infowindow.setContent(html); 
       // infowindow.open(map, marker); 
       $('#remk').modal('show');
    }); 
    
}

jQuery('#remarkPopBtn').on('click', function() {
     var prpRemark = $('#remarkNotePop').val();
     $('#remarkNote').val(prpRemark);
     $( ".button-next" ).trigger( "click" );
     $('#remk').modal('hide');
     $('#responsive').modal('hide');
});

        jQuery('input.locationCheck').on('change', function() {

                var set = "#lend .checkboxes";
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", false);
                    }
                });
                $(this).attr("checked", true);
                $("#setLandID").val($(this).attr("value"));
                jQuery.uniform.update(set);
        });

var FormWizard = function () {


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            var checkIfFieldVisible = function() {
                   if($('#setLandID').val()=='')
                        return true;
                    else return false;
                };

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //account
                    
                    'emergencies_location[]': {
                        required: { depends: checkIfFieldVisible },
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
/*                    'payment[]': {
                        required: "Please select at least one option",
                        minlength: jQuery.format("Please select at least one option")
                    }*/
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "gender") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_gender_error");
                    } else if (element.attr("name") == "emergencies_location[]") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_payment_error");
                    }/*else if (element.attr("name") == "responderZone[]") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_payment_error");
                    }*/ else {
                       var icon = $(element).parent('.input-icon').children('i');
                                    icon.removeClass('fa-check').addClass("fa-warning");  
                                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'}); 
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();

                    form.submit();
                    
/*                    var checkedValue = $('.responderZoneClass:checked').val();
                    alert(checkedValue);
                    $("#sample3 td input:checked").each(function()
                    {
                    alert($(this).attr("id"));
                    });

                         $('input:checkbox[name=locationthemes]').each(function() 
                        {    
                            if($(this).is(':checked'))
                              alert($(this).val());
                        });*/                   
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = function() {
                $('#tab3 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'emergencies_location') {
                        var emergencies_location = [];
                        $('[name="emergencies_location[]"]').each(function(){
                            emergencies_location.push($(this).attr('data-title'));
                        });
                        $(this).html(emergencies_location.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
            }).hide();
        }

    };

}();