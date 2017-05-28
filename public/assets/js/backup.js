/*
 * Backup prototype
 */
function Backup() {};

var backup = new Backup();

Backup.prototype.init = function() {	
	$("#btn-backup").click(function() {
		Omss.post('luudulieu/backup_data').done(function(data) {
			console.log(data);
			if(data.status){
				Omss.showSuccess(data.message);
				window.location.href = data.fileName;
			}else{
				Omss.showError(data.message);
			}
		});
	});
};

$(document).ready(function() {
    backup.init();
});