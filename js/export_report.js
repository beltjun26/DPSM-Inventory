$(document).ready(function(){
	$(document).on("click", "#export_report", exportReport);
});


function exportReport(e){
	e.preventDefault();

    //getting data from our table
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('inventory_table');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');

    var a = document.createElement('a');
    var date = new Date();
    var date_str = date.getDate() + "_" + date.getFullYear() + "_" + date.getMonth();

    a.href = data_type + ', ' + table_html;
    a.download = 'supplies_inventory' + date_str + '.xls';
    a.click();
}