$('body').on('click','#forgetBtn',function(){   
   $('.alert-success').hide(); 
   $('.alert-danger').hide(); 
   $('#forgetBtn').hide(); 
   $('#spinner').show(); 

    var elementEmail = $("#forgetEmail").val();

    if(elementEmail!=''){
          $.ajax({
                type : 'post',
                url : 'reset-pass',
                data : {
                    elementEmail : elementEmail,
                },
                dataType : 'json',
                success : function(data) {
                    //alert(JSON.stringify(data[0]["zonename"]));
                    /*did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email*/
                 
                     if(data.status == "notMatch"){
                        $('.alert-danger').html("Email does not match"); 
                        $('.alert-danger').show();
                     }  
                     else if (data.status == "success"){
                        $('.alert-success').html("Check youe email for further instruction"); 
                        $('.alert-success').show();
                        $("#forgetEmail").val('');
                     }  
                }
            });

    }
    $('#spinner').hide(); 
    $('#forgetBtn').show(); 
   
    return false;
});