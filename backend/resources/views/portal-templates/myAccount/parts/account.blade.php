<h2>Your account</h2>

<div class="cft--alert active error">

</div>

<form name="cft-myAccountDetails">
    <h3 class="cft--mt-25 cft--mb-25">Your details</h3>
    <div class="cft--formBox">
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-firstName">
                    FIRST NAME
                </label>
                <input type="text" name="cft-firstName" id="cft-firstName" class="cft--input"/>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-email">
                    EMAIL
                </label>
                <input type="email" name="cft-email" id="cft-email" class="cft--input"/>
            </div>
        </div>

        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-lastName">
                    LAST NAME
                </label>
                <input type="text" name="cft-lastName" id="cft-lastName" class="cft--input"/>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-password">
                    PASSWORD
                </label>
                <input type="password" name="cft-password" id="cft-password" class="cft--input"/>
            </div>
        </div>

        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-telephone">
                    TELEPHONE
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
                    I agree to receive newsletters.
                </label>
                <label for="cft-agree" class="checkbox cft--checkbox cft--font-weight-bolder">
                    <input type="checkbox" name="cft-agree" id="cft-agree" class="cft--input"/>
                    <span class="checkmark"></span>
                    I agree with general conditions.
                </label>
            </div>
        </div>
    </div>

    <h3 class="cft--mt-25 cft--mb-25">Address</h3>
    <div class="cft--formBox">
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <div class="cft--grid--row">
                    <div class="cft--grid--lg-8">
                        <label for="cft-street">
                            STREET
                        </label>
                        <input type="text" name="cft-street" id="cft-street" class="cft--input"/>
                    </div>
                    <div class="cft--grid--lg-4 withoutPadding-lg">
                        <label for="cft-house-number">
                            NUMBER
                        </label>
                        <input type="text" name="cft-house-number" id="cft-house-number" class="cft--input"/>
                    </div>
                </div>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <label for="cft-country">
                    COUNTRY
                </label>
                <select name="cft-country" id="cft-country" class="cft--select"></select>
            </div>
        </div>
        <div class="cft--grid--row">
            <div class="cft--grid--lg-6 cft--grid--sm-12">
                <div class="cft--grid--row">
                    <div class="cft--grid--lg-8">
                        <label for="cft-city">
                            CITY
                        </label>
                        <input type="text" name="cft-city" id="cft-city" class="cft--input"/>
                    </div>
                    <div class="cft--grid--lg-4 withoutPadding-lg">
                        <label for="cft-zip">
                            ZIP
                        </label>
                        <input type="text" name="cft-zip" id="cft-zip" class="cft--input"/>
                    </div>
                </div>
            </div>
            <div class="cft--grid--lg-6 cft--grid--sm-12"></div>
        </div>
    </div>

    <div class="cft--grid--row cft--mt-30">
        <button type="submit" class="cft--submitButton">SUBMIT</button>
    </div>

    <div class="cft--grid--row cft--mt-50">
        <button type="button" class="cft--button" id="cft--logout">
            Logout
        </button>
    </div>
</form>