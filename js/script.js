$(function () {

    $('body').on('click', '#add_user', function () {
        let params = {
            'action': 'add_user'
        };
        ajaxProcess(params);
    });

    $('body').on('click', '.delete_user', function () {
        let id = $(this).parent().attr('id');
        let params = {
            'action': 'delete_user',
            'id': id
        };
        ajaxProcess(params);
    });

});

function ajaxProcess(params) {

    let data_type;
    data_type = 'text';

    /*if (params.action == 'border_range') data_type = 'json';
    if (params.action == 'click_blank') data_type = 'json';*/

    let protocol = document.location.protocol;
    let host = document.location.host;
    let url = protocol + '//' + host + '/ajax.php';

    $.ajax({
        type: 'POST',
        url: url,
        data: params,
        dataType: data_type,
        success: function (res) {
            successAjax(res, params);
        },
        error: function (res, params) {
            errorAjax();
        },
    });
}

function successAjax(res, params) {

    switch (params.action) {
        case 'add_user':
            $('#table_users').html(res);
            break;
        case 'delete_user':
            $('#table_users').html(res);
            break;
    }
    //$('#table_users').DataTable();
}

function errorAjax(res, params) {
    console.log('Error ajax');
}
