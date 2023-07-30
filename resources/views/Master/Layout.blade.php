<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  
<!-- Mirrored from prium.github.io/phoenix/v1.13.0/pages/authentication/simple/sign-up.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Jul 2023 11:17:40 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('tit')</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
   <!-- <link rel="apple-touch-icon" sizes="180x180" href="">
    <link rel="icon" type="image/png" sizes="32x32" href=>
    <link rel="icon" type="image/png" sizes="16x16" href= >
    <link rel="shortcut icon" type="image/x-icon" href="../../../assets/img/favicons/favicon.ico">-->
    <link rel="manifest" href="{{asset('assets/img/favicons/manifest.json')}}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{asset('vendors/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('vendors/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{asset('vendors/dhtmlx-gantt/dhtmlxgantt.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/flatpickr/flatpickr.min.css')}}" rel="stylesheet" />
    <link href="{{asset('vendors/choices/choices.min.css')}}" rel="stylesheet">
    <link href="{{asset('Other/fonts.googleapis.com/css275fb.css?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap')}}" rel="stylesheet">
    <link href="{{asset('vendors/simplebar/simplebar.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('Other/unicons.iconscout.com/release/v4.0.8/css/line.css')}}">
    <link href="{{asset('assets/css/theme-rtl.min.css')}}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{asset('assets/css/theme.min.css')}}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{asset('assets/css/user-rtl.min.css')}}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{asset('assets/css/user.min.css')}}" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="{{asset('assets/css/timeline.css')}}" type="text/css" rel="stylesheet">

    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>

  <body>
    @yield('content')
    <script src="{{asset('vendors/popper/popper.min.js')}}"></script>
    <script src="{{asset('vendors/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/anchorjs/anchor.min.js')}}"></script>
    <script src="{{asset('vendors/is/is.min.js')}}"></script>
    <script src="{{asset('vendors/fontawesome/all.min.js')}}"></script>
    <script src="{{asset('vendors/lodash/lodash.min.js')}}"></script>
    <script src="{{asset('Other/polyfill.io/v3/polyfill.min58be.js?features=window.scroll')}}"></script>
    <script src="{{asset('vendors/list.js/list.min.js')}}"></script>
    <script src="{{asset('vendors/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('vendors/dayjs/dayjs.min.js')}}"></script>
    <script src="{{asset('vendors/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('vendors/choices/choices.min.js')}}"></script>
    <script src="{{asset('vendors/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('vendors/dhtmlx-gantt/dhtmlxgantt.js')}}"></script>

    <script src="{{asset('assets/js/phoenix.js')}}"></script>
    <script src="{{asset('assets/js/projectmanagement-dashboard.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script src="{{asset('assets/js/all.js')}}"></script>

  </body>
  
</html>