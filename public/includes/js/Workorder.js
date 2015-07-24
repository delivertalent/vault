var destroy = "no";
var currentTime = new Date();
    var day = currentTime.getDate();
    var month = currentTime.getMonth() + 1;
    var year = currentTime.getFullYear();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();

    if (day < 10)
    day = "0" + day;

    if (month < 10)
    month = "0" + month;

    if (hours < 10)
        hours = "0" + hours;

    if (minutes < 10)
        minutes = "0" + minutes;

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
        $('#wo_delivery_date').val(year+'-'+month+'-'+day);
        $('#wo_delivery_time').val(hours+':'+minutes);
        $('#notes').val('');
        $('#wo_requests').val('');
          
        $('#modatTitle').html('Add Work Order');
        $('#jobform').show();
        App.scrollTo($('#wo_delivery_date'), -200);
       // $('#responsive').modal('show');
	});
	
/*	$('#btnSave').click(function()
	{
		saveUser();

	});*/
	
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
                        required: true
                    },
                    wo_delivery_date: {
                        required: true
                    },
                    wo_delivery_time: {
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
                    var el = jQuery("#jobform");
                    App.blockUI(el);

                    var invtorylist = [];
                   $(':checkbox:checked').each(function(i){
                      invtorylist[i] = $(this).val();
                    });

                          $.ajax({
                                type : 'POST',
                                url : 'create-workorder',
                                //Parameter List:
                                //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                                data : {
                                    id : $('#did').val(),
                                    job_name : $('#job_name').val(),
                                    wo_delivery_date : $('#wo_delivery_date').val(),
                                    wo_delivery_time : $('#wo_delivery_time').val(),
                                    notes : $('#notes').val(),
                                    wo_requests : $('#wo_requests').val(),
                                    inventory : invtorylist
                                },
                                dataType : 'json',
                                success : function(data) {
                                    //App.unblockUI(el);
                                    //Parameter List:
                                    //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                    //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                                    if(data.status == "success"){
                                        var status ='New';
                                        var bb='<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_'+data.isertedID+'" href="workorder-details/'+data.isertedID+'"><i class="fa fa-pencil"></i> Edit</a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            '<a href="workorder-details/'+data.isertedID+'"><b>'+data.isertedID+'</b></a>',
                                            data.job_name,
                                            $('#wo_delivery_date').val(),
                                            $('#wo_delivery_time').val(),
                                            status,
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#job_name').val('');
                                        $('#wo_delivery_date').val(year+'-'+month+'-'+day);
                                        $('#wo_delivery_time').val(hours+':'+minutes);
                                        $('#notes').val(''); 
                                        $('#wo_requests').val(''); 
                                        $("#tdEmergencyData").dataTable().fnDestroy();
                                        $('#invLIST').empty(); 

                                        $('.alert-success').html('New Work Order Successfully Created.');   
                                          success2.show();
                                          App.scrollTo(success2, -200); 
                                    }
                                    
                                    
                                }
                            });
                            App.unblockUI(el);
                   
                }
            });
});

$('body').on('change','.filterInv',function(){   
    var jobID =$("#job_name").val();
    var inv_category =$('#inv_category').val();
    var inv_room =$('#inv_room').val();
    var inv_item_status =$('#inv_item_status').val();


    if(jobID!=''){
     $("#job_name").closest('.form-group').removeClass('has-error');   
     var el = jQuery(".portlet");
                App.blockUI(el);  
                      
      $.ajax({
            type : 'get',
            url : 'inventory-list',
            data : {
                id : jobID,
                inv_category : inv_category,
                inv_room : inv_room,
                inv_item_status : inv_item_status,
            },
            success : function(data) {
                    if(destroy == "yes")
                    {
                        $("#tdEmergencyData").dataTable().fnDestroy();
                        destroy = "no";
                    }
                    
                    if(data.length == 0) {
                        //$("#tdEmergencyData tbody").append("<tr class=\"odd\"><td class=\"dataTables_empty\" colspan=\"7\">No data available in table</td><tr>");
                        //return false;
                        App.unblockUI(el);
                    }
                    else
                    {
                        $("#invLIST").html(data);
                        App.unblockUI(el);

                    }                   
                        $('#tdEmergencyData').dataTable({
                            // set the initial value
                            "scrollY":        "250px",
                            "scrollCollapse": true,
                            "paging":         false
                        }); 
                        destroy = "yes";
                         jQuery('#tdEmergencyData_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
                         jQuery('#tdEmergencyData_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
                         jQuery('#tdEmergencyData_wrapper .dataTables_length select').select2(); // initialize select2 dropdown                 
            }
        });//End of Ajax.
    }
    else{
       $("#job_name").closest('.form-group').addClass('has-error'); 
    }



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

    //jQuery('#selectALL').change(function () {
    $('body').on('click','#selectALL',function(){       
        
        var set = '#tdEmergencyData .checkboxes';
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
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });



            jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_2_wrapper .dataTables_length select').select2(); // initialize select2 dropdown





        }

    };

}();

    var handleTimePickers = function () {

        if (jQuery().timepicker) {
            $('.timepicker-default').timepicker({
                autoclose: true
            });
            $('.timepicker-24').timepicker({
                autoclose: true,
                minuteStep: 15,
                showSeconds: false,
                showMeridian: false
            });
        }
    }
    