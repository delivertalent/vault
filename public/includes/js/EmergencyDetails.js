$(document).ready(function() {
	
	
	$('#dateofbirth').datepicker({
		'format': 'dd/mm/yyyy'
		//'endDate': dateFormat(new Date(), "DD/MM/YYYY")
	}).on('changeDate', function(e){
			$('#dateofbirth').datepicker('hide');
	});
	

	
    $('#btnAddUser').click(function()
    {
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('#eid').val('');
        $('#zoneid').val('');
        $('#zonename').val('');
        $('#description').val('');
        $('#lat').val('');
        $('#longituge').val('');    
        $('#modatTitle').html('Add Injured Information');
        $('#responsive_modal').modal('show');
        $('.alert-danger').hide();
        $('.alert-success').hide();
    });
	
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
                    /*injured_name: {
                        required: true
                    },*/
                    injured_age: {
                        required: true,
                        digits: true
                    },
                    injured_sex: {
                        required: true
                    },
                    /*injured_description: {
                        required: true
                    },
                    injured_type: {
                        required: true
                    },*/
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
                                url : '../save-injured',
                                data : {
                                    eid : $('#eid').val(),
                                    emergencies_id : $('#emer_id').val(),
                                    injured_name : $('#injured_name').val(),
                                    injured_age : $('#injured_age').val(),
                                    injured_sex : $('#injured_sex').val(),
                                    injured_description : $('#injured_description').val(),
                                    injured_type : $('#injured_type').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    //alert(data.status)
                                    if(data.status == "success"){
                                        var sexInfo = '';
                                        if($('#injured_sex').val()==1){sexInfo="Male";}
                                        else{sexInfo="Female";}
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>&nbsp<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            $('#injured_name').val(),
                                            $('#injured_age').val(),
                                            sexInfo,
                                            $('#injured_type').val(), 
                                            $('#injured_description').val(),
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#injured_name').val('');
                                        $('#injured_age').val('');
                                        $('#injured_sex').val(1);
                                        $('#injured_type').val('');
                                        $('#injured_description').val(''); 
                                        $('.alert-success').html('Injured information Successfully Added.');   
                                          success2.show();

                                    }
                                    if(data.status == "updated"){
                                         var rowPos = $('#rowPos').val();
                                         var sexInfo = '';
                                         if($('#injured_sex').val()==1){sexInfo="Male";}
                                         else{sexInfo="Female";}

                                         oTable.fnUpdate( $('#injured_name').val(), parseInt(rowPos), 0);   
                                         oTable.fnUpdate( $('#injured_age').val(), parseInt(rowPos), 1);   
                                         oTable.fnUpdate( sexInfo, parseInt(rowPos), 2);   
                                         oTable.fnUpdate( $('#injured_description').val(), parseInt(rowPos), 3);   
                                         oTable.fnUpdate( $('#injured_type').val(), parseInt(rowPos), 4);   
                                     $('#responsive_modal').modal('hide');    
                                    }
                                    if(data.status == "idExists"){
                                        $('.alert-danger').html(data.message);   
                                          success2.hide();
                                          error2.show();
                                          App.scrollTo(error2, -200);                                       
                                    }
                                    
                                    
                                }
                            });
                   
                }
            });
});

//$(".edit").on("click", function(event){
$('body').on('click','.change',function(){   
 
    var elementID = $(this).attr("id");
    var splitID= elementID.split("_");
    var getVal=$('#'+splitID[0]).val();
    var eid=$('#emid').val();

    if(getVal!=''){
          $.ajax({
                type : 'post',
                url : '../update-emergency',
                data : {
                    splitID : splitID[0],
                    getVal : getVal,
                    eid : eid,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["zonename"]));   
                }
            });

    }
});


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
                url : '../get-injured',
                data : {
                    id : id,
                },
                dataType : 'json',
                success : function(data) {

                    //alert(JSON.stringify(data[0]["zonename"]));
                    $('.form-group').removeClass('has-error').removeClass('has-success');
                    $('#eid').val(data[0].id);
                    $('#injured_name').val(data[0].injured_name);
                    $('#injured_age').val(data[0].injured_age);
                    $('#injured_sex').val(data[0].injured_sex);
                    $('#injured_type').val(data[0].injured_type);
                    $('#injured_description').val(data[0].injured_description);
                    $('#rowPos').val(aPos);
                    $('#modatTitle').html('Edit Injured Information');
                    $('#responsive_modal').modal('show');     
                }
            });
    }
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
            url : '../delete-injured',
            data : {
                id : id,
            },
            dataType : 'json',
            success : function(data) {
    
            }
        });

    }    
});



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
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                }
            });



            jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_2_wrapper .dataTables_length select').select2(); // initialize select2 dropdown





        }

    };

}();
