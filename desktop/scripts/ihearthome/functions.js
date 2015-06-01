$(document).ready(function() {
		
	if($('div.trigger').length > 0) {
		$('div.trigger').click(function() {
			if ($(this).hasClass('open')) {
				$(this).removeClass('open');
				$(this).addClass('close');
				$(this).next().slideDown(100);
				return false;
			} else {
				$(this).removeClass('close');
				$(this).addClass('open');
				$(this).next().slideUp(100);
				return false;
			}			
		});
	}
	
});

  // expanding, collapsing div script
$(document).ready(function() {
  $(".toggle-content").slideUp();
  $(".byline").click(function() {
    var $next = $(this).next(".toggle-content");
        $('.byline').not(this).removeClass('exp');
    $(".toggle-content").not($next).slideUp();
    $next.slideToggle(500); 
        $(this).toggleClass('exp');
  });
});

  // expanding, collapsing div script
$(document).ready(function() {
  $(".toggle-content").slideUp();
  $(".bylinebinbarb").click(function() {
    var $next = $(this).next(".toggle-content");
        $('.bylinebinbarb').not(this).removeClass('exp');
    $(".toggle-content").not($next).slideUp();
    $next.slideToggle(500); 
        $(this).toggleClass('exp');
  });
});

// carousel in bin barber //
$(function() {
    // Initialize jquery-ui slider
    $('#slider').slider({
        range: "min",
        value: 10,
        min: 10,
        max: 50,
        step: 10,
        slide: function(event, ui) {
            $('#amount').val('£' + ui.value);
        }
    });
    
    // Initialize #amount input value
    $('#amount').val('£' + $('#slider').slider('value'));
    
    // Click event handler on #calculate link
    $('#calculate').click(function(e) {
        // Retrieve the slider value (10, 20, 30, etc.), divide by 10
        // to get the corresponding carousel slide index (0 based)
        // and use the 'goto' function (cf. http://jquery.malsup.com/cycle2/api/)
        $('#s1').cycle('goto', $('#slider').slider('value')/10);
    });
    
});

// this makes the recalculate button work //

$(function() {
    $('#s1').cycle({ 
        timeout: 0, 
        speed:   300,
        startingSlide: 1 
    });
    $('#recal').click(function() { 
        $('#s1').cycle(0); 
        return false; 
    });

    $('#s1').cycle({ 
        timeout: 0, 
        speed:   300,
        startingSlide: 1 
    });
    $('#recal1').click(function() { 
        $('#s1').cycle(0); 
        return false; 
    });
    $('#s1').cycle({ 
        timeout: 0, 
        speed:   300,
        startingSlide: 1 
    });
    $('#recal2').click(function() { 
        $('#s1').cycle(0); 
        return false; 
    });
    $('#s1').cycle({ 
        timeout: 0, 
        speed:   300,
        startingSlide: 1 
    });
    $('#recal3').click(function() { 
        $('#s1').cycle(0); 
        return false; 
    });
    $('#s1').cycle({ 
        timeout: 0, 
        speed:   300,
        startingSlide: 1 
    });
    $('#recal4').click(function() { 
        $('#s1').cycle(0); 
        return false; 
    });        
});