<div class="cft--register">
    <h1>Registrácia</h1>
    <form name="cft-register">
        <label for="cft-email">E-MAIL
        <input type="email" name="cft-email" id="cft-email" required/>
        </label>
        <span class="cft--loginDropdown--error cft-email"></span>
        <label for="cft-password">HESLO
        <input type="password" name="cft-password" id="cft-password" data-lpignore="true" required/>
        <img src="{{env('ASSETS_URL')}}/images/visible.svg" />
        </label>
        <span class="cft--loginDropdown--error cft-password"></span>

        <div class="cft--register--checkbox">
            <label for="cft-mailing" class="checkbox">
                <input type="checkbox" name="cft-mailing" id="cft-mailing">
                <span class="checkmark"></span>
                Súhlasím s posielaním mailov z Postoja.
            </label>
        </div>

        <div class="cft--register--checkbox">
            <label for="cft-agree" class="checkbox">
                <input type="checkbox" name="cft-agree" id="cft-agree" required>
                <span class="checkmark"></span>
                Súhlasím so spracovaním <a href="#">osobných údajov</a>.
            </label>
        </div>
        <span class="cft--loginDropdown--error cft-agree"></span>
        <span class="cft--loginDropdown--success cft-register"></span>

        <button type="submit">
            Registrovať sa
        </button>
    </form>
</div>