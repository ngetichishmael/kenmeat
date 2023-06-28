<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Deveint">
    <title>@yield('title') - sokoflow</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <!-- BEGIN: Theme CSS-->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/core.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/vertical-menu.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/base/core/colors/palette-gradient.css') }}"> -->

    <link rel="stylesheet" href="{{ asset('css/base/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base/pages/page-auth.css') }}">

    <link rel="stylesheet" href="{{ asset('css/overrides.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <style>
    /* Custom CSS for responsive design */
    /* Styles for devices with a maximum width of 767px (e.g., mobile phones) */
    @media (max-width: 767px) {
        /* Adjust the logo size and padding */
        .brand-logo {
            padding: 20px;
            max-width: 150px;
            margin: 0 auto;
        }

        /* Center align the login form */
        .auth-inner {
            justify-content: center;
        }

        /* Reduce the card padding */
        .auth-bg {
            padding: 2rem;
        }
    }

    /* Styles for devices with a minimum width of 768px and maximum width of 1199px (e.g., tablets) */
    @media (min-width: 768px) and (max-width: 1199px) {
        /* Adjust the logo size and padding */
        .brand-logo {
            padding: 30px;
            max-width: 200px;
        }
    }

    /* Styles for devices with a minimum width of 1200px (e.g., desktops) */
    @media (min-width: 1200px) {
        /* Increase the card width */
        .auth-bg {
            max-width: 500px;
        }
    }
</style>
    @yield('stylesheets')

  
    <!-- END: Custom CSS-->
    @livewireStyles
   
</head>


