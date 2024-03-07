$(window).ready(function(){
	controlMenu();
});

function controlMenu() {
	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
	var currentScrollPos = window.pageYOffset;
	  if (prevScrollpos > currentScrollPos) {
	  	$('#navbar').css({
	  		"top": "0",
	  		"position":"fixed"
	  	});
	  } else {
	  	$('#navbar').css({
	  		"top": "-20%"
	  	});
	  	$('.navbar-collapse').removeClass('show');
	  }

	  if(currentScrollPos == 0){
	  	$('#navbar').css({
	  		"position":"relative"
	  	});
	  }

	  prevScrollpos = currentScrollPos;

	}


	/*var altura = $('#navbar').offset().top;

		$(window).on('scroll',function(){
		  if ($(window).scrollTop() > altura) {
		  	$('#navbar').addClass('fixed-top');
		  }else{
		    $('#navbar').removeClass('fixed-top');
		  }
		});*/
}

