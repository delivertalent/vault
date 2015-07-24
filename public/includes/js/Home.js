$(document).ready(function() {

   
    $('#inlineCheckbox').click(function()
    {
        if (!$('#acceptCheckbox').is(':checked')) {
           $('#ckLavel').css('color', 'red');
        }
        else{
           $('#termContainer').hide();
           $('#endUserAgreement').show();
           App.scrollTo($('#endUserAgreement'), -200);    
        }
    });	

    $('#inlineCheckbox2').click(function()
    {
        if (!$('#acceptCheckbox2').is(':checked')) {
           $('#ckLavel2').css('color', 'red');
        }
        else{
           $('#endUserAgreement').hide();
           $('#forgetForm').show();
           App.scrollTo($('#forgetForm'), -200);    
        }
    }); 
	
});

$('.filterInv').on("change", function(event) {
    var jobSearch =$('#jobSearch').val();
    var inv_category =$('#inv_category').val();
    var inv_room =$('#inv_room').val();
    var inv_item_status =$('#inv_item_status').val();
    

     $('.jobCalss').show();
        var el = jQuery("#putResults");
        App.blockUI(el);
           $.ajax({
                type : 'get',
                url : 'search-inventory',
                data : {
                    jobSearch : jobSearch,
                    inv_category : inv_category,
                    inv_room : inv_room,
                    inv_item_status : inv_item_status,
                },
                success : function(data) {
                    $("#putResults").html(data);
                }
            });//End of Ajax.

           App.unblockUI(el);

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
                    userPassword: {
                        minlength: 2,
                        required: true
                    },
                    retype_password: {
                        minlength: 2,
                        required: true,
                        equalTo: "#userPassword"
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
                    var el = jQuery("#homeBody");
                    App.blockUI(el);
                          $.ajax({
                                type : 'POST',
                                url : 'update-status',
                                //did firm_name first_name  last_name  primary_address primary_address_two city state phone email
                                data : {
                                    userPassword : $('#userPassword').val(),
                                    retype_password : $('#retype_password').val()
                                },
                                dataType : 'json',
                                success : function(data) {
                                    App.unblockUI(el);
                                    //alert(data.status)
                                    // //did firm_name first_name  last_name  primary_address primary_address_two city state phone email
                                    if(data.status == "updated"){
                                        $('.alert-success').html('Password is Successfully Updated.');   
                                        $('#forgetForm').hide();
                                        $("#userDasjboard").show();

                                          /*success2.show();
                                          App.scrollTo(success2, -200);*/ 
                                    }
                                    else{
                                         $('.alert-danger').html('System Can Not Updated Password. Please Try Again!!!');   
                                          error2.show();
                                          App.scrollTo(error2, -200);                                        
                                    }
 
                                }
                            });
                           // App.unblockUI(el);
                   
                }
            });
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
