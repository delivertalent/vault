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
        $('#lid').val('');
        $('#landmarkname').val('');
        $('#description').val('');
        $('#zoneid').val('');
        $('#lat').val('');
        $('#longituge').val('');	
        $('#modatTitle').html('Add Landmark');
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
                    landmarkname: {
                        minlength: 2,
                        required: true
                    },
                    zoneid: {
                        required: true
                    },                           
                    lat: {
                        minlength: 2,
                        required: true
                    },
                    longituge: {
                        minlength: 2,
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
                                url : 'save-landmark',
                                data : {
                                    id : $('#lid').val(),
                                    landmarkname : $('#landmarkname').val(),
                                    description : $('#description').val(),
                                    zoneid : $('#zoneid').val(),
                                    lat : $('#lat').val(),
                                    longituge : $('#longituge').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    //alert(data.status)
                                    if(data.status == "success"){
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>&nbsp;<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            $('#landmarkname').val(),
                                            data.zoneName,
                                            
                                            $('#lat').val(), 
                                            $('#longituge').val(),
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#landmarkname').val('');
                                        $('#description').val('');
                                        $('#zoneid').val('');
                                        $('#lat').val('');
                                        $('#longituge').val(''); 
                                        $('.alert-success').html('New Landmark Successfully Added.');   
                                          success2.show();

                                    }
                                    if(data.status == "updated"){
                                         var rowPos = $('#rowPos').val();   
                                         oTable.fnUpdate( $('#landmarkname').val(), parseInt(rowPos), 0);   
                                         oTable.fnUpdate( data.zoneName, parseInt(rowPos), 1);                                              
                                         oTable.fnUpdate( $('#lat').val(), parseInt(rowPos), 2);   
                                         oTable.fnUpdate( $('#longituge').val(), parseInt(rowPos), 3);   
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
            url : 'delete-landmark',
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
                url : 'get-landmark',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["landmarkname"]));
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#lid').val(data[0].id);
                    $('#landmarkname').val(data[0].landmarkname);
                    $('#description').val(data[0].description);
                    $('#zoneid').val(data[0].zoneid);
                    $('#lat').val(data[0].lat);
                    $('#longituge').val(data[0].long);
                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Landmark');
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
