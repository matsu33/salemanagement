/*
 * Restore prototype
 */
function Restore() {};

var restore = new Restore();

Restore.prototype.init = function() {
	var that = this;
	$("#btn-restore").click(function(e) {
		e.preventDefault();
		var file = $('#f-restore')[0].files[0];
        if (typeof file === "undefined") {
			Omss.showError("Vui lòng chọn file!");
            return false;
        } else {
            if (!restore.checkFileName(file.name)) {
    			Omss.showError("Vui lòng chọn file sql!");
                return false;
            } else {
        		var formData = new FormData($('#frm-restore')[0]);
        	    var url = "/phuchoidulieu/restore";
        	    
        	    Omss.upload(url, formData).done(function(data) {
        	    	if(data.status){
        				Omss.showSuccess(data.message);
        	    	}else{
        				Omss.showError(data.message);
        	    	}
        		});
            }
        }
	});
};

Restore.prototype.checkFileName = function(fileName) {
	 var fileExtension = fileName.split('.').pop();
     var isValid = false;
     switch (fileExtension) {
         case 'sql':
             isValid = true;
             break;
         default:
             isValid = false;
             return false
     }
     return isValid;
}

$(document).ready(function() {
	restore.init();
});