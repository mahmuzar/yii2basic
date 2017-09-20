/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('.update_user').on('click', function () {
    //alert('d');
    //console.log($(this));
    var id = $(this)[0].hash.substr(1);
    var url = "/index.php?r=users/update&id=" + id;
    //console.log(url);
    localStorage.setItem('href', url);
    //console.log(localStorage);


    $.get(url, function (data) {

        $(".update_user_modal").html(data);
        //console.log(data);
        $('#user_update_form').attr('action', url);
        $("#update_modal").modal("show");
    });

});

