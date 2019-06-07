<div class="cft--register">
    <h1>Registrácia</h1>
    <form name="cft-register">
        <label for="cft-email">E-MAIL
        <input type="email" name="cft-email" id="cft-email" required/>
        </label>
        <label for="cft-password">HESLO
        <input type="password" name="cft-password" id="cft-password" required/>
        <img src="http://127.0.0.1:8001/images/visible.svg" />
        </label>

        <div class="cft--register--checkbox">
            <label for="cft-mailing" class="checkbox">
                <input type="checkbox" name="cft-mailing" id="cft-mailing">
                <span class="checkmark"></span>
                Súhlasím s posielaním mailov z Postoja.
            </label>
        </div>

        <div class="cft--register--checkbox">
            <label for="cft-agree" class="checkbox">
                <input type="checkbox" name="cft-agree" id="cft-agree">
                <span class="checkmark"></span>
                Súhlasím so spracovaním <a href="#">osobných údajov</a>.
            </label>
        </div>

        <button type="submit">
            Registrovať sa
        </button>
    </form>
</div>