$(document).ready(function() {
	
	$('#btnAddUser').click(function()
	{
        //Parameter List:
        //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
        //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('.alert-danger').hide();
        $('#did').val('');
        $('#job_name').val('');
        $('#job_status').val('');
        $('#customer_first_name').val('');
        $('#customer_last_name').val('');
        $('#customer_phone').val('');
        $('#job_customer_id').val('');
        $('#job_designer_id').val('');
        $('#job_install_date').val('');
        $('#job_address1').val(''); 
        $('#job_address2').val('');    
        $('#job_city').val('');    
        $('#job_state_id').val(''); 
        $('#job_zip').val('');  
        $('#job_development_name').val('');  
        $('#job_gated').val('');  
        $('#job_alarm').val('');  
        $('#job_condo').val('');    
        $('#job_stairs').val('');    
        $('#job_elevator').val(''); 
        $('#job_house_sqft').val(''); 
        $('#job_comments').val('');	
        var two =$(".checkboxClass").attr("checked", false);
        $.uniform.update(two);   
        $('#modatTitle').html('Add New Job');
        $('#jobform').show();
        App.scrollTo($('#customer_first_name'), -200);
       // $('#responsive').modal('show');
	});

    $( "#customer_first_name" ).autocomplete({
      source: 'get_customerList',
      change: function( event, ui ) {
        $('#customer_last_name').val('');
        $('#customer_phone').val('');
        $('#job_customer_id').val('');        
      },
      select: function( event, ui ) {
        var id= ui.item.value;
        if(id!=''){
          $.ajax({
                type : 'get',
                url : 'get-lastname-email',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                   if(data.status == "success"){
                    $('#customer_last_name').val(data.last_name); 
                    $('#customer_phone').val(data.customer_phone); 
                    $('#job_customer_id').val(data.id); 
                   }

                }
            });//End of Ajax.
        } //End of if.

      }
    });	
    /*$('#customer_first_name').typeahead({
                  name: 'homechange',
                  remote : 'get_customerList/%QUERY'
    });	*/
});


$('#jobCancel').bind("click", function(event) {
     $('#jobform').hide();
     App.scrollTo($('#jobTop'), -200);
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
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",
                rules: {
                    job_name: {
                        minlength: 2,
                        required: true
                    },
                    /*job_designer_id: {
                        required: true
                    },
                    job_address1: {
                        required: true
                    },
                    job_city: {
                        required: true
                    },
                    job_state_id: {
                        required: true
                    },
                    job_zip: {
                        required: true
                    },
                    job_development_name: {
                        required: true
                    }, */  
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
                    var el = jQuery("#responsive");
                    App.blockUI(el);
                          $.ajax({
                                type : 'POST',
                                url : 'save-job',
                                //Parameter List:
                                //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                                data : {
                                    id : $('#did').val(),
                                    job_name : $('#job_name').val(),
                                    job_status : $('#job_status').val(),
                                    customer_first_name : $('#customer_first_name').val(),
                                    customer_last_name : $('#customer_last_name').val(),
                                    customer_phone : $('#customer_phone').val(),
                                    job_customer_id : $('#job_customer_id').val(),
                                    job_designer_id : $('#job_designer_id').val(),
                                    job_install_date : $('#job_install_date').val(),
                                    job_address1 : $('#job_address1').val(),
                                    job_address2 : $('#job_address2').val(),
                                    job_city : $('#job_city').val(),
                                    job_state_id : $('#job_state_id').val(),
                                    job_zip : $('#job_zip').val(),
                                    job_development_name : $('#job_development_name').val(),
                                    job_gated : $('#job_gated').is(':checked') ? 1 : 0,
                                    job_alarm : $('#job_alarm').is(':checked') ? 1 : 0,
                                    job_condo : $('#job_condo').is(':checked') ? 1 : 0,
                                    job_stairs : $('#job_stairs').is(':checked') ? 1 : 0,
                                    job_elevator : $('#job_elevator').is(':checked') ? 1 : 0,
                                    job_house_sqft : $('#job_house_sqft').val(),
                                    job_comments : $('#job_comments').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //Parameter List:
                                    //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                    //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                                    if(data.status == "success"){
                                        var status ='';
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>';
                                        if($('#job_status').val() ==1)
                                            status = "New";
                                        else if($('#job_status').val() ==2)
                                            status = "In Progress";
                                        else if($('#job_status').val() ==3)
                                            status = "Closed";
                                        else{
                                            status = "";
                                        }

                                        $('#sample_2').dataTable().fnAddData( [
                                            '<a href="javascript:void(0)"><b>'+$('#job_name').val()+'</b></a>',
                                            data.customerName,
                                            data.designerName,
                                            status,
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#job_name').val('');
                                        $('#job_status').val('');
                                        $('#customer_first_name').val('');
                                        $('#customer_last_name').val('');
                                        $('#customer_phone').val('');
                                        $('#job_customer_id').val('');
                                        $('#job_designer_id').val('');
                                        $('#job_install_date').val('');
                                        $('#job_address1').val(''); 
                                        $('#job_address2').val('');    
                                        $('#job_city').val('');    
                                        $('#job_state_id').val('');
                                        $('#job_zip').val('');
                                        $('#job_development_name').val('');  
                                        $('#job_gated').val('');  
                                        $('#job_alarm').val('');  
                                        $('#job_condo').val('');    
                                        $('#job_stairs').val('');    
                                        $('#job_elevator').val(''); 
                                        $('#job_house_sqft').val(''); 
                                        $('#job_comments').val(''); 
                                        var two =$(".checkboxClass").attr("checked", false);
                                        $.uniform.update(two);  
                                        $('.alert-success').html('New Job Successfully Created.');   
                                          success2.show();
                                          App.scrollTo(success2, -200); 
                                          

                                    }
                                    if(data.status == "updated"){

                                        var status ='';
                                         if($('#job_status').val() ==1)
                                            status = "New";
                                        else if($('#job_status').val() ==2)
                                            status = "In Progress";
                                        else if($('#job_status').val() ==3)
                                            status = "Closed";
                                        else{
                                            status = "";
                                        }
                                         var rowPos = $('#rowPos').val(); 

                                         oTable.fnUpdate( '<a href="javascript:void(0)"><b>'+$('#job_name').val()+'</b></a>', parseInt(rowPos), 0);  
                                         oTable.fnUpdate( data.customerName, parseInt(rowPos), 1); 
                                         oTable.fnUpdate( data.designerName, parseInt(rowPos), 2);   
                                         oTable.fnUpdate( status, parseInt(rowPos), 3);   
                                         /*oTable.fnUpdate( $('#longituge').val(), parseInt(rowPos), 5); */  
                                     App.scrollTo($("topFlug"), -200); 
                                     $('#jobform').hide();    
                                    }
                                    if(data.status == "idExists"){
                                        $('.alert-danger').html(data.message);   
                                          success2.hide();
                                          error2.show();
                                          App.scrollTo(error2, -200);                                       
                                    }
                                    
                                    
                                }
                            });
                           // App.unblockUI(el);
                   
                }
            });
});


$('body').on('click','.del',function(){    
    var r=confirm("Do you want to Delete this Customer?");
    if (r==true){
        var target_row = $(this).closest("tr").get(0); // this line did the trick
        var aPos = oTable.fnGetPosition(target_row); 
        oTable.fnDeleteRow(aPos); // Delete Datatable Row
        var elementID = $(this).attr("id");
        var splitID= elementID.split("_");
        var id=splitID[1];
        if(id!=''){
          $.ajax({
                type : 'delete',
                url : 'delete-customers',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                }
            });//End of Ajax.
        } //End of if.
      }
    else{ return false; }    
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
                url : 'get-job',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                    //Parameter List:
                                //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#did').val(data.id);
                    $('#job_name').val(data.job_name);
                    $('#job_status').val(data.job_status);

                    $('#customer_first_name').val(data.customer_first_name);
                    $('#customer_last_name').val(data.customer_last_name);
                    $('#customer_phone').val(data.customer_phone);

                    $('#job_customer_id').val(data.job_customer_id);
                    $('#job_designer_id').val(data.job_designer_id);
                    $('#job_install_date').val(data.job_install_date);
                    $('#job_address1').val(data.job_address1);
                    $('#job_address2').val(data.job_address2);
                    $('#job_city').val(data.job_city);
                    $('#job_state_id').val(data.job_state_id);
                    $('#job_zip').val(data.job_zip);
                    $('#job_development_name').val(data.job_development_name);

                    if(data.job_gated ==1)
                        $("#job_gated").attr("checked", true);
                    else
                         $("#job_gated").attr("checked", false);

                    if(data.job_alarm ==1)
                        $("#job_alarm").attr("checked", true);
                    else
                         $("#job_alarm").attr("checked", false);

                    if(data.job_condo ==1)
                        $("#job_condo").attr("checked", true);
                    else
                         $("#job_condo").attr("checked", false);

                    if(data.job_stairs ==1)
                        $("#job_stairs").attr("checked", true);
                    else
                         $("#job_stairs").attr("checked", false);  
                         
                    if(data.job_elevator ==1)
                        $("#job_elevator").attr("checked", true);
                    else
                         $("#job_elevator").attr("checked", false);
                                                                                          
                    $.uniform.update($(".checkboxClass"));
                    var flotingData = Number(data.job_house_sqft).toFixed(2);
                    $('#job_house_sqft').val(flotingData); 
                    $('#job_comments').val(data.job_comments);

                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Job');
                    $('#jobform').show();
                    App.scrollTo($('#customer_first_name'), -200);   
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
                "order": [[ 0, "desc" ]],
                "iDisplayLength": -1,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': true,
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


