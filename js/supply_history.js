$(document).ready(function(){
	$(document).on("click", "#imbursed_to", arrangeTable);
	$(document).on("click", "#supply_name", arrangeTable);
	$(document).on("click", "#quantity_out", arrangeTable);
	$(document).on("click", "#date_imbursed", arrangeTable);
    $(document).on("click", "#name", arrangeTable);

});


function arrangeTable(){
	var id = this.id;

    $.ajax({
        url : 'ajax_urls/arrange_supply_history.php',
        type : 'post',
        data :  {'id': id},
        success : function(data){
            $('.content_area').html(data);
        }
    });
}