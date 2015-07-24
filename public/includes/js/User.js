


$(document).ready(function() {
	
	
	$('#dateofbirth').datepicker({
		'format': 'dd/mm/yyyy'
		//'endDate': dateFormat(new Date(), "DD/MM/YYYY")
	}).on('changeDate', function(e){
			$('#dateofbirth').datepicker('hide');
	});
	
	// User Table Grid
             $('#dtUser').dataTable({
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

 jQuery('#dtUser_wrapper .dataTables_filter input').addClass("form-control input-small"); // modify table search input
 jQuery('#dtUser_wrapper .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
 jQuery('#dtUser_wrapper .dataTables_length select').select2(); // initialize select2 dropdown
	// ------ end ------------
	
	// Add User ---
	$('#btnAddUser').click(function()
	{
		formReset();
		$('#mdlUser').modal('show');
	});
	// Save User ---
	$('#btnSave').click(function()
	{
		saveUser();
	});
	
});


function saveUser()
{

	if($('#userid').val() == ""){
		bootbox.alert("User Id Require");
		return false;
	}
	if($('#username').val() == ""){
		bootbox.alert("User Name Require");
		return false;
	}
	if($('#usertype').val() == ""){
		bootbox.alert("Select User Type");
		return false;
	}
	if($('#username').val() == ""){
		bootbox.alert("User Name Require");
		return false;
	}
	if($('#pass1').val() == ""){
		bootbox.alert("Password Require");
		return false;
	}
	if($('#pass1').val() != $('#pass2').val()){
		bootbox.alert("Password does not match");
		return false;
	}
	
	$.ajax({
		type : 'POST',
		url : 'saveUsers',
		data : {
			id : $('#id').val(),
			userid : $('#userid').val(),
			username : $('#username').val(),
			email : $('#email').val(),
			gender : $('#gender').val(),
			cellnumber : $('#cellnumber').val(),
			usertype : $('#usertype').val(),
			designation : $('#designation').val(),
			pass1 : $('#pass1').val()
		},
		dataType : 'json',
		success : function(data) {
			//formReset();
			$('#mdlUser').modal('hide');	
			bootbox.alert(data, function() {
				window.location.href = "getUser";
			});
			
			
		}
	});

}


function deleteUser(id)
{
	bootbox.confirm("Are you sure?", function(result) {
			if(result) {
				$.ajax({
					type : 'DELETE',
					url : 'deleteUsers/'+id,
					data : {},
					dataType : 'json',
					success : function(data) {
						formReset();
						$('#mdlUser').modal('hide');	
						bootbox.alert(data, function() {
							window.location.href = "getUser";
						});
					}
				});

			}

		});
}


function formReset()
{
	//$('#userid').prop('disabled', false);
	//$('#pass1').prop('disabled', false);
	//$('#pass2').prop('disabled', false);
	
	$('#id').val("");
	$('#userid').val("");
	$('#username').val("");
	$('#email').val("");
	$('#usertype').val("");
	$('#pass1').val("");
	$('#pass2').val("");
	//$('#gender.gender1').prop('checked', true);
	$('#gender').val("");
	$('#cellnumber').val("");
	$('#designation').val("");
}

function dateFormat(date, format) {
	format = format.replace("DD", (date.getDate() < 10 ? '0' : '') + date.getDate());
	format = format.replace("MM", (date.getMonth() < 9 ? '0' : '') + (date.getMonth() + 1));
	format = format.replace("YYYY", date.getFullYear());
	return format;
}