<meta name="cft-csrf-token" content="{{ csrf_token() }}">
<button type="button" id="cft--loginButton" class="cft--loginButton">Sign in</button>
<div class="cft--loginDropdown">
    <form name="cft-forgottenPassword">
        <h3>Forgotten password</h3>
        <label for="cft-emailPassword">
            E-MAIL
        </label>
        <input type="email" id="cft-emailPassword" name="cft-email" class="" required>
        <span class="cft--loginDropdown--message cft-email"></span>
        <button type="submit">Reset password</button>
        <button type="button" id="cft--showLogin">Login</button>
    </form>
    <form name="cft-login" class="active">
        <label for="cft-email">
            EMAIL
        </label>
        <input type="email" id="cft-email" name="cft-email" class="" required>
        <span class="cft--loginDropdown--message cft-email"></span>
        <label for="cft-password">
            PASSWORD <button type="button" id="cft--forgottenPassword">Forgot your password?</button>
        </label>
        <input type="password" id="cft-password" name="cft-password" class="" required>
        <span class="cft--loginDropdown--message cft-password"></span>
        <button type="submit">Sign in</button>
    </form>
    <div class="cft--loginDropdown--register">
        <b>Not registered yet?</b>
        <p>Lorem ipsum some sign in text...</p>
        <a href="{{env('CFT_PORTAL_REGISTER_URL')}}" target="_blank">
            Register
        </a>
    </div>
</div>
<button type="button" id="cft--myAccountButton" class="cft--myAccountButton" style="display: none">My account</button>

