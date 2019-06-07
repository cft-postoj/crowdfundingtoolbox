<button type="button" id="cft--loginButton" class="cft--loginButton">Prihlásiť sa</button>
<div class="cft--loginDropdown">
    <form name="cft-login">
        <label for="cft-email">
            E-MAIL
        </label>
        <input type="email" id="cft-email" name="cft-email" class="error" required>
        <span class="cft--loginDropdown--error cft-email active">Nesprávny e-mail. Nemáte ešte registráciu?<br/>
            <a href="http://registracia.postoj.local:8000" target="_blank">Registrujte sa</a>.</span>
        <label for="cft-password">
            HESLO
        </label>
        <input type="password" id="cft-password" name="cft-password" required>
        <span class="cft--loginDropdown--error cft-password"></span>
        <button type="submit">Prihlásiť sa</button>
    </form>
    <div class="cft--loginDropdown--register">
        <b>Nie ste ešte registrovaný?</b>
        <p>Ukladajte si články, spravujte newslettre, získajte prehľad objednávok z eshopu...</p>
        <a href="http://registracia.postoj.local:8000" target="_blank">
            Registrovať sa
        </a>
    </div>
</div>
<button type="button" id="cft--myAccountButton" class="cft--myAccountButton" style="display: none">My account</button>

