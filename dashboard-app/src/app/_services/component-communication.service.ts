import {Injectable} from '@angular/core';
import {BehaviorSubject} from "rxjs";

@Injectable({
    providedIn: 'root'
})
export class ComponentCommunicationService {

    logoutMessage = "";

    alert = new BehaviorSubject("");

    constructor() {
    }


    setAlertMessage(message: string) {
        this.alert.next(message)
    }


    setLogoutMessage(msg: string) {
        this.logoutMessage = msg;
    }

    getLogoutMessage() {
        return this.logoutMessage;
    }
}
