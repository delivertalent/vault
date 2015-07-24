$(document).ready(function() {
	
	
	$('#dateofbirth').datepicker({
		'format': 'dd/mm/yyyy'
		//'endDate': dateFormat(new Date(), "DD/MM/YYYY")
	}).on('changeDate', function(e){
			$('#dateofbirth').datepicker('hide');
	});
	
	// Add User ---
	$('#btnAddUser').click(function()
	{
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('#hid').val('');
        $('#hospital_name').val('');
        $('#hospital_location').val('');
        $('#service_lavel').val('');
        $('#lat').val('');
        $('#longituge').val('');
        $('#contact_number').val('');   
        $('#hospital_email').val('');   
        $('#hospital_hotline').val('');   
        $('#hospital_landline').val('');    
        $('#hospital_fax').val('');	
        $('#modatTitle').html('Add Hospital');
        $('#responsive').modal('show');
	});
	
/*	$('#btnSave').click(function()
	{
		saveUser();
	});*/
	
});


$('#btnSave').bind("click", function(event) {

            var form2 = $('#form_sample_2');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
            var intRegex = /^\d+$/;
            $('.alert-danger').html('You have some form errors. Please check below.');

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    hospital_name: {
                        required: true,
                        minlength: 2
                    },
                    service_lavel: {
                        number: true,
                        required: true
                    },
                    contact_number: {
                        minlength: 2,
                        number: true,
                        required: true
                    },
                    lat: {
                        minlength: 2,
                        number: true,
                        required: true
                    },
                    longituge: {
                        minlength: 2,
                        number: true,
                        required: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    error2.hide();
                          $.ajax({
                                type : 'POST',
                                url : 'save-hospital',
                                data : {
                                    id : $('#hid').val(),
                                    hospital_name : $('#hospital_name').val(),
                                    hospital_location : $('#hospital_location').val(),
                                    service_lavel : $('#service_lavel').val(),
                                    lat : $('#lat').val(),
                                    longituge : $('#longituge').val(),                                    
                                    contact_number : $('#contact_number').val(),
                                    hospital_email : $('#hospital_email').val(),
                                    hospital_hotline : $('#hospital_hotline').val(),
                                    hospital_landline : $('#hospital_landline').val(),
                                    hospital_fax : $('#hospital_fax').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    //alert(data.status)
                                    if(data.status == "success"){
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>&nbsp;<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            $('#hospital_name').val(),
                                            $('#hospital_location').val(),
                                            $('#service_lavel').val(), 
                                            $('#contact_number').val(),
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                            $('#hospital_name').val('');
                                            $('#hospital_location').val('');
                                            $('#service_lavel').val('');
                                            $('#lat').val('');
                                            $('#longituge').val('');
                                            $('#contact_number').val('');   
                                            $('#hospital_email').val('');   
                                            $('#hospital_hotline').val('');   
                                            $('#hospital_landline').val('');    
                                            $('#hospital_fax').val(''); 
                                        $('.alert-success').html('New Hospital Successfully Added.');   
                                          success2.show();

                                    }
                                    if(data.status == "updated"){
                                         var rowPos = $('#rowPos').val();
                                         oTable.fnUpdate( $('#hospital_name').val(), parseInt(rowPos), 0);   
                                         oTable.fnUpdate( $('#hospital_location').val(), parseInt(rowPos), 1); 
                                         oTable.fnUpdate( $('#service_lavel').val(), parseInt(rowPos), 2);   
                                         oTable.fnUpdate( $('#contact_number').val(), parseInt(rowPos), 3);   
                                     $('#responsive').modal('hide');    
                                    }
                                    
                                    
                                    
                                }
                            });
                   
                }
            });
});


$('body').on('click','.del',function(){     
    var target_row = $(this).closest("tr").get(0); // this line did the trick
    var aPos = oTable.fnGetPosition(target_row); 
    oTable.fnDeleteRow(aPos);
    var elementID = $(this).attr("id");
    var splitID= elementID.split("_");
    var id=splitID[1];
    if(id!=''){
      $.ajax({
            type : 'delete',
            url : 'delete-hospital',
            data : {
                id : id,
            },
            dataType : 'json',
            success : function(data) {
    
            }
        });

    }    
});

//$(".edit").on("click", function(event){
$('body').on('click','.edit',function(){   
   $('.alert-success').hide(); 
   $('.alert-danger').hide(); 
    var target_row = $(this).closest("tr").get(0); // this line did the trick
    var aPos = oTable.fnGetPosition(target_row); 

    var elementID = $(this).attr("id");
    var splitID= elementID.split("_");
    var id=splitID[1];

    if(id!=''){
          $.ajax({
                type : 'get',
                url : 'get-hospital',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["hospital_location"]));
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#hid').val(data[0].id);
                    $('#hospital_name').val(data[0].hospital_name);
                    $('#hospital_location').val(data[0].hospital_location);
                    $('#lat').val(data[0].lat);
                    $('#longituge').val(data[0].longituge);
                    $('#service_lavel').val(data[0].service_lavel);
                    $('#contact_number').val(data[0].contact_number);
                    $('#hospital_email').val(data[0].hospital_email);
                    $('#hospital_hotline').val(data[0].hospital_hotline);
                    $('#hospital_landline').val(data[0].hospital_landline);
                    $('#hospital_fax').val(data[0].hospital_fax);
                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Hospital');
                    $('#responsive').modal('show');     
                }
            });

    }
});




function dateFormat(date, format) {
	format = format.replace("DD", (date.getDate() < 10 ? '0' : '') + date.getDate());
	format = format.replace("MM", (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1));
	format = format.replace("YYYY", date.getFullYear());
	return format;
}



var TableManaged = function () {

    return {

        //main function to initiate the module
        init: function () {
            
            if (!jQuery().dataTable) {
                return;
            }

            // begin second table
           oTable =  $('#sample_2').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
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

            jQuery('#sample_2 .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).attr("checked", true);
                    } else {
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);
            });

            jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_2_wrapper .dataTables_length select').select2(); // initialize select2 dropdown





        }

    };

}();
