import {Injectable} from '@angular/core';
import {ActivatedRouteSnapshot, CanActivate, CanActivateChild, Router, RouterStateSnapshot} from '@angular/router';
import {AuthenticationService} from "./authentication.service";
import {ComponentCommunicationService} from "../../core/services";
import {environment} from "../../../../environments/environment";


@Injectable({providedIn: 'root'})
export class LoginGuard implements CanActivate, CanActivateChild {

    constructor(
        private router: Router,
        private authService: AuthenticationService,
        private compComService: ComponentCommunicationService
    ) {
    }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        return this.canActivateDashboard();
    }

    canActivateChild(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        return this.canActivateDashboard();
    }

    canActivateDashboard(): boolean {
        if (!this.authService.getToken()) {
            this.router.navigateByUrl(environment.login);
            return false;
        }
        if (this.authService.isTokenExpired()) {
            this.compComService.setLogoutMessage("Token expired, please log in again.")
            this.router.navigate([environment.login]);
            return false;
        }
        return true;
    }
}
