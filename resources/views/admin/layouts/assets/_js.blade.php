<script src="{{asset('admin')}}/js/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{asset('admin')}}/js/bootstrap.min.js"></script>
<script src="{{asset('admin')}}/js/bootstrap.bundle.min.js"></script>
<!-- apps -->
<script src="{{asset('admin')}}/js/app.min.js"></script>
<script src="{{asset('admin')}}/js/app.init.minimal.js"></script>
<script src="{{asset('admin')}}/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{asset('admin')}}/js/perfect-scrollbar.jquery.min.js"></script>
<script src="{{asset('admin')}}/js/sparkline.js"></script>
<!--Wave Effects -->
<script src="{{asset('admin')}}/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{asset('admin')}}/js/sidebarmenu.js"></script>
<!-- font awesome  -->
<script src="{{asset('admin')}}/js/fontawesome-pro.js"></script>
<!--Custom JavaScript -->
<script src="{{asset('admin')}}/js/feather.min.js"></script>
<script src="{{asset('admin')}}/js/custom.min.js"></script>
<!--This page JavaScript -->
<script src="{{asset('admin')}}/js/apexcharts.min.js"></script>
<!-- Vector map JavaScript -->
<script src="{{asset('admin')}}/js/jquery-jvectormap.min.js"></script>
<script src="{{asset('admin')}}/js/jquery-jvectormap-us-aea-en.js"></script>
<!-- Chart JS -->
<script src="{{asset('admin')}}/js/dashboard3.js"></script>

<script src="{{asset('admin')}}/js/poppe r.min.js"></script>
<script src="{{asset('admin')}}/js/smooth-scroll.min.js"></script>
<script src="{{asset('admin')}}/js/swiper.js"></script>
<script src="{{asset('admin')}}/js/aos.js"></script>
<script src="{{asset('admin')}}/js/dropify.min.js"></script>
<script src="{{asset('admin')}}/js/jquery.appear.min.js"></script>
<script src="{{asset('admin')}}/js/odometer.min.js"></script>
<script src="{{asset('admin')}}/js/jquery.fancybox.min.js"></script>
<script src="{{asset('admin')}}/js/select2.js"></script>
<script src="{{asset('admin')}}/js/stars.js"></script>
<script src="{{asset('admin')}}/js/main.js"></script>

<script src="{{asset('admin/backEndFiles/jquery.easing.1.3.js')}}"></script>
<script src="{{asset('admin/backEndFiles')}}/notify/notify.js"></script>

<script src="{{asset('admin/backEndFiles/validation/jquery.form-validator.js')}}"></script>
<script src="{{asset('admin/backEndFiles/validation/toastr.min.js')}}"></script>
<script src="{{asset('admin/backEndFiles/axios.min.js')}}"></script>
<script src="{{asset('admin/backEndFiles/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admin/backEndFiles/plugins/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{asset('admin/backEndFiles/easyNotify.js')}}"></script>



<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    alertify.defaults = {
        // dialogs defaults
        autoReset:true,
        basic:false,
        closable:true,
        closableByDimmer:true,
        invokeOnCloseOff:false,
        frameless:false,
        defaultFocusOff:false,
        maintainFocus:true, // <== global default not per instance, applies to all dialogs
        maximizable:true,
        modal:true,
        movable:true,
        moveBounded:false,
        overflow:true,
        padding: true,
        pinnable:true,
        pinned:true,
        preventBodyShift:false, // <== global default not per instance, applies to all dialogs
        resizable:true,
        startMaximized:false,
        transition:'pulse',
        transitionOff:false,
        tabbable:'button:not(:disabled):not(.ajs-reset),[href]:not(:disabled):not(.ajs-reset),input:not(:disabled):not(.ajs-reset),select:not(:disabled):not(.ajs-reset),textarea:not(:disabled):not(.ajs-reset),[tabindex]:not([tabindex^="-"]):not(:disabled):not(.ajs-reset)',  // <== global default not per instance, applies to all dialogs

        // notifier defaults
        notifier:{
            // auto-dismiss wait time (in seconds)
            delay:5,
            // default position
            position:'bottom-right',
            // adds a close button to notifier messages
            closeButton: false,
            // provides the ability to rename notifier classes
            classes : {
                base: 'alertify-notifier',
                prefix:'ajs-',
                message: 'ajs-message',
                top: 'ajs-top',
                right: 'ajs-right',
                bottom: 'ajs-bottom',
                left: 'ajs-left',
                center: 'ajs-center',
                visible: 'ajs-visible',
                hidden: 'ajs-hidden',
                close: 'ajs-close'
            }
        },

        // language resources
        glossary:{
            // dialogs default title
            title:'AlertifyJS',
            // ok button text
            ok: 'OK',
            // cancel button text
            cancel: 'Cancel'
        },

        // theme settings
        theme:{
            // class name attached to prompt dialog input textbox.
            input:'ajs-input',
            // class name attached to ok button
            ok:'ajs-ok',
            // class name attached to cancel button
            cancel:'ajs-cancel'
        },
        // global hooks
        hooks:{
            // invoked before initializing any dialog
            preinit:function(instance){},
            // invoked after initializing any dialog
            postinit:function(instance){},
        },
    };
</script>
<script>
    function myToast(heading, text, position, loaderBg, icon, hideAfter, stack) {
        "use strict";
        $.toast({
            heading: heading,
            text: text,
            position: position,
            loaderBg: loaderBg,
            icon: icon,
            hideAfter: hideAfter,
            stack: stack
        });
    }
    //for input number validation
    $(document).on('keyup','.numbersOnly',function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    window.addEventListener('online', () =>{
        window.location.reload();
        myToast(' عادت خدمة الانترنت ! !','تنبيه','buttom-left', '#ff6849', 'success',4000, 2)
        alertify.success('عادت خدمة الانترنت !');
    });
    window.addEventListener('offline', () =>{
        myToast('لا يوجد خدمة انترنت !','تنبيه !', 'buttom-left', '#ff6849', 'error',4000, 2)
        alertify.error('لا يوجد خدمة انترنت !');
    });


    $(window).bind("pageshow", function(event) {
        if (event.originalEvent.persisted) {
            window.location.reload();
        }
    });


    $(function() {
        $('a[href]').attr('href', function(index, href) {
            var param = 'key=' + Math.floor(Math.random()*100000);

            if (href.charAt(href.length - 1) === '?') //Very unlikely
                return href + param;
            else if (href.indexOf('?') > 0)
                return href + '&' + param;
            else
                return href + '?' + param;
        });
    })


    addParameterToURL('basicUrl='+Math.floor(Math.random() * (999999 - 11111) ) + 11111)
    function addParameterToURL(param){
        _url = location.href;
        var url = new URL(_url);
        var c = url.searchParams.get("basicUrl");
        if (!c){
            _url += (_url.split('?')[1] ? '&':'?') + param;
            window.history.pushState({page: "another"}, "another page", _url);
        }
    }
</script>

<script>
    //****************************
    /* Header position */
    //****************************

    Number.prototype.round = function(places) {
        return +(Math.round(this + "e+" + places)  + "e-" + places);
    }
</script>
