$(document).ready(function(){
	var nua = navigator.userAgent
	  var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
	  if (isAndroid) {
		$('select.form-control').removeClass('form-control').css('width', '100%')
	  }
	  
	//$( "#sortable" ).sortable();
	//$( "#sortable" ).disableSelection();
	
	var panelList = $('#sortable');
	//panelList.sortable();
		panelList.sortable({
		revert: true,
	  scroll: true,
	  cursor: "move",
	  start: function(event, ui) {
        ui.item.startPos = ui.item.index();
    },
    stop: function(event, ui) {
        console.log("Start position: " + ui.item.startPos);
        console.log("New position: " + ui.item.index());
    }
	});
});