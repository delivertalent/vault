$(document).ready(function() {
   
    $('#btnEmail').click(function()
    {
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('#fromEmail').val('');
        $('#toEmail').val('');
        $('#eMessage').val('');
        $('.alert-success').hide(); 
        $('.alert-danger').hide(); 
        $('#modatTitle').html('Email');
        $('#responsiveEmail').modal('show');
    });
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

$('#btnSendEmail').bind("click", function(event) {
            
            var fromEmail = $('#fromEmail').val();
            var toEmail = $('#toEmail').val();
            var eMessage = $('#eMessage').val();

            
            $('#erAlert').hide();
            $('.form-group').removeClass('has-error');

            if(fromEmail =='' && !isValidEmailAddress( fromEmail )){
                $('.alert-danger').html('You have some form errors. Please check below2.');
                $('#erAlert').show();
                $('#fromEmail').focus();
                $('#fromEmail').parent().parent().addClass('has-error');
            }else if(toEmail =='' && !isValidEmailAddress( toEmail )){

                $('.alert-danger').html('You have some form errors. Please check below2.');
                $('#erAlert').show();
                $('#toEmail').focus();
                $('#toEmail').parent().parent().addClass('has-error');

            }else if(eMessage ==''){
                $('.alert-danger').html('You have some form errors. Please check below2.');
                $('#eMessage').show();
                $('#eMessage').focus();
                $('#eMessage').parent().addClass('has-error');                
            }
            else{
                  $.ajax({
                        type : 'POST',
                        url : '../../send-inventory-email',
                        //did customer_name customer_first_name  customer_last_name  customer_primary customer_address2 customer_city customer_state customer_phone customer_email
                        data : {
                            invId : $('#invId').val(),
                            fromEmail : $('#fromEmail').val(),
                            toEmail : $('#toEmail').val(),
                            eMessage : $('#eMessage').val()
                        },
                        dataType : 'json',
                        success : function(data) {
                            //alert(data.status)
                            // //did customer_name customer_first_name  customer_last_name  customer_primary customer_address2 customer_city customer_state customer_phone customer_email
                            $('#responsiveEmail').modal('hide');                                     
                        }
                    });                
            }

            return false;
            var form2 = $('#form_email_send');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);
            var intRegex = /^\d+$/;
            

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",
                rules: {
                    fromEmail: {
                        required: true
                    },
                    toEmail: {
                        required: true
                    },
                    eMessage: {
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
                                url : 'save-customers',
                                //did customer_name customer_first_name  customer_last_name  customer_primary customer_address2 customer_city customer_state customer_phone customer_email
                                data : {
                                    id : $('#did').val(),
                                    fromEmail : $('#fromEmail').val(),
                                    toEmail : $('#toEmail').val(),
                                    eMessage : $('#eMessage').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //alert(data.status)
                                    // //did customer_name customer_first_name  customer_last_name  customer_primary customer_address2 customer_city customer_state customer_phone customer_email
                                    if(data.status == "success"){
                                    }                                     
                                }
                            });
                           // App.unblockUI(el);
                   
                }
            });
});




$("body").on('change', '#inv_warehouse', function() { 
  var warehouseID =  $('#inv_warehouse').val();
  if(warehouseID!=''){
        $.ajax({
            type : 'get',
            url : '../get-warehousebin',
            data : {
                warehouseID : warehouseID,
            },
            success : function(data) {
                $('#inv_bin').html(data);
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
            url : '../inventory-jobid-update',
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

$("body").on('change', '#inv_bin', function() { 
  var binID =  $('#inv_bin').val();
  if(binID!=''){
        $.ajax({
            type : 'get',
            url : '../get-binlrtlist',
            data : {
                binID : binID,
            },
            success : function(data) {
                $('#inv_binltr').html(data);
            }
        });
  }
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
                url : '../admin-delete-images',
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
                                url : '../add-inventory',
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
                                        $('.alert-success').html('New Job Successfully Created.');   
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


$('body').on('click','.del',function(){    
    var r=confirm("Do you want to Delete this Job?");
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
                url : '../admin-delete-job',
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
                url : '../admin-get-job',
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
                    App.scrollTo($('#job_customer_id'), -200);   
                }
            });

    }
});

$('body').on('click','.createQR',function(){   
          $.ajax({
                type : 'post',
                url : '../create-qr',
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
