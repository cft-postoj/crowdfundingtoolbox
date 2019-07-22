import {Component, OnInit, HostListener, ElementRef} from '@angular/core';
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
    public adminPanelActive: boolean = false;

    public isUserSettingsPage: boolean;

    constructor(private router: Router, private authService: AuthenticationService, private eRef: ElementRef) {
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

    @HostListener('document:click', ['$event'])
    clickOut(event) {
        if (!this.eRef.nativeElement.contains(event.target)) {
            this.adminPanelActive = false;
        }
    }

    public logout(): void {
        this.adminPanelActive = false;
        this.authService.logout(() =>
            this.router.navigate([this.router.navigateByUrl(environment.login)])
        );
    }

    public userSettings() {
        this.adminPanelActive = false;
        this.router.navigateByUrl(Routing.DASHBOARD + '/' + Routing.USER_SETTINGS);
    }

    public showHome() {
        this.adminPanelActive = false;
        this.router.navigateByUrl(Routing.DASHBOARD + '/' + Routing.STATS);
    }

    public showAdminPanel() {
        this.adminPanelActive = !this.adminPanelActive;
    }
}
