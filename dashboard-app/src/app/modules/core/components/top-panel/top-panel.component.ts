import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {environment} from "../../../../../environments/environment";
import {AuthenticationService} from "../../../user-management/services";

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

    constructor(private router: Router, private authService: AuthenticationService) {
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
}
