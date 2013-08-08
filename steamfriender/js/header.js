$("#rm").click(function() {
	$.post('server.php', {remove: "yes"}, function(data){
		$("#lookingtoplay").remove();
	});
});