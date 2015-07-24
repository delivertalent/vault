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
        $('#did').val('');
        $('#firm_name').val('');
        $('#first_name').val('');
        $('#last_name').val('');
        $('#primary_address').val('');
        $('#primary_address_two').val('');
   
        $('#phone').val('');    
        $('#email').val('');    
        $('#mpassword').val('');    
        $('.alert-success').hide(); 
        $('.alert-danger').hide(); 
        $('#modatTitle').html('Add Warehouse Manager');
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
            var scrollFlug = $('.scrollFlug', form2);
            var intRegex = /^\d+$/;
            $('.alert-danger').html('You have some form errors. Please check below.');

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    first_name: {
                        minlength: 2,
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        email: true,
                        required: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                   App.scrollTo($('#modatTitle'), -200);
                    success2.hide();
                    error2.show();
                    
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
                                url : 'save-manager',
                                //did firm_name first_name  last_name  primary_address primary_address_two city state phone email
                                data : {
                                    id : $('#did').val(),
                                    first_name : $('#first_name').val(),
                                    last_name : $('#last_name').val(),
                                    primary_address : $('#primary_address').val(),
                                    primary_address_two : $('#primary_address_two').val(),
                                    phone : $('#phone').val(),
                                    email : $('#email').val(),
                                    mpassword : $('#mpassword').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //alert(data.status)
                                    // //did firm_name first_name  last_name  primary_address primary_address_two city state phone email
                                    if(data.status == "success"){
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>&nbsp<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            $('#first_name').val(),
                                            $('#last_name').val(),
                                            $('#email').val(),
                                            $('#phone').val(), 
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#first_name').val('');
                                        $('#last_name').val('');
                                        $('#primary_address').val('');
                                        $('#primary_address_two').val('');
                                        $('#phone').val('');    
                                        $('#email').val('');
                                        $('#mpassword').val('');
                                        $('.alert-success').html('New Warehouse Manager Successfully Created.');   
                                          success2.show();
                                          App.scrollTo($('#modatTitle'), -200); 

                                    }
                                    if(data.status == "updated"){
                                         var rowPos = $('#rowPos').val();
                                         var status = '';
                                         oTable.fnUpdate( $('#first_name').val(), parseInt(rowPos), 0);   
                                         oTable.fnUpdate( $('#last_name').val(), parseInt(rowPos), 1);  
                                         oTable.fnUpdate( $('#email').val(), parseInt(rowPos), 2); 
                                         oTable.fnUpdate( $('#phone').val(), parseInt(rowPos), 3);   
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
    var r=confirm("Do you want to Delete this Client?");
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
                url : 'delete-designer',
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
                url : 'get-designer',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["zonename"]));
                    /*did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email*/
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#did').val(data.id);
                    $('#firm_name').val(data.firm_name);
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('#primary_address').val(data.primary_address);
                    $('#primary_address_two').val(data.primary_address_two);
                    $('#city').val(data.city);
                    $('#state').val(data.state);
                    $('#phone').val(data.phone);
                    $('#email').val(data.email);
                    $('#zip_code').val(data.zip_code);
                    if(data.status!=1){data.status=0}
                    $('#status').val(data.status);
                    $('#accountStatus').show();

                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Clients');
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
