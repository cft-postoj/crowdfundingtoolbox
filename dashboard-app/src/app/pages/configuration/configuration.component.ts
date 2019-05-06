import {Component, Input} from '@angular/core';
import { Routing } from '../../constants/config.constants';
import { Router } from '@angular/router';

@Component({
    selector: 'app-configuration',
    templateUrl: 'configuration.component.html',
    styleUrls: ['../../../sass/classes.scss', 'configuration.component.scss']
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
}
