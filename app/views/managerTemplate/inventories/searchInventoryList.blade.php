<div class="pagination">
	{{ $inventories->links(); }}
</div>	
<table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
	<thead>
		<tr>
			<th>Id</th>
			<th>Image</th>
			<th>Job Name</th>
			<th>Job id</th>
			<th>PO#</th>
			<th>Description</th>
			<th>Room</th>
			<th>Manuf</th>
			<th>Mfg #</th>
			<th>Category </th>
			<th>Status</th>
			<th>QR Code</th>
			<th>Notes</th>
			<th>QB</th>
			<th>Bin</th>
			<th>Bin Ltr</th>
			<th>Del</th>
		</tr>
	</thead>
	<tbody>
		@if($inventories)
			@foreach($inventories as $inventory)
				<?php
		        if($inventory->inv_item_status ==1)
		            $status = "Received in good condition";
		        else if($inventory->inv_item_status ==2)
		            $status = "Damaged";
		        else if($inventory->inv_item_status ==3)
		            $status = "Being repaired – in house";
		        else if($inventory->inv_item_status ==4)
		            $status = "Being repaired – out for repair";
		        else if($inventory->inv_item_status ==5)
		            $status = "Awaiting call tag / awaiting pickup";
		        else if($inventory->inv_item_status ==6)
		            $status = "Picked up";
		        else{
		            $status = "";
		        }
		        ?>
			<tr class="odd gradeX">
				<td><a href="{{ URL::to('/manager/manager-inventory-details/'.$inventory->id)  }}"><b>{{ $inventory->id }}</b></a></td>
				<td> @if($inventory->inv_item_images!='')
					<a class="mix-preview fancybox-button" href="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" title="Inventory Image:{{ $inventory->id }}" data-rel="fancybox-button">
					<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">
					</a>
					@endif
				</td>
				<td>{{ wordwrap($inventory->job_name, 10, "<br />\n") }}</td>
				<td>{{ $inventory->Job_id }}</td>
				<td id="tInv_1_{{ $inventory->id }}" class="editTD">{{ $inventory->inv_pono }}</td>
				<td id="tInv_2_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->itds_name, 10, "<br />\n") }}</td>
				<td id="tInv_3_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->room_name, 10, "<br />\n") }}</td>
				<td id="tInv_4_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->manuf_name, 10, "<br />\n") }}</td>
				<td id="tInv_5_{{ $inventory->id }}" class="editTD">{{ $inventory->inv_mfg }}</td>
				<td id="tInv_6_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->invcat_name, 10, "<br />\n") }}</td>
				<td id="tInv_7_{{ $inventory->id }}" class="editTD">{{ wordwrap($status, 15, "<br />\n") }}</td>
				<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
				<td id="tInv_8_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->inv_note, 15, "<br />\n") }}</td>
				<td id="tInv_9_{{ $inventory->id }}" class="editTD">{{ wordwrap($inventory->inv_qb, 10, "<br />\n") }}</td>
				<td>{{ wordwrap($inventory->bin_name, 10, "<br />\n") }}</td>
				<td>{{ wordwrap($inventory->binlrt_name, 10, "<br />\n") }}</td>
				<td><a id="del_{{$inventory->id}}" class="btn btn-xs red btn-editable delInv" href="javaScript:void(0)" data-id="1" title="Delete"><i class="fa fa-times"></i></a></td>
			</tr>		
			@endforeach
		@endif

	</tbody>
</table>
<div class="pagination">
	{{ $inventories->links(); }}
</div>	

<script type="text/javascript">


$('ul.pagination li a').on('click', function (event) {
var el = jQuery("#putResults");
        App.blockUI(el);	
    event.preventDefault();
    if ( $(this).attr('href') != '#' ) {

    var jobSearch =$('#jobSearch').val();
    var inv_category =$('#inv_categorySearch').val();
    var inv_room =$('#inv_roomSearch').val();
    var inv_item_status =$('#inv_item_statusSearch').val();

    	var linkUrl=$(this).attr('href')+"&jobSearch="+jobSearch+"&inv_category="+inv_category+"&inv_room="+inv_room+"&inv_item_status="+inv_item_status;
        $('#putResults').load(linkUrl);
        $("html, body").animate({ scrollTop: 0 }, "fast");
    }
});	

 $('#sample_2').DataTable({
                                "columnDefs": [
                                    { "visible": false, "targets": 2 },
                                    { "visible": false, "targets": 3 }
                                ],
                                "bSort": false,
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
                                                '<tr class="group"><td colspan="16">'+group+'</td></tr>'
                                            );
                         
                                            last = group;
                                        }
                                    } );
                                }
                            } ); 

                        destroy = "yes";
                         jQuery('#sample_2 .dataTables_filter input').addClass("form-control input-small"); // modify table search input
                         jQuery('#sample_2 .dataTables_length select').addClass("form-control input-xsmall"); // modify table per page dropdown
                         jQuery('#sample_2 .dataTables_length select').select2(); // initialize select2 dropdown   


</script>