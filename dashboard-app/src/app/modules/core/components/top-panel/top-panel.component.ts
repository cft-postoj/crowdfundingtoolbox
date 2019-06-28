import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {environment} from "../../../../../environments/environment";
import {AuthenticationService} from "../../../user-management/services";
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-top-panel',
    templateUrl: './top-panel.component.html',
    styleUrls: ['./top-panel.component.scss']
})
export class TopPanelComponent implements OnInit {
    public firstName: string;
    public lastName: string;
    public signature: string;
    public role: string;

    public isUserSettingsPage: boolean;

    constructor(private router: Router, private authService: AuthenticationService) {
        router.events.subscribe((val) => {
            this.isUserSettingsPage = false;
            if (this.router.url.indexOf('/dashboard/user-settings') > -1) {
                this.isUserSettingsPage = true;
            }
            this.firstName = localStorage.getItem('user_firstName');
            this.lastName = localStorage.getItem('user_lastName');
        });
    }

    ngOnInit() {
        if (localStorage.getItem('token')) {
            this.firstName = localStorage.getItem('user_firstName');
            this.lastName = localStorage.getItem('user_lastName');
            this.signature = this.firstName.slice(0, 1).toUpperCase() +
                this.lastName.slice(0, 1).toUpperCase();
            this.role = localStorage.getItem('user_role');
        }
    }

    public logout(): void {
        this.authService.logout(() =>
            this.router.navigate([this.router.navigateByUrl(environment.login)])
        );
    }

    public userSettings() {
        this.router.navigateByUrl(Routing.DASHBOARD + '/' + Routing.USER_SETTINGS);
    }
}
