$(document).ready(function(){
	$(document).on("input", "#supply_name", newSupply);
	$(document).on("click", ".supply-row", showSupplyDetails);
	$(document).on("mouseover", ".close-prompt", getId);
	$(document).on("click", ".cancel-check-out", removeFromSupplyLog);
	$(document).on("click", "#check_out_all", checkOutSupplies);

	window.addEventListener("beforeunload", confirmation);
});


function confirmation(e) {
	  var confirmationMessage = "\o/";

	  (e || window.event).returnValue = confirmationMessage;     //Gecko + IE
	  return confirmation;                                //Webkit, Safari, Chrome etc.
}


var choice;


function checkOutSupplies(){
	window.removeEventListener("beforeunload", confirmation);
	
	$.ajax({
		url: "ajax_urls/check_out_supplies.php",
		type: "post",
		data: $(this).serialize(),
		success: function(data){
			window.location = '../php/supply_history.php';
		}
	});
}

function removeFromSupplyLog(){
	var passed_input = $(this).attr('data-pg');
	var supply_id = passed_input.split(';')[1];
	var id = passed_input.split(';')[0];
	var quantity = passed_input.split(';')[2];

	var old_quan = document.getElementsByClassName(supply_id)[0].lastChild.previousSibling.firstChild.nodeValue;
	var new_quan = parseInt(old_quan) + parseInt(quantity);

	document.getElementsByClassName(supply_id)[0].lastChild.previousSibling.firstChild.nodeValue = new_quan + " ";
	console.log(old_quan);

	$.ajax({
		url: "ajax_urls/remove_from_supply_log.php",
		type: "post",
		data: {'id': id},
		success: function(data){
			$('.list_supplies').html(data);
		}
	});
}

function getId(){
	id = this.className.split(" ")[4];

	choice = document.getElementsByClassName(id);
	choice[4].addEventListener("click", function(){
		choice[1].style.display = "none";
	});
}

function showSupplyDetails(){
	var id = $(this).attr('data-pg');
	choice = document.getElementsByClassName(id);

	choice[1].style.display = "table-row";
	choice[2].max = parseInt(choice[0].lastChild.previousSibling.firstChild.nodeValue);
	choice[3].addEventListener("click", saveDetail);
}

function saveDetail(){
	if(choice[2].max< choice[2].value){
		alert("Quantity should not be greater than the maximum alotted value.");
	}
	else{
		id = this.className.split(" ")[2];
		reciever = document.getElementById("reciever").value;

		if (reciever == ""){
			alert("imburse to field cannot be left blank!");
		}

		else{
			choice[1].style.display = "none";
			quantity = choice[2].value;

			var prev_value = choice[0].lastChild.previousSibling.firstChild;
			prev_value.nodeValue = (parseInt(prev_value.nodeValue) - quantity)+ " ";

			if(quantity>0){
				document.getElementById("check_out_all").style.display = "block";
				$.ajax({
			        url : 'ajax_urls/save_supply_details.php',
			        type : 'post',
			        data :  {'id': id, 'quantity':quantity, 'reciever':reciever},
			        success : function(data){
			            $('.list_supplies').html(data);
			        }
		   		});
			}
		}
	}
}


function newSupply(){
	$.ajax({
		url: "ajax_urls/show_supply.php",
		type: "post",
		data: $(this).serialize(),
		success: function(data){
			$("#supplies").html(data);
		}
	});
}

