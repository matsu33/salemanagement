$(document).ready(function() {
    console.log('update.js > ready');
});

function callUpdateCodeFromGithub(){
    console.log('callUpdateCodeFromGithub');
    var data = {
        latest_version: latestVersion
    };
    Omss.post('update/getUpdatedCodeFromGithub', data).done(function(data) {
        if (data) {
            var result = data['status'];
            console.log(data);
            if(result == true)
            {
                Omss.showSuccess('Đã cập nhật thành công');
                location.reload();
            }
            else
            {
                Omss.showError('Lỗi cập nhật');
            }
        } else {
            Omss.showError('Lỗi cập nhật');
        }
    }).fail(function(message){
        Omss.showError(message.getFail);
    });
}