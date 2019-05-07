<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>

        <script>
            $.ajax({
                type: 'GET',
                url: 'http://localhost/crowdfundingToolbox/public/api/backoffice/dashboard',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImJlYTAwM2U0MzI3ODRlODgyMjk2OTFkODhkOWU2OWMwNDgyOGNhYzgyZDBlZmVhNzNlNWUxZTg1NjVkOWJhN2QyZDdiOTVlMzljNDFiNjAzIn0.eyJhdWQiOiIxIiwianRpIjoiYmVhMDAzZTQzMjc4NGU4ODIyOTY5MWQ4OGQ5ZTY5YzA0ODI4Y2FjODJkMGVmZWE3M2U1ZTFlODU2NWQ5YmE3ZDJkN2I5NWUzOWM0MWI2MDMiLCJpYXQiOjE1NDM5MjczMDYsIm5iZiI6MTU0MzkyNzMwNiwiZXhwIjoxNTc1NDYzMzA2LCJzdWIiOiIiLCJzY29wZXMiOltdfQ.p4tmRuknSQl21towkcZjbL2mJWWKyjG7OpLS6FnJBuL7n35coFPqproUt0qdWhtjSXU-G7z_IvgX5fcHWyUC8Jhxw5Ti89IJbfBFXQNrKLKPkwqKVz763qweuxwt7pGKOtU44HSBZdZ0ULDcHm20LDN09fLtcbP4skTr1415mC8gzEL3zt1mXtKi9fs0bO4I4Rldy9sKWUQhlCLbnhe_-MSac2mziqGIVpQauADjbkS9uiGHAEogMKiMqNdYIUnM0T9kdNlnLfrcAAcP0cP0AGJlHd0hbWT0xboXdi6XaR0EEfdU1NqnRS59g98XgfTi6hr7mfm_-AoKLN10aUyJ0bAFwxeu3RPFV_4udd8m-8IsGfcpXJcRfA6dHn4hU_vLQRuvKpbOvFKEKFBE0V0x9c1IQ3Nv1tTbhaTIJs67AeYONyU1GhgFjLi9Mb38HIaRm-VU6bBDKPqmkG30dYA2vzAOW-4tudzoI4KGMcP1cMoVz1CdKsuQu1C33e52mfGSnyxxwK1E9ky-C2b-JMif5Izkq4OYiv2b3A9qeac7ySdEA1DEQ14J--CdmSspCOXWPSS9CQN3MmZWzvdCJC50BaA014TLWUoF_lG_6wgDJGmkQr9MYUX5IKYdeFBeZif5U-NCHCP-pRvJT_T3zRU9M0yQ9YYyvzhjcrRQGdTg29k'
                },
                success: function(data) {
                    console.log(data)
                }
            })
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
