
$(function() {
    window.setTimeout(function () {
        $(".alert").alert('close');
    }, 5000);

    // minimize left menu
    const MIN_SHOW = 'min_show';
    $('.minimize-nav-but').click(function(e) {
        e.preventDefault();

        $('.navbar-static-side').toggleClass('minimize');
        $('#page-wrapper').toggleClass('maximize');
        $t = $(this).children();
        if($(this).children('.fa-angle-double-left').length) {
            $t.removeClass('fa-angle-double-left');
            $t.addClass('fa-angle-double-right');
            $.cookie(MIN_SHOW, 1, {expires: 30, path: '/'} );
        } else {
            $t.removeClass('fa-angle-double-right');
            $t.addClass('fa-angle-double-left');
            $.cookie(MIN_SHOW, 0, {expires: 30, path: '/'} );
        }
    });
});

function insertParam(key, value) {
    key = encodeURI(key); value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i=kvp.length; var x;
    while(i--) {
        x = kvp[i].split('=');

        if (x[0]==key)
        {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}
    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&');
}