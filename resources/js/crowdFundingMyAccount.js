import {formSerialize, getJsonFirstProp, portalUrl} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from "./json/myAccount";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('cft--myaccount') !== null)
        fetchMyAccountTemplate();
});

function fetchMyAccountTemplate() {

}