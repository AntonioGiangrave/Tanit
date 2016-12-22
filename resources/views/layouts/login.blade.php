<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8"/>
        <title>Kairosformazione</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="Kairos"/>
        <meta content="" name="Antonio Giangravè"/>

        <link rel="stylesheet"href="//codeorigin.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

        <link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
    </head>
    <body>

        @yield('body')



        <script>var APP_URL = {{ json_encode(url('/')) }} ;
        
        </script>
        <script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
        <script src="//codeorigin.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

        @yield('script')

    </body>
</html>