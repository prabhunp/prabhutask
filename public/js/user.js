(function ($) {

	//alert('asdasd');
    /*$(window).ready(function(){
	
	});*/
	$(function () {
        $('[data-toggle="tooltip"]').tooltip();
        initUsersTable();
    });

 
	
	

    function initUsersTable() {
		var parm = '';
		var vendor_value ='';

		var userEditUrl 	=	$('#custom_hidden_edit_url').val();
		var userDeleteUrl 	=	$('#custom_hidden_delete_url').val();

		
				
	   $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: User.userUrl + '/ajax/userdetails'+parm,
            ordering: true,
            columns: [
                {data: "first_name", name: "first_name"},
				{data: "last_name", name: "last_name"},
				{data: "name", name: "name"},
				{data: "debut", name: "debut"},
				
				{"defaultContent": "null", "render": function(data,type,row,meta) { 
					return '<span class="tablespan"><a href="'+userEditUrl+'?userid='+row.id+'"><i style="color:#FF0000;" class="fa fa-edit"></i></a><a href="'+userDeleteUrl+'?userid='+row.id+'"  onclick="return confirm(\'Are you sure to delete?\');"><i style="color:#FF0000;" class="fa fa-trash"></i></a></span>';
	
            	}}				

            ],
            "createdRow": function (row, data) {
				  $(row).addClass('user-id-' + data.id);
            },
        });
    }
	
	
	
})(jQuery);


function newone(){
		$("#id").val('');	
		$("#name").val('');	
	}
	
function edit(id,name){
		$("#name").val(name);
		$("#id").val(id);
		$("#myModal").modal("show");
}	










