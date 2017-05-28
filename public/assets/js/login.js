function Login(){};

var login = new Login();

/*
 * Check whether user already login
 */
Login.prototype.checkLogin = function() {
	return Omss.post('/auth/check');
};

/*
 * Send logout request to server
 */
Login.prototype.logout = function(){
	return Omss.post('/auth/logout');
}

Login.prototype.submit = function(form) {
	Omss.post('/auth/login', $(form).serialize()).done(function(data) {
		if (data.status == 1) {
			// showMain();
			// Omss.showSuccess('Đăng nhập ok');
			// window.open('', '_self');
			var userRole = data.role;
			
			if(userRole == 1){
				//admin
				window.location = "home/index";
			}else if(userRole == 2){
				window.location = "banhang/index";
			}
			
		} else {
			Omss.showError('Tên đăng nhập hoặc mật khẩu không đúng');
		}
	});
}


$(document).ready(function(){
	$('#login_form').submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});
	
	$("#btn_submit_login").click(function(){
		Omss.validate($('#login_form'), {
			login_user : {
				required : true,
				maxlength : 16,
			},
			login_password : {
				required : true,
				maxlength : 32,
			}
		}, login.submit);
	});
	
		
		
	// Omss.showError('Tên đăng nhập hoặc mật khẩu không đúng');in');
	//form submit event
	// $('#login_form').submit(function (evt) {
		// //stop submit
		// evt.preventDefault();
	// });
	
	//click submit button
	// $("#btn_submit_login").click(function(){
// //		alert('click submit button');
// 		
		// //get value
		// var username = $("#inputUsername").val();
		// var password = $("#inputPassword").val();
		// // login.login(username,password);
		// //call ajax to check login
		// $.ajax({
			// type : "POST",
			// url : urlLogin,
			// data : {
				// user : username,
				// pass : password
			// }
		// }).done(function(json) {
// 			
			// var messageDone = json['message'];
			// var status = json['status'];
// 
			// if(status == 1 || status == true){
				// //move to homepage
				// window.location = urlHome;
			// }else{
				// alert(messageDone);
			// }
		// }).fail(function(xhr, err) {
			// var responseTitle= $(xhr.responseText).filter('title').get(0);
			// alert($(responseTitle).text() + "\n" + formatErrorMessage(xhr, err) );
		// });
// 		
		// return false;
	// });
});