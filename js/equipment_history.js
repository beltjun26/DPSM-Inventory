$(document).ready(function(){
	$(document).on("click", "#borrower_name", arrangeTable);
	$(document).on("click", "#borrower_id", arrangeTable);
	$(document).on("click", "#item_name", arrangeTable);
	$(document).on("click", "#borrow_time", arrangeTable);
	$(document).on("click", "#time_returned", arrangeTable);
	$(document).on("click", "#status", arrangeTable);
    $(document).on("click", "#name", arrangeTable);

});


function arrangeTable(){
	var id = this.id;

    $.ajax({
        url : 'ajax_urls/arrange_equipment_history.php',
        type : 'post',
        data :  {'id': id},
        success : function(data){
            $('.content_area').html(data);
        }
    });
}