/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('.update_news').on('click', function () {
    var id = $(this)[0].hash.substr(1);
    var url = "/index.php?r=news/update&id=" + id;
    localStorage.setItem('href', url);
    $.get(url, function (data) {

        $(".update_news_div").html(data);
        //console.log(data);
        $('#news_update_form').attr('action', url);
        $("#update_news_modal").modal("show");
    });
});




