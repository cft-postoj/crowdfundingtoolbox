<h2>Účet</h2>

<div class="cft--alert active error">

</div>

<form name="cft-myAccountDetails">
    <h3 class="cft--mt-25 cft--mb-25">Vaše údaje</h3>
    <div class="cft--formBox">
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-firstName">
                    MENO
                </label>
                <input type="text" name="cft-firstName" id="cft-firstName" class="cft--input"/>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-email">
                    E-MAIL
                </label>
                <input type="email" name="cft-email" id="cft-email" class="cft--input"/>
            </div>
        </div>

        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-lastName">
                    PRIEZVISKO
                </label>
                <input type="text" name="cft-lastName" id="cft-lastName" class="cft--input"/>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-password">
                    HESLO
                </label>
                <input type="password" name="cft-password" id="cft-password" class="cft--input"/>
            </div>
        </div>

        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-telephone">
                    TELEFÓN
                </label>
                <div class="cft--grid--row">
                    <div class="cft--grid--lg-4 withoutPadding-lg">
                        <select name="cft-telephone-prefix"
                                class="cft--select cft--border-right-none cft--border-radius-right-none"></select>
                    </div>
                    <div class="cft--grid--lg-8 withoutPadding-lg">
                        <input type="text" name="cft-telephone" id="cft-telephone"
                               class="cft--input cft--border-radius-left-none"/>
                    </div>
                </div>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-mailing" class="checkbox cft--checkbox cft--mt-25 cft--font-weight-bolder">
                    <input type="checkbox" name="cft-mailing" id="cft-mailing" class="cft--input"/>
                    <span class="checkmark"></span>
                    Súhlasím s posielaním newslettrov z Postoja.
                </label>
                <label for="cft-agree" class="checkbox cft--checkbox cft--font-weight-bolder">
                    <input type="checkbox" name="cft-agree" id="cft-agree" class="cft--input"/>
                    <span class="checkmark"></span>
                    Súhlasím so spracovaním osobných údajov.
                </label>
            </div>
        </div>
    </div>

    <h3 class="cft--mt-25 cft--mb-25">Adresa</h3>
    <div class="cft--formBox">
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <div class="cft--grid--row">
                    <div class="cft--grid--lg-8">
                        <label for="cft-street">
                            ULICA
                        </label>
                        <input type="text" name="cft-street" id="cft-street" class="cft--input"/>
                    </div>
                    <div class="cft--grid--lg-4 withoutPadding-lg">
                        <label for="cft-house-number">
                            ČÍSLO
                        </label>
                        <input type="text" name="cft-house-number" id="cft-house-number" class="cft--input"/>
                    </div>
                </div>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-country">
                    KRAJINA
                </label>
                <select name="cft-country" id="cft-country" class="cft--select"></select>
            </div>
        </div>
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <div class="cft--grid--row">
                    <div class="cft--grid--lg-8">
                        <label for="cft-city">
                            MESTO
                        </label>
                        <input type="text" name="cft-city" id="cft-city" class="cft--input"/>
                    </div>
                    <div class="cft--grid--lg-4 withoutPadding-lg">
                        <label for="cft-zip">
                            PSČ
                        </label>
                        <input type="text" name="cft-zip" id="cft-zip" class="cft--input"/>
                    </div>
                </div>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-deliveryAddressSame" class="checkbox cft--checkbox cft--mt-30 cft--font-weight-bolder">
                    <input type="checkbox" name="cft-deliveryAddressSame" id="cft-deliveryAddressSame" checked
                           class="cft--input"/>
                    <span class="checkmark"></span>
                    Dodacie údaje sú rovnaké ako fakturačné údaje.
                </label>
            </div>
        </div>
    </div>

    <div class="cft--grid--row cft--mt-30">
        <button type="submit" class="cft--submitButton">POTVRDIŤ</button>
    </div>

    <div class="cft--grid--row cft--mt-50">
        <button type="button" class="cft--button" id="cft--logout">
            Odhlásiť sa
        </button>
    </div>
</form>