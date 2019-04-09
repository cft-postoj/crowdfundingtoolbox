import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";

@Component({
    selector: 'app-widget-settings',
    templateUrl: './widget-settings.component.html',
    styleUrls: ['./widget-settings.component.scss', '../settings/settings.component.scss']
})
export class WidgetSettingsComponent implements OnInit {

    constructor(private router: Router) {
    }

    ngOnInit() {
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }
}
