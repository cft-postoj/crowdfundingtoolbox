<button type="button">Login</button>

<div class="cftLogin">
    <link rel="stylesheet" href="../css/app.css?v={{time()}}">
    <div class="cftLogin--login">
        <form name="cftLogin--login--form">
            <input name="email" type="email" placeholder="E-mail" />
            <input name="password" type="password" placeholder="Password" />
            <button type="submit">Sign in</button>
        </form>
    </div>
    <div class="cftLogin--register">
        <form name="cftLogin--register--form">
            <input type="text" name="firstName" placeholder="First name" />
            <input type="text" name="lastName" placeholder="Last name" />
            <input type="email" name="email" placeholder="E-mail" />
            <input type="password" name="password" placeholder="Password" />
            <input type="password" name="re-password" placeholder="Repeat your password" />
            <button type="submit">Sign out</button>
        </form>
    </div>
    <div class="cftLogin--google">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </div>
    <div class="cftLogin--facebook">
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '405494056672631',
                    cookie     : true,
                    xfbml      : true,
                    version    : 'v2.8'
                });

                FB.AppEvents.logPageView();

            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));


        </script>
        <fb:login-button
            scope="public_profile,email"
            onlogin="checkLoginState();">
        </fb:login-button>
    </div>
</div>
