$(document).ready(function() {
	
	// Add User ---
	$('#btnAddUser').click(function()
	{
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('#did').val('');
        $('#designer_name').val('');
        $('#designer_email').val('');
        $('#designer_phone').val('');
        $('#modatTitle').html('Add Additional User');
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
                    designer_name: {
                        required: true
                    },
                    designer_email: {
                        email: true,
                        minlength: 2,
                        required: true
                    },
                    designer_phone: {
                        minlength: 4,
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
                    var el = jQuery("#responsive");
                    App.blockUI(el);
                          $.ajax({
                                type : 'POST',
                                url : '../../save-additional-designer',
                                //did designer_name designer_email  designer_phone  primary_address primary_address_two city state phone email
                                data : {
                                    id : $('#did').val(),
                                    designer_name : $('#designer_name').val(),
                                    designer_email : $('#designer_email').val(),
                                    designer_phone : $('#designer_phone').val(),
                                    fromAdmin : $('#firmID').val(),
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //alert(data.status)
                                    // //did designer_name designer_email  designer_phone  primary_address primary_address_two city state phone email
                                    if(data.status == "success"){
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>&nbsp<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            $('#designer_name').val(),
                                            $('#designer_email').val(),
                                            $('#designer_phone').val(),
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#designer_name').val('');
                                        $('#designer_email').val('');
                                        $('#designer_phone').val('');
                                        $('.alert-success').html('Additional User Successfully Created.');   
                                          success2.show();
                                          App.scrollTo(success2, -200); 

                                    }
                                    if(data.status == "updated"){
                                         var rowPos = $('#rowPos').val();
                                         oTable.fnUpdate( $('#designer_name').val(), parseInt(rowPos), 0);   
                                         oTable.fnUpdate( $('#designer_email').val(), parseInt(rowPos), 1);  
                                         oTable.fnUpdate( $('#designer_phone').val(), parseInt(rowPos), 2); 
                                         /*oTable.fnUpdate( $('#longituge').val(), parseInt(rowPos), 5); */  
                                     $('#responsive').modal('hide');    
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
    var r=confirm("Do you want to Delete this User?");
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
                url : '../../delete-additional-designer',
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
                url : '../../get-additional-designer',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["zonename"]));
                    /*did, designer_name, designer_email, designer_phone, primary_address, primary_address_two, city, state, phone, email*/
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#did').val(data.id);
                    $('#designer_name').val(data.designer_name);
                    $('#designer_email').val(data.designer_email);
                    $('#designer_phone').val(data.designer_phone);
                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Additional User');
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
