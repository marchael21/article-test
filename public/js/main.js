$.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-chevron-up',
        down: 'fas fa-chevron-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        // today: 'fas fa-arrows ',
        // clear: 'fas fa-trash',
        // close: 'fas fa-times'
    } 
});


$( document ).ready(function() {

    $('.uppercase').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });

    $(".form-control-select").chosen({
        allow_single_deselect: true,
        width: '100%'
    });

    $('.amount').on('load change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            var str = value.toString().replace("$", "").replace(/[^0-9\.]/g,''), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                    output.push(str[j]);
                    if(i%3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            //return("$" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
            return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));

            // return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  //replace(/^0+/, '').  ---- regex for clearing zero 
            //return value.replace(/(?!\.)\D/g, "").replace(/(?<=\..*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  //replace(/^0+/, '').  ---- regex for clearing zero 
        });
    }));
    
});   

// toastr init
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

// swal init
const swal = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success btn-lg ml-1 mr-1',
    cancelButton: 'btn btn-danger btn-lg ml-1 mr-1'
  },
  buttonsStyling: false
})

function renderAlertMsg(alertMsg) {
    console.log(alertMsg);
    if (alertMsg.type == 'swal') {
        Swal.fire(alertMsg)
    } else if(alertMsg.type == 'toastr') {
        if (alertMsg.icon == 'success') {
            toastr.success(alertMsg.text,alertMsg.title);
        } else if (alertMsg.icon == 'info') {
            toastr.info(alertMsg.text,alertMsg.title);
        } else if (alertMsg.icon == 'error') {
            toastr.error(alertMsg.text,alertMsg.title);
        }
    } else {
        Swal.fire(alertMsg) //swal alert as default
    }
}


/*
* Maintain / Keep scroll position after post-back / postback / refresh. Just include plugin (no need for cookies)
*
* Author: Evalds Urtans
* Website: http://www.evalds.lv
*/
// (function($){
// window.onbeforeunload = function(e){    
// window.name += ' [' + location.pathname + '[' + $(window).scrollTop().toString() + '[' + $(window).scrollLeft().toString(); AND if( parts[parts.length - 3] == location.pathname ){ window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
// $.maintainscroll = function() {
// if(window.name.indexOf('[') > 0)
// {
// var parts = window.name.split('['); 
// window.name = $.trim(parts[0]);
// window.scrollTo(parseInt(parts[parts.length - 1]), parseInt(parts[parts.length - 2]));
// }   
// };  
// $.maintainscroll();
// })(jQuery);


$("body").on("scroll", function () {
    //set scroll position in session storage
    sessionStorage.scrollPos = $(window).scrollTop();
});
var init = function () {
    //get scroll position in session storage
    $("body").scrollTop(sessionStorage.scrollPos || 0)
};
window.onload = init;


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var hash = $(e.target).attr('href');
  if (history.pushState) {
    history.pushState(null, null, hash);
  } else {
    location.hash = hash;
  }
});

var hash = window.location.hash;
if (hash) {
  $('.nav-link[href="' + hash + '"]').tab('show');
}