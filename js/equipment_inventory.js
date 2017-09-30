$(document).ready(function(){
	$(document).on("click", "#item_name", arrangeTable);
	$(document).on("click", "#property_number", arrangeTable);
	$(document).on("click", "#date_added", arrangeTable);
	$(document).on("click", "#name", arrangeTable);
	$(document).on("click", "#equipment_status", arrangeTable);
});


function arrangeTable(){
	var id = this.id;

    $.ajax({
        url : 'ajax_urls/arrange_equipment_inventory.php',
        type : 'post',
        data :  {'id': id},
        success : function(data){
            $('.content_area').html(data);
        }
    });
}