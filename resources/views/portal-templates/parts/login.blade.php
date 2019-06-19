<button type="button" id="cft--loginButton" class="cft--loginButton">Prihlásiť sa</button>
<div class="cft--loginDropdown">
    <form name="cft-forgottenPassword">
        <h3>Zabudnuté heslo</h3>
        <label for="cft-emailPassword">
            E-MAIL
        </label>
        <input type="email" id="cft-emailPassword" name="cft-email" class="" required>
        <span class="cft--loginDropdown--message cft-email"></span>
        <button type="submit">Reset hesla</button>
        <button type="button" id="cft--showLogin">Prihlásiť sa</button>
    </form>
    <form name="cft-login" class="active">
        <label for="cft-email">
            E-MAIL
        </label>
        <input type="email" id="cft-email" name="cft-email" class="" required>
        <span class="cft--loginDropdown--message cft-email"></span>
        <label for="cft-password">
            HESLO <button type="button" id="cft--forgottenPassword">Zabudli ste heslo?</button>
        </label>
        <input type="password" id="cft-password" name="cft-password" class="" required>
        <span class="cft--loginDropdown--message cft-password"></span>
        <button type="submit">Prihlásiť sa</button>
    </form>
    <div class="cft--loginDropdown--register">
        <b>Nie ste ešte registrovaný?</b>
        <p>Ukladajte si články, spravujte newslettre, získajte prehľad objednávok z eshopu...</p>
        <a href="{{$portal_register_url}}" target="_blank">
            Registrovať sa
        </a>
    </div>
</div>
<button type="button" id="cft--myAccountButton" class="cft--myAccountButton" style="display: none">My account</button>

