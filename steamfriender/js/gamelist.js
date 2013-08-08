$("#coop_list_btn, #game_list_btn, #local_coop_list_btn, #multiplayer_list_btn").click( function(e) {
	unselectButtons();
	hideTabs();
	var id = this.id;
	var str = id.replace("_btn","");
	$("#" + str).css("display","inline");
	$("#" + id).css("opacity","1");
});

function unselectButtons(){
	$('#game_list_btn').css("opacity",".5");
	$('#coop_list_btn').css("opacity",".5");
	$('#local_coop_list_btn').css("opacity",".5");
	$('#multiplayer_list_btn').css("opacity",".5");
}

function hideTabs(){
	$("#game_list").css("display","none")
	$("#coop_list").css("display","none")
	$("#local_coop_list").css("display","none")
	$("#multiplayer_list").css("display","none")
}

/*$(".game_img").qtip({
   content: {
      url: 'game.php',
      data: { id: 5 },
      method: 'get'
   }
});*/

$('.game_img[title]').qtip({
	position: {
		adjust: {
			y: 0
		},
		my: 'bottom center',
		at: 'top center',
	},
	style: {
		tip: false,
		prerender:true,
		classes: 'ui-tooltip-dark'
	}
});

/*$(".game_img[title]").qtip({
   style: { 
      padding: 5,
      background: '#121212',
      color: '#989898',
      textAlign: 'center',
      border: {
         radius: 1,
         color: '#212121'
      },
      tip: 'topMiddle',
	  corner: 'bottomMiddle',
      name: 'dark' // Inherit the rest of the attributes from the preset dark style
   }
});*/
