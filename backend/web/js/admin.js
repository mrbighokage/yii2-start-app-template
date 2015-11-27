
$(function() {

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
            setYiiCookie(MIN_SHOW, 1);
            //$.cookie(MIN_SHOW, 1, {expires: 30, path: '/'} );
        } else {
            $t.removeClass('fa-angle-double-right');
            $t.addClass('fa-angle-double-left');
            setYiiCookie(MIN_SHOW, 0);
            //$.cookie(MIN_SHOW, 0, {expires: 30, path: '/'} );
        }
    });
});

function setYiiCookie($key, $value) {
    $.ajax({
        dataType: 'json',
        method: 'POST',
        url: '/admin/default/set-cookie',
        data: {
            key: $key,
            value: $value
        }
    }).done(function(data) {
        if(data.code == "200") {
        } else {
            console.log(data.message);
        }
    });
}

function getYiiCookie($key) {
    $cookie = '';
    $.ajax({
        dataType: 'json',
        method: 'POST',
        async: false,
        url: '/admin/default/get-cookie',
        data: {
            key: $key
        }
    }).done(function(data) {
        if(data.code == "200") {
            $cookie = data.value;
        } else {
            console.log(data.message);
        }
    });
    return $cookie;
}

function setUrlParam(key, value) {
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

function getUrlParam(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
