import {getRequest, setTokenHeader} from "../helpers";
import {apiUrl} from "../constants/url";

export function previewInit() {
    getBasicUserData();
}

function getBasicUserData() {
    const data = getRequest(apiUrl + 'base-user-data', setTokenHeader([]));
    if (data !== null) {
        document.querySelector('#cft--myaccount .cft--myAccount--preview--user').innerHTML = data.first_name + ' ' + data.last_name;
        document.querySelector('#cft--myaccount .cft--myAccount--preview--username').innerHTML = data.username;
    }
}