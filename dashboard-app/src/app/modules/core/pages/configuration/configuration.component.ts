import {Component, Input} from '@angular/core';
import { Router } from '@angular/router';
import {Routing} from "../../../../constants/config.constants";

@Component({
    selector: 'app-configuration',
    templateUrl: 'configuration.component.html',
    styleUrls: ['configuration.component.scss']
})
export class ConfigurationComponent {
    public routing = Routing;

    constructor(private router: Router) { }

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
