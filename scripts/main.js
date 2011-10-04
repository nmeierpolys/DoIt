function popup_show(id)
	{
	}
	
$(function(){	
	$('.ajax-link').click( function() {
		var href = $(this).attr('href');
		var start = href.indexOf('?');
		var end = href.length;
		var params = href.substring(start+1,end);
		alert(params);
		$.ajax({
			url: "content.php",
  			context: document.body,
			data: params,
			success: function(html){
				$("#bodyContent").html(html);
			}
		});
		return false;
	});
	
	$('#loginButton').click(function(e){
		var element = '#popup'
		var x = e.pageX+15;
		var y = e.pageY;
		$(element).css("position","absolute");
		$(element).css("top",y);
		$(element).css("left",x);
		if($(element).css("display") == "none"){
			$(element).show('slow');
		} else {
			$(element).hide('slow');
		}
		
		//.show('slow');
		//.css('visibility',"visible");
		//$('loginForm').show('slow');
	});
	
	$('#test').click(function(){
		$(this).hide('slow');
	});
});