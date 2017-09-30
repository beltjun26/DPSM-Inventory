$(document).ready(function(){
	$(document).on("click", "#supply_name", arrangeTable);
	$(document).on("click", "#brand", arrangeTable);
	$(document).on("click", "#quantity", arrangeTable);
	$(document).on("click", "#unit", arrangeTable);
	$(document).on("click", "#date_added", arrangeTable);
	$(document).on("click", "#date_modified", arrangeTable);
    $(document).on("click", "#name", arrangeTable);

});


function arrangeTable(){
	var id = this.id;

    $.ajax({
        url : 'ajax_urls/arrange_supply_inventory.php',
        type : 'post',
        data :  {'id': id},
        success : function(data){
            $('.content_area').html(data);
        }
    });
}