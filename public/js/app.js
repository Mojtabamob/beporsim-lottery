$(function(){

    function counter(i,winner,max){
        //remove previous frame expect last one
        if(max-1 != i) {
            $('.content').animate({
                'opacity': 0,
                'min-height': 260,
                'margin-top': 20
            },1000);
        }

        $('.num-counter').addClass('start').html(winner.id).counterUp({
            delay: 10,
            time: 2000
        });

        setTimeout(function () {
            $('#wmobile').html(winner.user.mobile);
            $('#wname').html(winner.user.name);
            $('#wprize').html(winner.prize);

            $('.content').animate({
                'opacity': 1,
                'min-height': 260,
                'margin-top': 20
            },2000);
        },2000);
    }

	$('.button span').on('click', function() {
		if (! $('.button').hasClass('active')) {
            $('body').css("cursor", "wait");
			$('.button').addClass('active');

			//AJAX Req
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {}
            }).done(function( data ) {
                if(data.status == 0){
                    $('body').css("cursor", "auto");
                    $('.button').hide();
                    $.each(data.winners,function(i,winner){
                        setTimeout(function () {
                            counter(i,winner,data.winners.length);
                        }, 7000*i);
                    });
                }
            });
		}
	});

});
