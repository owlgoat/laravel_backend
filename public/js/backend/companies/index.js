$(function () {

    // init: side menu for current page
    $('li#menu-companies').addClass('menu-open active');
    $('li#menu-companies').find('.treeview-menu').css('display', 'block');
    $('li#menu-companies').find('.treeview-menu').find('.list-companies a').addClass('sub-menu-active');

    // call tabulator function and create tables
    const TRIANGLE_IMAGE_FOR_FILTER = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAAJCAYAAAA/33wPAAAAvklEQVQoFY2QMQqEMBBFv7ERa/EMXkGw11K8QbDXzuN4BHv7QO6ifUgj7v4UAdlVM8Uwf+b9YZJISnlqrfEUZVlinucnBGKaJgghbiHOyLyFKIoCbdvecpyReYvo/Ma2bajrGtbaC58kCdZ1RZ7nl/4/4d5EsO/7nzl7IUtodBexMMagaRrs+06JLMvcNWmaOv2W/C/TMAyD58dxROgSmvxFFMdxoOs6lliWBXEcuzokXRbRoJRyvqqqQvye+QDMDz1D6yuj9wAAAABJRU5ErkJggg==';

    var editorStyles = {
        "padding": "4px",
        "width": "100%",
        "box-sizing": "border-box",
        "-webkit-appearance": "none",
        "background-color": "white",
        "background-image": "url(" + TRIANGLE_IMAGE_FOR_FILTER + ")",
        "background-position": "right center",
        "background-repeat": "no-repeat",
        "padding-right": "1.5em",
        "border": "solid 1px #ccc",
        "border-radius": "0",
    };

    // Formatter for edit/delete
    var formatActionField = function (row, cell, formatterParams) {
        return '<form id="form-delete-' + row.getData()['id'] + '" action="' + rootUrl + '/companies/delete/" method="get">' +
               '<a class="btn btn-primary" href="' + rootUrl + '/companies/edit/' + row.getData()['id'] + '" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;' +
               '<input type="hidden" name="id" value="' + row.getData()['id'] + '">' +
               '<input type="hidden" name="delete_flag" value="1">' +
               '<span onclick="javascript:if(confirm(\'Are you sure want to delete this Data？\')) { document.getElementById(\'form-delete-' + row.getData()['id'] + '\').submit(); } return false;" class="btn btn-warning btn-delete" title="削除"><i class="fa fa-trash"></i></span>' +
               '</form>';
    }; // Formatter for edit/delete

    var joinAddress = function (cell) {
        var data = cell.getRow().getData();
        if (data.street_address == null) {
            return `${data.city}${data.local}`;
        }
        else {
            return `${data.city}${data.local}${data.street_address}`;
        }
    }

    var getPrefuctures = {1:'北海道',
        2:'青森県',
        3:'岩手県',
        4:'宮城県',
        5:'秋田県',
        6:'山形県',
        7:'福島県',
        8:'茨城県',
        9:'栃木県',
        10:'群馬県',
        11:'埼玉県',
        12:'千葉県',
        13:'東京都',
        14:'神奈川県',
        15:'新潟県',
        16:'富山県',
        17:'石川県',
        18:'福井県',
        19:'山梨県',
        20:'長野県',
        21:'岐阜県',
        22:'静岡県',
        23:'愛知県',
        24:'三重県',
        25:'滋賀県',
        26:'京都府',
        27:'大阪府',
        28:'兵庫県',
        29:'奈良県',
        30:'和歌山県',
        31:'鳥取県',
        32:'島根県',
        33:'岡山県',
        34:'広島県',
        35:'山口県',
        36:'徳島県',
        37:'香川県',
        38:'愛媛県',
        39:'高知県',
        40:'福岡県',
        41:'佐賀県',
        42:'長崎県',
        43:'熊本県',
        44:'大分県',
        45:'宮崎県',
        46:'鹿児島県',
        47:'沖縄県',
    }

    var getPrefuctureName = function (cell) {
        var data = cell.getRow().getData();
        return getPrefuctures[data.prefecture_id];
    }

    // call tabulator function and create tables
    $("#datalist").tabulator({
        layout: "fitColumns",
        placeholder: "There is not Data",
        responsiveLayout: false,
        resizableColumns: true,
        pagination: "local",
        paginationSize: 20,
        langs:{
            "ja-jp":{
                "pagination":{
                    "first":"<<",
                    "first_title":"First Page",
                    "last":">>",
                    "last_title":"Last Page",
                    "prev":"<",
                    "prev_title":"Prev Page",
                    "next":">",
                    "next_title":"Next Page",
                },
            },
        },
        columns: [
            {title: "ID", field: "id", width: 45, headerFilter: "input", sorter: "number", headerFilterPlaceholder: " "},
            {title: "Name", field: "name", width: 150, headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "Email", field: "email", width: 130, headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "Postcode", field: "postcode", width: 130, headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "Prefecture", field: "prefecture_id", width: 130, headerFilter: "select", headerFilterParams: getPrefuctures, formatter: getPrefuctureName, headerFilterPlaceholder: " "},
            {title: "Address", field: "city", minwidth: 200, headerFilter: "input", formatter: joinAddress, headerFilterPlaceholder: " "},
            {title: "Updated At", field: "updated_at", width: 150, headerFilter: "input", headerFilterPlaceholder: " "},
            {title: "Action", field: "action", align: "center", headerFilter: false, width: 100, formatter: formatActionField, headerFilterPlaceholder: " ", headerSort: false, frozen: true}
        ],
        dataLoaded: function (data) {
            redrawTabulator();
        },
        columnResized: function (column) {
            // none
        },
        pageLoaded: function (pageno) {
            setTimeout(function () {
                // display datalist information : Showing xx to yy of zz entries
                var totalData = $('#total-data').val();
                var pageSize = $("#datalist").tabulator("getPageSize");
                var dataMin = ((pageno * pageSize) + 1) - pageSize;
                var dataMax = pageno * pageSize;
                if (totalData < dataMax) {
                    dataMax = totalData;
                }
                $('#datalist-min-data').html(dataMin);
                $('#datalist-max-data').html(dataMax);
            }, 1200);
        },
        dataFiltered:function(filters, rows){
            redrawTabulator();
        }
    });

    $('#datalist').tabulator('setData', rootUrl + '/api/admin/companies/getCompaniesTabular');
    $('#datalist').tabulator('setLocale', 'ja-jp');

    $(window).resize(function(){
       redrawTabulator();
    });

    $('.sidebar-toggle').click(function() {
        redrawTabulator();
    });
});
// switch the style of column show/hide toggle modal panel
function switchAppearanceTabulatorColFilter() {
    var windowsize = $(window).width();
    if(windowsize > 767) {
        $('.modal-col-tabulator-content').css({
            'left' : $("#btn-col-tabulator").offset().left - 550 + 140,
            'top' : $("#btn-col-tabulator").offset().top + 10,
        });
    } else {
        $('.modal-col-tabulator-content').removeAttr("style");
    }
}
// redraw tabulator column
function redrawTabulator() {
    setTimeout(function() {
        $('#datalist').tabulator('redraw', true);
        PageDataInfo();

    }, 300);
}

function PageDataInfo(data){
    var getDataCount = $("#datalist").tabulator("getDataCount");
    var getPage      = $("#datalist").tabulator("getPage");
    var getPageSize  = $("#datalist").tabulator("getPageSize");
    var getPageMax   = $("#datalist").tabulator("getPageMax");

    $('#datalist-total-data').html(getDataCount);
    $('#total-data').val(getDataCount);

    if(getDataCount < getPageSize) {
        getPageSize = getDataCount;
    }

    $('#datalist-max-data').html(getPageSize);


    if(getPageSize == 0) {
        $('#datalist-min-data').html(0);
    } else {
        $('#datalist-min-data').html(1);
    }

    if(getDataCount > 0 ){
        $('#datalist-header').removeClass('invisible');
    }else{
        $('#datalist-header').addClass('invisible');
    }
}