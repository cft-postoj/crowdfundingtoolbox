import {getRequest, setTokenHeader} from "../helpers";
import {apiUrl} from "../constants/url";

export function previewInit() {
    getBasicUserData();
}

function getBasicUserData() {
    const data = getRequest(apiUrl + 'base-user-data', setTokenHeader([]));
    if (data !== null) {
        let firstName = (data.first_name === null) ? '' : data.first_name;
        let lastName = (data.last_name === null) ? '' : data.last_name;
        document.querySelector('#cft--myaccount .cft--myAccount--preview--user').innerHTML = firstName + ' ' + lastName;
        document.querySelector('#cft--myaccount .cft--myAccount--preview--username').innerHTML = data.username;
    }
}