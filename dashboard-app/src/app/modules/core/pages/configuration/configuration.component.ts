import {Component, Input, OnInit} from '@angular/core';
import { Router } from '@angular/router';
import {Routing} from "../../../../constants/config.constants";
import {UserService} from '../../../user-management/services';

@Component({
    selector: 'app-configuration',
    templateUrl: 'configuration.component.html',
    styleUrls: ['configuration.component.scss']
})
export class ConfigurationComponent implements OnInit{
    public routing = Routing;
    public isAdmin: boolean = false;
    public loading: boolean = true;

    constructor(private router: Router, private userService: UserService) { }

    ngOnInit() {
        this.userService.getUserDetail().subscribe((data) => {
            this.isAdmin = (data.role_id === 1);
            this.loading = false;
        });
    }

    openGlobal() {
        this.router.navigateByUrl(`${Routing.CONFIGURATION_FULL_PATH}/(${Routing.RIGHT_OUTLET}:${Routing.GENERAL})`);
    }

    openCta() {
        this.router.navigateByUrl(`${Routing.CONFIGURATION_FULL_PATH}/(${Routing.RIGHT_OUTLET}:${Routing.CTA})`);
    }

    openWidgetSettings() {
        this.router.navigateByUrl(`${Routing.CONFIGURATION_FULL_PATH}/(${Routing.RIGHT_OUTLET}:${Routing.WIDGET})`);
    }

    openPaymentSettings() {
        this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.PAYMENT_OPTIONS}`);
    }

    openBackofficeUserSettings() {
        this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.USER_SETTINGS}`);
    }

    openPortalConnectionsSettings() {
        this.router.navigateByUrl(`${Routing.CONFIGURATION_FULL_PATH}/(${Routing.RIGHT_OUTLET}:portal-connections)`);
    }
}
