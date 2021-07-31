$(function () {
    // init: side menu for current page
    $('li#menu-companies').addClass('menu-open active');
    $('li#menu-companies').find('.treeview-menu').css('display', 'block');
    $('li#menu-companies').find('.treeview-menu').find('.add-companies a').addClass('sub-menu-active');

    $('#get_addr').on('click', function(){
        var postcode = $('#postcode').val(); //id=postcodeのinputの内容が挿入
        var request = $.ajax({
            type: 'GET', //住所を取得するのでget
            url: '/postcode/' + postcode + '/address',
            cache: false,
            dataType: 'json',
            timeout: 3000
        });

    /* 成功時 */
        request.done(function(data){
            $('#prefecture').val(data[0]);
            $('#city').val(data[2]);
            $('#local').val(data[3]);
        });
    });

    $("[name='image']").on('change', function (e) {
    
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $("#preview").attr('src', e.target.result);
        }

        reader.readAsDataURL(e.target.files[0]);   

    });

    $('#company-form').validationEngine('attach', {
        promptPosition : 'topLeft',
        scroll: false
    });

    // // init: show tooltip on hover
    // $('[data-toggle="tooltip"]').tooltip({
    //     container: 'body'
    // });
});
