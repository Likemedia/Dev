$(document).ready(function() {

    $(document).bind('keypress', function(e){
        var code = e.keyCode || e.which;
        if(code == 43){
            $('.file-div button').click()
        }
    })

    $('form').bind('keypress', function(e){
        var code = e.keyCode || e.which;
        // console.log($(this))
        if(code == 13){
            e.preventDefault();
            saveForm($(this).children('input[type=submit]'))
        }
    })

    // Make active first input
    $('form').find('input[type=text]').filter(':visible:first').focus();
    // Make active first input

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });

    $('#tablelistsorter').tableDnD({
        onDrop: function(table, row) {
            var action = $('#tablelistsorter').attr('action');
            if(action != undefined){
                var  url = $('#tablelistsorter').attr('url')+ '/changePosition'
            }
            else{
                var url = window.location.pathname + '/changePosition'
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    neworder: $.tableDnD.serialize(),
                    action: action
                },
                success: function(data) {
                }
            });

        },
        dragHandle: "dragHandle"
    });

    $("#tablelistsorter tr").hover(function() {
        $(this.cells[4]).addClass('showDragHandle');
    }, function() {
        $(this.cells[4]).removeClass('showDragHandle');
    });

    $(".dragHandle").css("cursor", "move");

    $("#lma").css("cursor", "pointer").click(function(){

        if($("#lma-img").attr("src") == "/img/back/lma-right.gif"){
            $(".leftmenu").hide();
            $("#lma-img").attr("src", "/img/back/lma-left.gif");
            $(".lma").css("left", "0");
            $(".main-div").css("margin-left", "18px");
            $.post("/back/e.php", {action: "leftmenustatus", leftmenustatus: "closed"}, function(data){
                if(data!=0){

                }
            });
        }else {
            $(".leftmenu").show();
            $("#lma-img").attr("src", "/img/back/lma-right.gif");
            $(".lma").css("left", "184px");
            $(".main-div").css("margin-left", "0");
            $.post("/back/e.php", {action: "leftmenustatus", leftmenustatus: "opened"}, function(data){
                if(data!=0){

                }
            });
        }
    })

    // Change active element
    $('.change-active').click(function(){
        var active = $(this).attr('active')
        var action = $(this).attr('action')
        var element_id = $(this).attr('element-id')

        if(action != undefined){
           var  url = $(this).attr('url') + '/ajaxRequest/changeActive'
        }
        else{
            var url = window.location.pathname + '/ajaxRequest/changeActive'
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: action,
                active: active,
                id: element_id
            },
            success: function(data) {
            }
        });
    })
    //End change active element

    //Upload img
    var inputFilesFormat = ".file-div input[type='hidden']";
    $(inputFilesFormat ).each(function (iterator, parentThat) {
        var htmlFormat = "<div class='none'>" +
            "<form action='" + $(parentThat).data('url')+ "' enctype='multipart/form-data' class='upload-form' upload='" + $(parentThat).attr('path')+ "' >" +
            "<input type='file' name='" + $(parentThat).attr('name')+ "'/>" +
            "</form>" +
            "</div>";
        $('body').append(htmlFormat);
    });
    $(document).on('click','.file-div button', function (parentThat) {
        parentThat.preventDefault();

        //$(this).find('span').addClass('glyphicon-refresh');

        var inputName = $(this).closest('div').find('input').attr('name');
        var clonedFileInput = $('input[name='+ inputName +'][type="file"]');
        $(clonedFileInput).trigger('click');

    });

    // $(document).on('change','input[type=file]', function  () {
    //     var parentThat = $(this);
    //     setTimeout(function(){
    //         $(parentThat).closest('form').submit();
    //     }, 500);
    // });

    $(document).on('submit', '.upload-form', function(e){
        e.preventDefault();

        var inputName = $(this).find('input').attr('name');
        var clonedTextHidenInput = $('input[name='+ inputName +'][type="hidden"]');
        $(clonedTextHidenInput).closest('div').find('span').addClass('glyphicon-refresh');

        if($(this).find('input').val() == '') {
            $(clonedTextHidenInput).closest('div').find('span').removeClass('glyphicon-refresh');
            return;
        }

        var formData = new FormData($(this)[0]);
        var url = $(this).attr('action');
        var uploadPath = $(this).attr('upload')

        formData.append('uploadPath', uploadPath)
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            async: true,
            success: function (data) {
                $(clonedTextHidenInput).closest('div').find('img').remove();

                for(var i in data[0].fileName){
                    $(clonedTextHidenInput).val(data[0].url[i]);
                    if(data.fileType = 'img'){
                        $(clonedTextHidenInput).closest('div').append("<img src='" + data[0].url[i] + "' /></div>");
                        $(clonedTextHidenInput).closest('div').find('span').removeClass('glyphicon-refresh');
                    }
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });
    //End upload img

    // Change select input, textarea, ckeditor
    var set_type = $('#set_type').val()
    if(set_type == 'textarea') {
        $('.input').hide().find('input').val('')
        $('.ckeditor').hide()
        $('.textarea').show()
        CKEDITOR.instances.body.setData('');
    }

    if(set_type == 'ckeditor') {
        $('.input').hide().find('input').val('')
        $('.textarea').hide().find('textarea').val('')
        $('.ckeditor').show()
    }

    if(set_type == 'input') {
        $('.textarea').hide().find('textarea').val('')
        $('.ckeditor').hide()
        $('.input').show()
        CKEDITOR.instances.body.setData('');
    }

    if(set_type == 'page') {
        $('.link').hide().find('input').val('')
        $('.controller').hide().find('input').val('')
        $('.ckeditor').show()
    }

    if(set_type == 'link') {
        $('.controller').hide().find('input').val('')
        $('.ckeditor').hide()
        $('.link').show()
        CKEDITOR.instances.body.setData('');
    }

    if(set_type == 'code'){
        $('.link').hide().find('input').val('')
        $('.ckeditor').hide()
        $('.controller').show()
        CKEDITOR.instances.body.setData('');
    }

    $('#set_type').on('change', function(){
        var set_type = $(this).val()

        if(set_type == 'textarea') {
            $('.input').hide().find('input').val('')
            $('.ckeditor').hide()
            $('.textarea').show()
            CKEDITOR.instances.body.setData('');
        }

        if(set_type == 'ckeditor') {
            $('.input').hide().find('input').val('')
            $('.textarea').hide().find('textarea').val('')
            $('.ckeditor').show()
        }

        if(set_type == 'input') {
            $('.textarea').hide().find('textarea').val('')
            $('.ckeditor').hide()
            $('.input').show()
            CKEDITOR.instances.body.setData('');
        }

        if(set_type == 'page') {
            $('.controller').hide().find('input').val('')
            $('.link').hide()
            $('.ckeditor').show()
        }

        if(set_type == 'link') {
            $('.controller').hide().find('input').val('')
            $('.ckeditor').hide()
            $('.link').show()
            CKEDITOR.instances.body.setData('');
        }

        if(set_type == 'code'){
            $('.link').hide().find('input').val('')
            $('.ckeditor').hide()
            $('.controller').show()
            CKEDITOR.instances.body.setData('');
        }
    })
    //End change select input, textarea, ckeditor

    //Generate alias
    $('.name').keyup(function () {
        $lang = $(this).attr('data-lang');
        $('#slug-'+$lang).val(translit($(this).val()))
    })

    if($('#alias').val() == '') {
        $('#name').keyup(function () {
            $('#alias').val(translit($(this).val()))
        })
    }
    //Generate alias

    //Alert block
    setTimeout(function(){
        $('.alert.alert-info').fadeOut('slow');
    }, 3000)

    $('.alert.alert-info').on('click', function(){
        $('.alert.alert-info').fadeOut('slow');
    })
    //End alert block

    //Error alert block
    setTimeout(function(){
        $('.error-alert.alert-info').fadeOut('slow');
    }, 3000)

    $('.error-alert.alert-info').on('click', function(){
        $('.error-alert.alert-info').fadeOut('slow');
    })
    //End error alert block

    // Datepicker
    $('#datepicker').change(function(){
        var date = $('#datepicker').datepicker().val();
         $('#datepicker').attr('value', date)
    })
    // End datepicker

    // //Select with search
    // var config = {
    //     '.chosen-select'           : {},
    //     '.chosen-select-deselect'  : {allow_single_deselect:true},
    //     '.chosen-select-no-single' : {disable_search_threshold:10},
    //     '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    //     '.chosen-select-width'     : {width:"100%"}
    // }
    // for (var selector in config) {
    //     $(selector).chosen(config[selector]);
    // }
    // //End select with search

    //Confirmation
    $('.destroy-element').click(function(e){
        var conf = confirm("Do you want delete this element?");
        if(conf != true)
            e.preventDefault();
        else
            window.location.reload();
    })
    //Confirmation

});




toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "3000",
    "hideDuration": "3000",
    "timeOut": "3000",
    "extendedTimeOut": "3000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};


function saveForm(parentThat, functionName) {
    var form_id = $(parentThat).data('form-id');
    $( '#'+form_id ).submit(function( event ) {
        event.preventDefault();
    });

    $('[data-type="ckeditor"]').each(function (index, el) {
        $(this).val(CKEDITOR.instances.body.getData())
    });

    var form = $('#'+ $(parentThat).data('form-id'));
    var serializedForm = $(form).find("select, textarea, input").serialize();

    if (!$(form)) {
        toastr.error('Error! Please contact administrator');
        return;
    }
    $.ajax({
            method: "POST",
            url: $(form).attr('action'),
            data: serializedForm
        })
        .done(function (response) {

            if(response.messages == null)
                return;

            var ObjNames = Object.keys(response.messages);

            for(var messageKeyIterator in ObjNames){

                $(form).find("[name='"+ObjNames[messageKeyIterator]+"']").addClass('error');

            }
            if(response.status == true)
                for (var messageIterator in response.messages) {

                    toastr.success(response.messages[messageIterator]);
                }
            else
                for (var messageIterator in response.messages) {

                    toastr.error(response.messages[messageIterator]);
                }

            if (response.redirect) {
                setTimeout(function () {
                    window.location = response.redirect;
                }, 1000);

            }

            if (response.itemId) {

                $(form).find('[name="item_id"]').val(response.itemId);

                $(form).submit();
            }
            if(functionName != undefined){
                window[functionName]();
            }
        })
        .fail(function (msg) {
            toastr.error('Fail to send data');
        });

}


function ChangeActionDisplay(modules_id){
    actions = ['new', 'save', 'active', 'del_to_rec', 'del_from_rec'];
        if (document.getElementById('modules_id['+modules_id+']').checked == true){

        document.getElementById('taction['+modules_id+']').style.display = 'block';
        for (i=0; i<actions.length; i++){
            document.getElementById(actions[i]+'['+modules_id+']').checked = true;
        }
    } else{
        document.getElementById('taction['+modules_id+']').style.display = 'none';
        for (i=0; i<actions.length; i++){
            document.getElementById(actions[i]+'['+modules_id+']').checked = false;
        }
    }
}

function translit(s){
    var t="îişsăaâaţtаaбbвvгgдdеeёjoжzhзzиiйjjкkлlмmнnоoпpрrсsтtуuфfхkhцcчchшshщshhъ''ыyь'эehюjuяjaĂAÂAÎIŞSŢTАAБBВVГGДDЕEЁJoЖZhЗZИIЙJjКKЛLМMНNОOПPРRСSТTУUФFХKhЦCЧChШShЩShhЪ''ЫYЬ'ЭEhЮJuЯJa";
    t=t.replace(/([а-яёЁţâăşî])([a-z']+)/gi,'.replace(/$1/g,"$2")');
    ret = eval("s"+t);
    ret = ret.replace(/[^a-z0-9]/gi, "-");
    ret = ret.replace(/-{2,1000}/gi, "-");
    ret = ret.replace(/-$/gi, "").toLowerCase();
    return ret;
}

//datepicker

jQuery(function ($) {
    $.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: 'Пред',
        nextText: 'След',
        currentText: 'Сегодня',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        weekHeader: 'Нед',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.regional['ro'] = {
        closeText: 'Inchide',
        prevText: 'Precedenta',
        nextText: 'Urmatoarea',
        currentText: 'Astazi',
        monthNames: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie',
            'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'],
        monthNamesShort: ['Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'Mai', 'Iunie',
            'Iulie', 'August', 'Septembrie', 'Octombrie', 'Noiembrie', 'Decembrie'],
        dayNames: ['duminica', 'luni', 'marti', 'miercuri', 'joi', 'vineri', 'simbata'],
        dayNamesShort: ['dum', 'lun', 'mar', 'mie', 'joi', 'vin', 'sim'],
        dayNamesMin: ['Du', 'Lu', 'Ma', 'Mi', 'Jo', 'Vi', 'Si'],
        weekHeader: 'Sap',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $('#datepicker').datepicker($.extend({
            inline: true,
        },
        $.datepicker.regional[$('#datepicker').attr('lang')]
    ));
});

$().ready(function(){
    $('.drop-down').on('click', function(){
        $(this).next('.drop-hd').slideToggle();
        $(this).parent().toggleClass('open');
        return false;
    });

    $('.active').addClass('open');

    $('.input-group-addon').on('click', function(){
        $(this).parent().prev().remove();
        $(this).parent().remove();
    });
});

$(document).ready(function(){
    $('.nav-link').on('click', function(){
        $id = $(this).attr('href');
        $('.nav-link').removeClass('open active');
        $(this).addClass('open active');
        $('.tab-content').removeClass('active-content');
        $($id).addClass('active-content');
        return false;
    });

    $("#upload-file").change(function() {
      readURL(this);
    });
});

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#upload-img').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}



// $(document).ready(function(){
//
//    var updateOutput = function(e)
//    {
//        var list   = e.length ? e : $(e.target),
//            output = list.data('output');
//        if (window.JSON) {
//            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
//        } else {
//            output.val('JSON browser support required for this demo.');
//        }
//
//        $.ajax({
//            type: "POST",
//            url:  window.location.pathname + '/ajaxRequest/some',
//            data: {
//                info: json = window.JSON.stringify(list.nestable('serialize'))
//            },
//            success: function(data) {
//
//            }
//        });
//
//    };
//
//   $('#nestable3').nestable({
//       group: 1
//   })
//   .on('change', updateOutput);
//
//   updateOutput($('#nestable3').data('output', $('#nestable3-output')));
//
//   $('#nestable3').nestable();
//
//
// // delete menu
//     $('.delete-menu').on('click', function(){
//         $id = $(this).attr('data-id');
//         $this = $(this);
//
//         $.ajax({
//            type: "POST",
//            url:  window.location.pathname + '/ajaxDeleteMenu/removeMenu',
//            data: { id: $id },
//            success: function(data) {
//                $this.parent().parent().hide();
//            }
//        });
//
//     });
//
// //  edit menu
//     $('.edit-menu').on('click', function(){
//         $id = $(this).attr('data-id');
//         $val = $(this).parent().children('.menu_name').text();
//         $this = $(this);
//
//         $.ajax({
//            type: "POST",
//            url:  window.location.pathname + '/ajaxEditMenu/editMenu',
//            data: { id: $id, val : $val },
//            success: function(data) {}
//        });
//     });
//
// });
