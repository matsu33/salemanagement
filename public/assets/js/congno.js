$(document).ready(function(){
	$(".congno_ngay, .congno_thang, .congno_nam").hide();
	
	$('#choncachxem_modal').modal('show');
	
	$(".congno_xemngay_btn").click(function(){
		$('#choncachxem_modal').modal('hide');
		$(".congno_ngay").show();
		$(".congno_thang").hide();
		$(".congno_nam").hide();
	});
	
	$(".congno_xemthang_btn").click(function(){
		$('#choncachxem_modal').modal('hide');
		$(".congno_ngay").hide();
		$(".congno_thang").show();
		$(".congno_nam").hide();
	});
	
	$(".congno_xemnam_btn").click(function(){
		$('#choncachxem_modal').modal('hide');
		$(".congno_ngay").hide();
		$(".congno_thang").hide();
		$(".congno_nam").show();
	});
	
});
