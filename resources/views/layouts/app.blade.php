<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <title>Astroaquila</title> --}}
    {{-- <script type='text/javascript'
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5f86e8ab530ee50014b84819&product=sop'
        async='async'></script> --}}
        <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=60a69f563275e800182051bf&product=sop'
            async='async'></script>
    @yield('title','Home')

    @yield('style')




</head>

<body>


        @yield('header')
        @yield('body')
        @yield('footer')


    @yield('script')
</body>

</html>
