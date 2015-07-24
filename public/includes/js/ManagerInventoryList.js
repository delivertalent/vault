var destroy = "no";
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd='0'+dd
} 

if(mm<10) {
    mm='0'+mm
} 

today = yyyy+'-'+mm+'-'+dd; 

$(document).ready(function() {
    var el = jQuery("#putResults");
        App.blockUI(el);
    $('#btnAddUser').click(function()
    {

        //Parameter List:
        //job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
        //job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('.alert-danger').hide();
        $('#did').val('');
        $('#inv_description').val('');
        $('#inv_pono').val('');
        $('#inv_category').val('');
        $('#inv_received').val(today);
        $('#inv_delivered').val(''); //inv_description inv_pono inv_category inv_received inv_delivered inv_quantity
        $('#inv_quantity').val(1);    
        $('#inv_size').val('');    
        $('#inv_manufacture').val(''); 
        $('#inv_carrier').val('');  
        $('#inv_room').val('');  
        $('#inv_storage_price').val(''); //inv_size inv_manufacture inv_carrier inv_room inv_storage_price inv_mfg inv_item_status
        $('#inv_mfg').val('');  
        $('#inv_qb').val('');  
        $('#inv_item_status').val('');    
        $('#inv_delivery_status').val('');    
        $('#inv_warehouse').val(1); 
        $('#inv_bin').val('');  //inv_delivery_status inv_warehouse inv_bin inv_binltr inv_note
        $('#inv_binltr').val(''); 
        $('#inv_note').val('');    
        $('#inv_private_note').val('');    
        $('#show_image_name').val(''); 
        $('#image').empty(); 
        $('#modatTitle').html('Add New Inventory');

  var warehouseID = 1;
  if(warehouseID!=''){
        $.ajax({
            type : 'get',
            url : 'manager-get-warehousebin',
            data : {
                warehouseID : warehouseID,
            },
            success : function(data) {
                $('#inv_bin').html(data);
            }
        });
  }

        $('#jobform').show();
        App.scrollTo($('#inv_category'), -200);
       // $('#responsive').modal('show');
    });
 


 $('#putResults').load($("#linkLoad").val());



});




$("body").on('change', '#firm_id', function() { 
  var firm_id =  $('#firm_id').val();
  if(firm_id!=''){
        $.ajax({
            type : 'get',
            url : 'manager-get-joblist',
            data : {
                firm_id : firm_id,
            },
            success : function(data) {
                $('#job_id').html(data);
            }
        });
  }
});

$("body").on('change', '#inv_warehouse', function() { 
  var warehouseID =  $('#inv_warehouse').val();
  if(warehouseID!=''){
        $.ajax({
            type : 'get',
            url : 'manager-get-warehousebin',
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
            url : 'manager-get-binlrtlist',
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

$('#btnClear').bind("click", function(event) {

        $('.form-group').removeClass('has-error').removeClass('has-success');
        $('.alert-danger').hide();
        $('#did').val('');
        $('#inv_description').val('');
        $('#inv_pono').val('');
        $('#inv_category').val('');
        $('#inv_received').val(today);
        $('#inv_delivered').val(''); //inv_description inv_pono inv_category inv_received inv_delivered inv_quantity
        $('#inv_quantity').val(1);    
        $('#inv_size').val('');    
        $('#inv_manufacture').val(''); 
        $('#inv_carrier').val('');  
        $('#inv_room').val('');  
        $('#inv_storage_price').val(''); //inv_size inv_manufacture inv_carrier inv_room inv_storage_price inv_mfg inv_item_status
        $('#inv_mfg').val('');  
        $('#inv_qb').val('');  
        $('#inv_item_status').val('');    
        $('#inv_delivery_status').val('');    
        $('#inv_warehouse').val(1); 
        $('#inv_bin').val('');  //inv_delivery_status inv_warehouse inv_bin inv_binltr inv_note
        $('#inv_binltr').val(''); 
        $('#inv_note').val('');    
        $('#inv_private_note').val('');    
        $('#show_image_name').val(''); 
        $('#image').empty(); 
        $('#modatTitle').html('Add New Inventory');

  var warehouseID = 1;
  if(warehouseID!=''){
        $.ajax({
            type : 'get',
            url : 'get-warehousebin',
            data : {
                warehouseID : warehouseID,
            },
            success : function(data) {
                $('#inv_bin').html(data);
            }
        });
  }
$('#reset_image_Flug').val(0); 
$('#show_image_name').val(''); 
$('#image').empty();    
$('.alert-success').html('Inventory Form Cleared.'); 
var form2 = $('#form_sample_2');
var success2 = $('.alert-success', form2);  
  success2.show();
  App.scrollTo(success2, -200); 


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
                                url : 'manager-add-inventory',
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
                                            invImg='<a class="mix-preview fancybox-button" href="../without-flash-uploader/images/thumb/'+data.featureImage+'" title="Inventory Image:{{ $inventory->id }}" data-rel="fancybox-button"><img width="50" height="50" src="../without-flash-uploader/images/thumb/'+data.featureImage+'" alt=""></a>';
                                        }
                                        var delLInk='<a id="del_'+data.isertedID+'" class="btn btn-xs red btn-editable delInv" href="javaScript:void(0)" data-id="1" title="Delete"><i class="fa fa-times"></i></a>';
                                        $('#sample_2').dataTable().fnAddData( [
                                            '<a href="'+$('#editUrl').val()+'/'+data.isertedID+'"><b>'+data.isertedID+'</b></a>',
                                            invImg,
                                            data.jobs_name,
                                            $('#job_id').val(),
                                            $('#inv_pono').val(),
                                            data.itds_name,
                                            data.room_name,
                                            data.manuf_name,
                                            $('#inv_mfg').val(),
                                            data.invcat_name,
                                            status,
                                            '',
                                            $('#inv_note').val(),
                                            $('#inv_qb').val(),
                                            data.bins,
                                            data.binlrts,
                                            delLInk
                                        ] );

                                        $('.form-group').removeClass('has-error').removeClass('has-success');
                                        
                                        $('#qrContainer').empty();
                                        $('#qrContainer').append($(document.createElement("img")).attr({src:"../"+data.qrImage,id:"jcrop",height: 200, width: 200, style:"margin:5px;"})).show();
                                        $('#qrinvID').html(data.isertedID);
                                        $('#qrdesigner_FullName').html(data.customerFullName);
                                        $('#qrjobs_name').html(data.jobs_name);
                                        $('#qrDec').html(data.itds_name);
                                        $('#qrRoom').html(data.room_name);


/*                                      $('#inv_description').val('');
                                        $('#inv_pono').val('');
                                        $('#inv_category').val('');
                                        $('#inv_received').val(today);
                                        $('#inv_delivered').val(''); 
                                        $('#inv_quantity').val(1);    
                                        $('#inv_size').val('');    
                                        $('#inv_manufacture').val(''); 
                                        $('#inv_carrier').val('');  
                                        $('#inv_room').val('');  
                                        $('#inv_storage_price').val('');  
                                        $('#inv_mfg').val('');  
                                        $('#inv_item_status').val('');    
                                        $('#inv_delivery_status').val('');    
                                        $('#inv_warehouse').val(''); 
                                        $('#inv_bin').val(''); 
                                        $('#inv_binltr').val(''); 
                                        $('#inv_note').val(''); 
                                        $('#reset_image_Flug').val(0); 
                                        $('#show_image_name').val(''); 
                                        $('#image').empty(); */   
                                        $('.alert-success').html('New Inventory Successfully Created.');   
                                          success2.show();
                                          App.scrollTo(success2, -200); 
                                          $('#jobform').hide();
                                          $('#printContainer').show();   
                                    }
                                    if(data.status == "updated"){
                                     success2.show();
                                     App.scrollTo(success2, -200);   
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
                url : url+'admin-delete-job',
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
                url : url+'admin-get-job',
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

function dateFormat(date, format) {
    format = format.replace("DD", (date.getDate() < 10 ? '0' : '') + date.getDate());
    format = format.replace("MM", (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1));
    format = format.replace("YYYY", date.getFullYear());
    return format;
}




$('body').on('click','.delInv',function(){    
    var r=confirm("Do you want to Delete this Inventory?");
    if (r==true){
        $(this).closest("tr").hide();
        // var target_row = $(this).closest("tr").get(0); // this line did the trick
        // alert(target_row);
        // var aPos = oTable.fnGetPosition(target_row); 
        // oTable.fnDeleteRow(aPos); // Delete Datatable Row
        var elementID = $(this).attr("id");
        var splitID= elementID.split("_");
        var id=splitID[1];
        if(id!=''){
            //alert(id);
          $.ajax({
                type : 'delete',
                url : 'manager-delete-inventories',
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

$('#showForm').on("click", function(event) {
    $('#printContainer').hide();
    $('#jobform').show();
});

$('#showForm').on("click", function(event) {
    $('#printContainer').hide();
    $('#jobform').show();
});


$('#btnResetSearch').on("click", function(event) {
    $('#jobSearch').val('');
    $('#inv_categorySearch').val('');
    $('#inv_roomSearch').val('');
    $('#inv_item_statusSearch').val('');
    $('#inv_idPo').val('');
    $('#inv_sort').val('');
    $('#inv_sort_by').val('asc');
});


$('#btnSearch').on("click", function(event) {
    var jobSearch =$('#jobSearch').val();
    var inv_category =$('#inv_categorySearch').val();
    var inv_room =$('#inv_roomSearch').val();
    var inv_item_status =$('#inv_item_statusSearch').val();
    var inv_idPo =$('#inv_idPo').val();
    var inv_sort =$('#inv_sort').val();
    var inv_sort_by =$('#inv_sort_by').val();
    
        var el = jQuery("#putResults");
        App.blockUI(el);
        var linkUrl=$("#linkLoad").val()+"?page=1&jobSearch="+jobSearch+"&inv_category="+inv_category+"&inv_room="+inv_room+"&inv_item_status="+inv_item_status+"&inv_idPo="+inv_idPo+"&inv_sort="+inv_sort+"&inv_sort_by="+inv_sort_by ;
        $('#putResults').load(linkUrl);
        $("html, body").animate({ scrollTop: 0 }, "fast"); 
        App.unblockUI(el);

});


/*var TableManaged = function () {

    return {

        //main function to initiate the module
        init: function () {
            
            if (!jQuery().dataTable) {
                return;
            }
    var table = $('#sample_2').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 2 },
            { "visible": false, "targets": 3 }
        ],
        //"bSort": false,
        "bFilter": false,
        "order": [[ 3, 'desc' ], [0,'desc']],
        "displayLength": -1,
        "bPaginate": false,
        "bInfo" : false,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="12">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
            // begin second table
           oTable =  $('#sample_2').dataTable({
                "aLengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"] // change per page values here
                ],
                // set the initial value
                "order": [[ 0, "desc" ]],
                "iDisplayLength": 25,
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

}();*/