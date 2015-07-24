$(document).ready(function() {
    
});

$("body").on('change', '#inv_warehouse', function() { 
  var warehouseID =  $('#inv_warehouse').val();
  if(warehouseID!=''){
        $.ajax({
            type : 'get',
            url : '../manager-get-warehousebin',
            data : {
                warehouseID : warehouseID,
            },
            success : function(data) {
                $('#inv_bin').html(data);
            }
        });
  }
});

$("body").on('change', '#inv_bin', function() { 
  var binID =  $('#inv_bin').val();
  if(binID!=''){
        $.ajax({
            type : 'get',
            url : '../manager-get-binlrtlist',
            data : {
                binID : binID,
            },
            success : function(data) {
                $('#inv_binltr').html(data);
            }
        });
  }
});

$("body").on('click', '#changeInvJob', function() {
    if(parseInt($('#inv_woid').val())==0){
        $('#jobInputDiv').hide();
        $('#jobSelectDiv').show();
    }
    else{
        var form2 = $('#form_sample_2');
        var error2 = $('.alert-danger', form2);
        $('.alert-danger').html("Can't update Job as inventory is part of a work order!");
        error2.show();
        App.scrollTo(error2, -200);
        setTimeout(function(){error2.hide()}, 4000);
    }
});

$("body").on('click', '#updateInvJob', function() {
    var updateJobID = $("#jobSelect").val();
    var inventoryID = $("#did").val();
    $('#job_name').val($("#jobSelect option:selected").text());
    $('#jobInputDiv').show();
    $('#jobSelectDiv').hide();

        $.ajax({
            type : 'post',
            url : '../manager-inventory-jobid-update',
            data : {
                updateJobID : updateJobID,
                inventoryID : inventoryID,
            },
            success : function(data) {
                $('#job_id').val(updateJobID);
                $('#job_client_id').val(data.getFirmID);
            }
        });
    
});


$('#jobCancel').bind("click", function(event) {
     $('#jobform').hide();
     App.scrollTo($('#jobTop'), -200);
}); 

$('.removeImg').bind("click", function(event) {
    var elementID = $(this).attr("id");
    var splitID= elementID.split("_");
    var imgId=splitID[1]; 
    var invID = $("#did").val();  
    //alert(imgId);

        if(imgId!=''){
          $.ajax({
                type : 'delete',
                url : '../manager-delete-images',
                data : {
                    imgId : imgId,invID:invID,
                },
                dataType : 'json',
                success : function(data) {
                  $("#imgContainer_"+imgId).hide();  
                }
            });//End of Ajax.
        } //End of if.


})


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
                    inv_description: {
                        required: true
                    },
                    inv_category: {
                        required: true
                    },
                    inv_item_status: {
                        required: true
                    },
                    inv_delivery_status: {
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
                                url : '../manager-add-inventory',
                                //Parameter List:
                                //inv_description inv_pono inv_category inv_received inv_delivered inv_quantity
                                //inv_size inv_manufacture inv_carrier inv_room inv_storage_price inv_mfg inv_item_status
                               //inv_delivery_status inv_warehouse inv_bin inv_binltr inv_note
                                data : {
                                    id : $('#did').val(),
                                    inv_description : $('#inv_description').val(),
                                    inv_pono : $('#inv_pono').val(),
                                    inv_category : $('#inv_category').val(),
                                    inv_received : $('#inv_received').val(),

                                    inv_delivered : $('#inv_delivered').val(),
                                    inv_quantity : $('#inv_quantity').val(),
                                    inv_size : $('#inv_size').val(),
                                    inv_manufacture : $('#inv_manufacture').val(),
                                    inv_carrier : $('#inv_carrier').val(),

                                    inv_room : $('#inv_room').val(),
                                    inv_storage_price : $('#inv_storage_price').val(),
                                    inv_mfg : $('#inv_mfg').val(),
                                    inv_qb : $('#inv_qb').val(),
                                    inv_item_status : $('#inv_item_status').val(),
                                    inv_delivery_status : $('#inv_delivery_status').val(),

                                    inv_warehouse : $('#inv_warehouse').val(),
                                    inv_bin : $('#inv_bin').val(),
                                    inv_binltr : $('#inv_binltr').val(),
                                    inv_note : $('#inv_note').val(),
                                    inv_private_note : $('#inv_private_note').val(),
                                    show_image_name : $('#show_image_name').val(),
                                    firm_id : $('#firm_id').val(),
                                    job_id : $('#job_id').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //Parameter List:
                                    //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
                                    //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
                                    if(data.status == "success"){
                                        var status ='';
                                        var bb='<a class="btn btn-xs blue btn-editable" data-id="1" id="edit_'+data.isertedID+'" href="'+$('#editUrl').val()+'/'+data.isertedID+'"><i class="fa fa-pencil"></i>Edit</a>&nbsp;<a class="btn btn-xs red btn-removable del" data-id="1" id="del_'+data.isertedID+'" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>';
                                        if($('#inv_item_status').val() ==1)
                                            status = "Received in good condition";
                                        else if($('#inv_item_status').val() ==2)
                                            status = "Damaged";
                                        else if($('#inv_item_status').val() ==3)
                                            status = "Being repaired – in house";
                                        else if($('#inv_item_status').val() ==4)
                                            status = "Being repaired – out for repair";
                                        else if($('#inv_item_status').val() ==5)
                                            status = "Awaiting call tag / awaiting pickup";
                                        else if($('#inv_item_status').val() ==6)
                                            status = "Picked up";
                                        else{
                                            status = "";
                                        }
                                        var invImg='';
                                        if(data.featureImage!=''){
                                            invImg='<img width="50" height="50" src="../../../without-flash-uploader/images/thumb/'+data.featureImage+'" alt="">';
                                        }
                                        $('#sample_2').dataTable().fnAddData( [
                                            '<a href="'+$('#editUrl').val()+'/'+data.isertedID+'"><b>'+data.isertedID+'</b></a>',
                                            $('#inv_pono').val(),
                                            data.itds_name,
                                            data.room_name,
                                            data.manuf_name,
                                            $('#inv_mfg').val(),
                                            data.invcat_name,
                                            status,
                                            invImg,
                                            '',
                                            $('#inv_note').val(),
                                            bb
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        $('#inv_description').val('');
                                        $('#inv_pono').val('');
                                        $('#inv_category').val('');
                                        $('#inv_received').val('');
                                        $('#inv_delivered').val(''); 
                                        $('#inv_quantity').val('');    
                                        $('#inv_size').val('');    
                                        $('#inv_manufacture').val(''); 
                                        $('#inv_carrier').val('');  
                                        $('#inv_room').val('');  
                                        $('#inv_storage_price').val('');  
                                        $('#inv_mfg').val('');  
                                        $('#inv_qb').val('');  
                                        $('#inv_item_status').val('');    
                                        $('#inv_delivery_status').val('');    
                                        $('#inv_warehouse').val(''); 
                                        $('#inv_bin').val(''); 
                                        $('#inv_binltr').val(''); 
                                        $('#inv_note').val(''); 
                                        $('#inv_private_note').val(''); 
                                        $('#show_image_name').val(''); 
                                        $('#image').empty();    
                                        $('.alert-success').html('New Inventory Successfully Created.');   
                                          success2.show();
                                          App.scrollTo(success2, -200); 
                                          

                                    }
                                    if(data.status == "updated"){
                                     success2.show();
                                     App.scrollTo(success2, -200); 
                                     window.location.href=window.location.href; 
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


$('body').on('click','.createQR',function(){   
          $.ajax({
                type : 'post',
                url : '../manager-create-qr',
                data : {
                    id : $('#did').val(),
                    job_id : $('#job_id').val(),
                    job_name : $('#job_name').val(),
                    inv_bin : $('#inv_bin').val(),
                    inv_binltr : $('#inv_binltr').val(),
                    job_client_id : $('#job_client_id').val(),
                },
                dataType : 'json',
                success : function(data) {
                    $('#qrContainer').empty();
                    $('#qrContainer').append($(document.createElement("img")).attr({src:"../../"+data.status,id:"jcrop",height: 200, width: 200, style:"margin:5px;"})).show();      
                    $('#printBTN').show();
                }
            });
          return false;

});

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}


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
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"] // change per page values here
                ],
                // set the initial value
                "aaSorting": [[0, 'desc']],
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


            jQuery('#sample_2_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
            jQuery('#sample_2_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
            jQuery('#sample_2_wrapper .dataTables_length select').select2(); // initialize select2 dropdown





        }

    };

}();
