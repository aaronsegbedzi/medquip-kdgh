$(document).ready(function(){
	$('#check_all').on('ifUnchecked ifChecked',function (event) { 
		if (event.type == "ifChecked") {   
	    	$('input:checkbox').prop('checked',true).iCheck('update');
		}else{
			$('input:checkbox').prop('checked',false).iCheck('update');
		}
	});
    $('#data_table').DataTable();
});
