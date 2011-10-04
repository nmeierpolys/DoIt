function ajaxLink(href){
	var start = href.indexOf('?');
	var end = href.length;
	var params = href.substring(start+1,end);
	$.ajax({
		url: "content.php",
		context: document.body,
		data: params,
		success: function(html){
			$("#bodyContent").html(html);
		}
	});
}

$(function(){	
		
	$('#loginButton').click(function(e){
		var element = '#popup'
		$(element).css("position","absolute");
		$(element).css("bottom",563);
		$(element).css("left",10);
		if($(element).css("display") == "none"){
			$(element).slideDown();
		} else {
			$(element).slideUp();
		}
	});
	
	$('.ajax a').click( function() {
		var href = $(this).attr('href');
		ajaxLink(href);
		return false;
	});
	
	$('.ajax-link').click( function() {
		var href = $(this).attr('href');
		ajaxLink(href);
		return false;
	});
});