$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({container: 'body'});
});
$(document).ready(function(){


    $("[data-toggle=users]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#users').html();
        }
    });
    $("[data-toggle=posts_all]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#posts_all').html();
        }
    });
    $("[data-toggle=categories]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#categories').html();
        }
    });


    $("[data-toggle=logged_user]").popover({
        html: true,
        container: 'body',
        content: function() {
            return $('#logged_user').html();
        }
    });
    $("[data-toggle=emojiFlag]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiFlag').html();
        }
    });
    $("[data-toggle=emojiSport]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiSport').html();
        }
    });
    $("[data-toggle=emojiAnimals]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiAnimals').html();
        }
    });
    $("[data-toggle=emojiClassic]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiClassic').html();
        }
    });
    $("[data-toggle=emojiClothes]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiClothes').html();
        }
    });
    $("[data-toggle=emojiEmojis]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiEmojis').html();
        }
    });
    $("[data-toggle=emojiFood]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiFood').html();
        }
    });
    $("[data-toggle=emojiHolidays]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiHolidays').html();
        }
    });
    $("[data-toggle=emojiOther]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiOther').html();
        }
    });
    $("[data-toggle=emojiRest]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiRest').html();
        }
    });
    $("[data-toggle=emojiTravel]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiTravel').html();
        }
    });
    $("[data-toggle=emojiWeather]").popover({
        html: true,
        container: 'body',
        width:'1500px',
        content: function() {
            return $('#emojiWeather').html();
        }
    });
    //Popover closing code when click on some area
    $(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
            }

        });
    });
});
