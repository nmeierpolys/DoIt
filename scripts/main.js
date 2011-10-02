function popup_show(id)
	{
	}
	
$(function(){
	
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