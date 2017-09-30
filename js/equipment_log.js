$(document).ready(function(){
	$(document).on("click", "#borrower_name", arrangeTable);
	$(document).on("click", "#borrower_id", arrangeTable);
	$(document).on("click", "#item_name", arrangeTable);
	$(document).on("click", "#borrow_time", arrangeTable);
	$(document).on("click", "#due_time", arrangeTable);
	$(document).on("click", "#name", arrangeTable);
});


function arrangeTable(){
	var id = this.id;

    $.ajax({
        url : 'ajax_urls/arrange_table.php',
        type : 'post',
        data :  {'id': id},
        success : function(data){
            $('.content_area').html(data);
        }
    });
}