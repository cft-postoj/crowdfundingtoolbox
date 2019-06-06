<!-- TODO -- remove scripts. Scripts will be in one external file on portal side. -->
{{--<script src="{{ mix('js/app.js') }}"></script>--}}

<button type="button" id="cft--loginButton" class="cft--loginButton">Login</button>
<div class="cft--loginDropdown">
    <form name="cft-login">
        <label for="cft-email">
            E-MAIL
        </label>
        <input type="email" id="cft-email" name="cft-email" required>
        <span class="cft--loginDropdown--error cft-email"></span>
        <label for="cft-password">
            PASSWORD
        </label>
        <input type="password" id="cft-password" name="cft-password" required>
        <button type="submit">Sign in</button>
    </form>
</div>
<button type="button" id="cft--myAccountButton" class="cft--myAccountButton" style="display: none">My account</button>

<div class="cftLogin--cftLoginWrapper" style="display: none">
    <div class="cftLogin--cftLoginWrapper--content">
        <h2>Welcome back</h2>
        <p>Sign in our portal and use all benefits</p>
        <div class="cftLogin--cftLoginWrapper--content--login">
            <h3>Sign in here</h3>
            <form name="cftLogin--login--form">
                <input name="email" type="email" placeholder="E-mail"/>
                <input name="password" type="password" placeholder="Password"/>
                <button type="submit">Sign in</button>
                or make easy registration
                <button type="button" class="cftLogin--cftLoginWrapper--content--button">here</button>
                <button type="button" class="cftLogin--cftLoginWrapper--content--button forgotPassword">Forgot
                    password?
                </button>
            </form>
        </div>
        <div class="cftLogin--cftLoginWrapper--content--register">
            <h3>Register now</h3>
            <form name="cftLogin--register--form">
                <input type="text" name="firstName" placeholder="First name"/>
                <input type="text" name="lastName" placeholder="Last name"/>
                <input type="email" name="email" placeholder="E-mail"/>
                <input type="password" name="password" placeholder="Password"/>
                <input type="password" name="confirmation_password" placeholder="Repeat your password"/>
                <button type="submit">Sign out</button>
                or sign in
                <button type="button" class="cftLogin--cftLoginWrapper--content--button">here</button>
            </form>
        </div>
        <div class="cftLogin--cftLoginWrapper--content--forgotPassword">
            <h3>Forgot your password?</h3>
            <p>Don't worry. You can reset it here.</p>
            <form name="cftLogin--forgotPassword--form">
                <input type="email" name="email" placeholder="E-mail"/>
                <button type="submit">Reset password</button>
                <button type="button" class="cftLogin--cftLoginWrapper--content--button login">sign in</button>
                or
                <button type="button" class="cftLogin--cftLoginWrapper--content--button register">register</button>

            </form>
        </div>
        <span class="cft--alert" title="Close message"></span>
    </div>
</div>
