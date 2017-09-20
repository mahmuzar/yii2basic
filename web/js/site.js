/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$.ajax({
    url: "/index.php?r=notification/notification/index"
}).done(function (data) {
    if (data.length > 0) {
        ddmenu = ''
        var htmlText = '<li><a href="/index.php?r=notification/notification/index" title="Уведомление о новых событиях">Уведомлений: <span class="badge">' + data.length + '</span></a></li>';
        $('#navs').prepend(htmlText);
    }
});

//console.log($('.status'));
$('.status').on('click', function () {
    var thisObj = $(this);
    if (!$(thisObj).attr('disabled')) {
        $(thisObj).attr('disabled', true);
        $.ajax({
            url: "/index.php?r=news/status&id=" + $(thisObj)[0].hash.substr(1)
        }).done(function (data) {
            if ($(thisObj).hasClass("btn-success")) {
                $(thisObj).removeClass("btn-success");
                $(thisObj).addClass("btn-danger");
                $(thisObj).text('inactive');
            } else {
                $(thisObj).removeClass("btn-danger");
                $(thisObj).addClass("btn-success");
                $(thisObj).text('active');
            }
            $(thisObj).removeAttr('disabled');
        });
    }
});

