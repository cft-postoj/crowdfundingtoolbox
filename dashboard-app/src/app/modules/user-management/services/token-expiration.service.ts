import {EventEmitter, Injectable, Output} from '@angular/core';
import {AuthenticationService} from "./authentication.service";

@Injectable({
    providedIn: 'root'
})
export class TokenExpirationService {

    @Output()
    public expirationEmitter: EventEmitter<any> = new EventEmitter();

    constructor(private authenticationService: AuthenticationService) {
    }

    expiration() {
        let exp = this.authenticationService.getTokenExpirationNumber(localStorage.getItem('token'));
        let current = Math.round((new Date().getTime() / 1000));
        let timeout = (exp - current - 3600) * 1000; // timeout in miliseconds minus one hour
        timeout = (timeout < 0) ? 3000 : timeout + 3000; // if expiration is lower than one hour + three seconds
        setTimeout(() => {
            this.expirationEmitter.emit(true);
        }, timeout);
        this.expirationEmitter.emit(false);
    }

}
