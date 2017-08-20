/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/


/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	
	var nua = navigator.userAgent
	  var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
	  if (isAndroid) {
		$('select.form-control').removeClass('form-control').css('width', '100%')
	  }
	  

	$(".inputImgProduct").change(function(){
		changeImage(this);
	});
	
	focusFirstInput();
	
	marginHeader();

	$(window).resize(function() {
		marginHeader();
	});
	
	$("#btn_logout").click(function(){
		Omss.post('/auth/logout').done(function(data) {
		if (data.status == 1) {
			window.location = "/";
		} else {
			Omss.showError('Lỗi đăng xuất');
		}
	});
	});
	
});


/**
 * resize after user resize window
 */
function marginHeader() {
	// get header height
	var header_h = getHeight($('.navbar'));
	
	$('.header_top').css("margin-top", header_h + "px");
}

/**
 * get height of element in html
 * 
 * @param element
 * @returns height of element
 */
function getHeight(element) {
	var totalHeight = element.height();
	totalHeight += parseInt(element.css("padding-top"), 10)
			+ parseInt(element.css("padding-bottom"), 10); // Total Padding
	// Height
	totalHeight += parseInt(element.css("margin-top"), 10)
			+ parseInt(element.css("margin-bottom"), 10); // Total Margin
	// Height
	return totalHeight;
}
function focusFirstInput(){
	$( ".focus_control" ).focus();
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgProductPreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function changeImage(input) {
	console.log('changeImage');
    $ = jQuery;
    // array with acceptable file types
    var accept = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
	
    // if we accept the first selected file type
    if (accept.indexOf(input.files[0].type) > -1) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
			var imageElement = $(input).parent().parent().parent().find(".imgProductPreview");
            reader.onload = function (e) {
				// console.log('e.target.result : ' + e.target.result);
                $(imageElement).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
			
			//$("#imgProductPreview").attr("src", $("#imgProductPreview").attr("src")+"?timestamp=" + new Date().getTime());
			//setTimeOut(refreshImage,1000);
        }
    } else {
        $(imageElement).replaceWith($(imageElement).clone(true));
    }
}

function refreshImage(){
	var img=$('#imgProductPreview');
    var src=img.attr('src');
    var i=src.indexOf('?dummy=');
    src=i!=-1?src.substring(0,i):src;

    d = new Date();
    img.attr('src', src+'?dummy='+d.getTime() );
}

/**
 * custom function to format error message from ajax
 */
function formatErrorMessage(jqXHR, exception) {

	if (jqXHR.status === 0) {
		return ('Not connected.\nPlease verify your network connection.');
	} else if (jqXHR.status == 404) {
		return ('The requested page not found. [404]');
	} else if (jqXHR.status == 500) {
		return ('Internal Server Error [500].');
	} else if (exception === 'parsererror') {
		return ('Requested JSON parse failed.');
	} else if (exception === 'timeout') {
		return ('Time out error.');
	} else if (exception === 'abort') {
		return ('Ajax request aborted.');
	} else {
		return ('Uncaught Error.\n' + jqXHR.responseText);
	}
}


/*********************************************************************
 * COMMON PRODUCT FUNCTION *******************************************
 *********************************************************************/
/**
 * fill combobox unit
 */
function fillUnitToSelectElement(element){
	console.log("fillUnitToSelectElement");
	$(element).html('');
	Omss.post('/units/getAll').done(function(data) {
		if (data.status == 1) {
			$.each( data['data'], function(key, item){
				var no, category_name, option;
				no = item['id'];
				category_name = item['unit_name'];
				option = '<option value="'+no+'">'+category_name+'</option>';
				$(element).append(option);
			});
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * fill combobox customer
 */
function fillCustomerToSelectElement(element){
	console.log("fillCustomerToSelectElement");
	$(element).html('');
	Omss.post('/customers/getAll').done(function(data) {
		if (data.status == 1) {
			$.each( data['data'], function(key, item){
				var no, category_name, option;
				no = item['id'];
				category_name = item['customer_name'];
				option = '<option value="'+no+'">'+category_name+'</option>';
				$(element).append(option);
			});
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * fill combobox material
 */
function fillMaterialToSelectElement(element){
	console.log("fillMaterialToSelectElement");
	$(element).html('');
	Omss.post('/materials/getAll').done(function(data) {
		console.log(data);
		if (data.status == 1) {
			$.each( data['data'], function(key, item){
				var no, category_name, option;
				no = item['id'];
				category_name = item['material_name'];
				option = '<option value="'+no+'">'+category_name+'</option>';
				$(element).append(option);
			});
            var selectedMaterial = $('.selected-material').val();
            if(selectedMaterial){
                $('.select_material').val(selectedMaterial);
                $(".js-checkbox-select-search-material").prop("checked", true);
            }else{
                $(".js-checkbox-select-search-material").prop("checked", false);
            }
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * fill combobox category
 */
function fillCategoryToSelectElement(element){
	console.log("fillCategoryToSelectElement");
	$(element).html('');
	Omss.post('/categories/getAll').done(function(data) {
		console.log(data);
		if (data.status == 1) {
			$.each( data['data'], function(key, item){
				var no, category_name, option;
				no = item['id'];
				category_name = item['category_name'];
				option = '<option value="'+no+'">'+category_name+'</option>';
				$(element).append(option);
			});
			var selectedCategory = $('.selected-category').val();
			if(selectedCategory){
				$('.select_category').val(selectedCategory);
                $(".js-checkbox-select-search-category").prop("checked", true);
            }else{
                $(".js-checkbox-select-search-category").prop("checked", false);
            }
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * fill combobox publisher
 */
function fillPublisherToSelectElement(element){
	console.log("fillPublisherToSelectElement");
	$(element).html('');
	Omss.post('/nhacungcap/getAll').done(function(data) {
		console.log(data);
		if (data.status == 1) {
			$.each( data['data'], function(key, item){
				var no, category_name, option;
				no = item['id'];
				publisher_name = item['publisher_name'];
				option = '<option value="'+no+'">'+publisher_name+'</option>';
				$(element).append(option);
			});
            var selectedPublisher = $('.selected-publisher').val();
            if(selectedPublisher){
                $('.select_publisher').val(selectedPublisher);
                $(".js-checkbox-select-search-publisher").prop("checked", true);
            }else{
                $(".js-checkbox-select-search-publisher").prop("checked", false);
			}
		} else {
			Omss.showError(data.message);
		}
	});
}
/**
 * validate size product
 * 
 * @param: form element
 * @callback: function callback with size_id 
 * 	Ex: validateProductSize($('#frm_product_add'), addProductWithSize);
 * 		with 	frm_product_add: form element to validate
 * 				addProductWithSize is function addProductWithSize(size_id)
 */
function validateProductSize(form, callback){
	console.log("validateProductSize");
	Omss.validate($(form), {
			input_diameter : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_length : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_product_range : {
				number: true,
				maxlength : 10,
			}
		}, function(){validateProductSizeExist(form, callback);});
}

/**
 * init size attribute then validate
 */
function validateProductSizeExist(form, callback){
	console.log("validateProductSizeExist");
	var input_diameter = $(form).find(".input_diameter").autoNumeric('get');
	var input_length = $(form).find(".input_length").autoNumeric('get');
	var input_product_range = $(form).find(".input_product_range").autoNumeric('get');
	
	checkSizeExist(input_diameter, input_length, input_product_range, callback);
}

/**
 * get size id in database if exist
 * @param: diameter, length, product_range are attribute of size
 * @param: callback is function after get size_id
 */
function checkSizeExist(diameter, length, product_range, callback){
	console.log("checkSizeExist");
	console.log("diameter : " + diameter + " --- length : " + length + " --- product_range : " + product_range);
	var data = {
		'diameter': diameter,
		'length': length,
		'product_range': product_range
	};
	Omss.post('/sizes/checkExist', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			var size_id = data.size_id;
			
			//check size is exist or not
			if(size_id){
				callback(size_id);
			}else{
				Omss.showError('Quy cách không tồn tại');
			}
		} else {
			Omss.showError(data.message);
		}
	});
}


/**
 * upload image
 * @param: form element
 * @param: image element
 * @return: image file name
 */
function uploadProductImage(form, imageElement, callback){
	var formData = new FormData();
	var file = $(form).find(imageElement).get(0);
	var filename = '';
	if (file.files.length > 0)
	{
		formData.append('image1', file.files[0]);
		console.log('hinhanhhanghoa/upload');
		//upload image
		Omss.upload('hinhanhhanghoa/upload', formData).done(function(data) {
			console.log(data);
			if (data) {
				result = data['result'];
				if(result)
				{
					filename = data['filename'];
					console.log('filename : ' + filename);
					
					callback(filename);
				}
			}
		});
		
	}else{
		callback(filename);
	}
}


/**
 * get product group id from group
 * @param: group is variable array product object 
 * 	Ex: { product_id : {product object } }
 * @param: product is variable to add or edit
 * @param: callback is function after get product group id
 *  Ex: getProductGroupId(productGroup, productToAdd, addProductImage);
 */
function getProductGroupId(group, product, callback){
	console.log("getProductGroupId");
	
	if(Object.keys(group).length > 0){
		var arr = [];
		$.each( group, function(key, item){
			arr.push([item.id,item.quanlity]);
		});
		
		var data = { 'data' : arr};
		
		Omss.post('/hinhanhhanghoa/getProductGroupId', data).done(function(data) {
			console.log(data);
			if (data.status == 1) {
				product.product_group = data.data;
				// checkProductExistInDatabase(product, callback);
				callback();
			} else {
				Omss.showError(data.message);
			}
		});
	}else{
		product.product_group = 0;
		// checkProductExistInDatabase(product, callback);
		callback();
	}
}

/**
 * check product is exist in database then callback
 */
function checkProductExistInDatabase(product, callback){
	console.log("checkProductExistInDatabase");
	Omss.post('/hinhanhhanghoa/checkExist', product).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			console.log(product);
			Omss.showError(data.message);
		} else {
			callback();
		}
	});
}


/**
 * check product exist in new group
 * @param: form contain product attribute
 * @param: group is list new products
 */
function checkProductExistInGroup(form, group){
	console.log('checkProductExistInGroup');
	var isExist = false;
	if(Object.keys(group).length <= 0){
		return isExist;
	}
	
	var diameter = $(form).find(".input_diameter").val();
	var length = $(form).find(".input_length").val();
	var product_range = $(form).find(".input_product_range").val();
	var unit_id =  $(form).find(".select_unit").val(),
	category_id = $(form).find(".select_category").val(),
	material_id = $(form).find(".select_material").val();
	
	console.log(diameter + "-" + length + "-"+ product_range + "-"+ unit_id + "-"+ category_id + "-"+ material_id);
	
	//check exist product in group
	$.each( group, function(key, item){
		var diameter2 = item.diameter;
		var length2 = item.length;
		var product_range2 = item.product_range;
		var unit_id2 =  item.unit_id,
		category_id2 = item.category_id,
		material_id2 = item.material_id;
		
		console.log(diameter2 + "-" + length2 + "-"+ product_range2 + "-"+ unit_id2 + "-"+ category_id2 + "-"+ material_id2);
		
		if(diameter == diameter2 && length == length2 && product_range == product_range2
			&& unit_id == unit_id2 && category_id == category_id2 && material_id == material_id2){
				console.log('====Exist in group====');
				
				isExist = true;
				return false;
			}
	});
	
	return isExist;
}

/**
 * get product data from attribute
 */
function getProductInfoWithProductAttribute(productAtt, callback){
	console.log('getProductInfoWithProductAttribute : ');
	console.log(productAtt);
	Omss.post('/hinhanhhanghoa/getInfo', productAtt).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			console.log("status true -> data: ");
			console.log(data.data);
			callback(data.data);
		} else {
			Omss.showError(data.message);
		}
	});
}


/**
 * validate product form is added to group
 */
function validateFormAddProductGroup(form, callback){
	console.log("validateFormAddProductGroup");
	Omss.validate($(form), {
			input_group_quanlity: {
				required: true,
				number: true,
				maxlength : 10,
			},	
			input_diameter : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_length : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_product_range : {
				number: true,
				maxlength : 10,
			}
		}, callback );
}

/**
 * post to url
 * @param path: action
 * @param params: params
 * @param method: post|get
 * */
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default, if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", JSON.stringify(params[key]));

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

/**
 * get image html tag with image name
 * @param {Object} product_image
 */
function getProductImageHtmlWithName(product_image){
	return '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+product_image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />';// <th>Hình ảnh</th>
}

function getFromToDate(type, date) {
    var dateCondition = {};
    switch (type) {
        case "1":
            var dsplit = date.split("/");
            dateCondition.date_from = dsplit[2] + '-' + dsplit[1] + '-' + dsplit[0] + ' 00:00:00';
            dateCondition.date_to = dsplit[2] + '-' + dsplit[1] + '-' + dsplit[0] + ' 59:59:59';
            break;
        case "2":
            var dsplit = date.split("/");
            dateCondition.date_from = dsplit[1] + '-' + dsplit[0] + '-01 00:00:00';
            dateCondition.date_to = dsplit[1] + '-' + dsplit[0] + '-31 59:59:59';
            break;
        case "3":
            dateCondition.date_from = date + '-01-01 00:00:00';
            dateCondition.date_to = date + '-12-31 59:59:59';
            break;
    }
    return dateCondition;
}

function getDateStringWithoutTime(dateString){
	var createFullDate = new Date(dateString);
	if(dateString == ""){
		return "";
	}
	var createdDate = createFullDate.getDate();
	var createdMonth = createFullDate.getMonth();
	var createdYear = createFullDate.getFullYear();
	
	return createdYear + "/" + (createdMonth + 1) + "/" + createdDate;
}

/************************************************************
 * view list order detail
 * @param orderId
 ************************************************************/
function viewOrderDetail(orderId){
	var dataPost = {
            'order_id': orderId
        };
	Omss.post('/customerdebt/getOrderDetail',dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			bindOrderDetailWithData(data);
			$("#order_detail_modal").modal("show");
		} else {
			Omss.showError(data.message);
		}
	});
}
