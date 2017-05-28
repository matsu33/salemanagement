/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var formInserCustomer = "#frm_customer_insert";

var customerToAdd = {};

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){	
	//stop submit form
	$("#frm_customer_insert").submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});
	
	/*************************
	 * EVENT*****************
	 ************************/
	//click btn_add_customer
	$(".btn_add_customer").click(clickButtonAddCustomer);
	
});

/**************************************************************
 * START ADD ORDER LIST
 *************************************************************/
/**
 * click add order in modal 
 */
function clickButtonAddCustomer(){
	console.log('clickButtonAddCustomer');
	//validate form
	Omss.validate($(formInserCustomer), {
		input_customer_name : {
				required: true,
				maxlength : 200,
			}
		}, finishValidateFormAddCustomer);
	//
}

/**
 * validate ok form insert order 
 */
function finishValidateFormAddCustomer(){
	//check size exist
	var customer_name = $(formInserCustomer).find(".input_customer_name").val();
	var dataPost = { 'customer_name' : customer_name};
	Omss.post('/customers/addCustomer', dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			Omss.showSuccess(data.message);
			//fill publisher
			fillCustomerToSelectElement(".select_customer");
		} else {
			Omss.showError(data.message);
		}
	});
}
