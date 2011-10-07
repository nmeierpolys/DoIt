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
     		window.history.pushState({"html":html,"pageTitle":document.title},"", href);
		}
	});
	
}

$(function(){	
		
	$('#loginButton').click(function(e){
		var element = '#popup'
		$('#bodyContent').prepend($(element));
		$(element).css("position","absolute");
		$(element).css("top",2);
		$(element).css("left",2);
		if($(element).css("display") == "none"){
			$(element).slideToggle('fast');
		} else {
			$(element).slideToggle('fast');
		}
		$('#username').first().focus();
	});
	
	$('.ajax-link').live('click', function(e){
		var href = $(this).attr('href');
		ajaxLink(href);
		return false;
	});
	
	$('.ajax a').live('click', function(e){
		var href = $(this).attr('href');
		ajaxLink(href);
		return false;
	});
});