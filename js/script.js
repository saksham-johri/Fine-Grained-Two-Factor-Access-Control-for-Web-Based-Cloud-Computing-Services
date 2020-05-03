$(document).ready(function() {
  
  var animating = false,
      submitPhase1 = 1100,
      submitPhase2 = 400,
      logoutPhase1 = 800,
      $login = $(".login"),
      $app = $(".app"),
	  $msg = $(".msg"),
	  session = $("#session").html();
	
	if(session){
		if (animating) return;
		animating = true;
		var that = $('#login');
		ripple($(that), 1);
		$(that).addClass("processing");
		setTimeout(function() {
		  $(that).addClass("success");
		  setTimeout(function() {
			$app.show();
			$app.css("top");
			$app.addClass("active");
		  }, submitPhase2 - 70);
		  setTimeout(function() {
			$login.hide();
			$login.addClass("inactive");
			animating = false;
			$(that).removeClass("success processing");
		  }, submitPhase2);
		}, submitPhase1);
	}
  
  function ripple(elem, e) {
    $(".ripple").remove();
    var elTop = elem.offset().top,
        elLeft = elem.offset().left,
        x = e.pageX - elLeft,
        y = e.pageY - elTop;
    var $ripple = $("<div class='ripple'></div>");
    $ripple.css({top: y, left: x});
    elem.append($ripple);
  };
  
  $(document).on("submit", "#LI-form",function(ev){
		  if (animating) return;
			animating = true;
			var that = $('#verify_code');
			ripple($(that), 1);
			$(that).addClass("processing");
			var data = $("#LI-form").serialize();
			$.post('check_user.php', data, function(data,status){
				if( data == "done"){
					$(that).addClass("success");
					setTimeout(function() {
						window.location = 'dashboard';
					},5000);
				}
				else{
					alert("Wrong Code !");
				}
			});
			
			
		
		
  });
  
  $(document).on("submit", "#login-form", function(e) {	
	var data = $("#login-form").serialize();
	$.post('check_user.php', data, function(data,status){
		if( data != "done"){
			alert("Invalid Credentials !");
		}
	});
  });
  
  $(document).on("click", ".app__logout", function(e) {
    if (animating) return;
	$.post('logout.php', function(data,status){
	    $(".ripple").remove();
		animating = true;
		var that = this;
		$(that).addClass("clicked");
		setTimeout(function() {
		  $app.removeClass("active");
		  $login.show();
		  $login.css("top");
		  $login.removeClass("inactive");
		}, logoutPhase1 - 120);
		setTimeout(function() {
		  $app.hide();
		  animating = false;
		  $(that).removeClass("clicked");
		}, logoutPhase1);
	});
  });
  
});