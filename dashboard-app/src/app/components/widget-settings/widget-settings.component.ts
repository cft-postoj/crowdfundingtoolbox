import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";
import {WidgetSettings} from "../../_models/widget-settings";
import {GeneralSettingsService} from "../../_services/general-settings.service";

@Component({
    selector: 'app-widget-settings',
    templateUrl: './widget-settings.component.html',
    styleUrls: ['./widget-settings.component.scss', '../settings/settings.component.scss']
})
export class WidgetSettingsComponent implements OnInit {

    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    loading = true;

    submitted: boolean = false;
    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';

    public widget_settings = new WidgetSettings();

    constructor(private router: Router, private settingsService: GeneralSettingsService) {
        this.fetchWidgetSettings();
    }

    ngOnInit() {
        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton("top", this.widget_settings.general.padding.top, "/assets/images/icons/padding_top.svg"))
        this.paddingButtons.push(new RadioButton("right", this.widget_settings.general.padding.right, "/assets/images/icons/padding_right.svg"))
        this.paddingButtons.push(new RadioButton("bottom", this.widget_settings.general.padding.bottom, "/assets/images/icons/padding_bottom.svg"))
        this.paddingButtons.push(new RadioButton("left", this.widget_settings.general.padding.left, "/assets/images/icons/padding_left.svg"))

        this.marginButtons = [];
        this.marginButtons.push(new RadioButton("top", this.widget_settings.general.margin.top, "/assets/images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.widget_settings.general.margin.right, "/assets/images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.widget_settings.general.margin.bottom, "/assets/images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.widget_settings.general.margin.left, "/assets/images/icons/margin_left.svg"))
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    fetchWidgetSettings() {
        this.settingsService.getWidgetSettings().subscribe(response => {
            // fetch only GENERAL settings
            this.widget_settings.general = response.general;
        })
    }

    updateSettings() {
        this.submitted = true;
        this.settingsService.updateWidgetSettings(this.widget_settings).subscribe(response => {
            let targetUrl = Routing.CONFIGURATION_FULL_PATH;
            this.alertOpen = true;
            this.alertType = 'success';
            this.alertMessage = 'Successfully updated Widget Settings.';
            setTimeout(() => {
                this.router.navigateByUrl(targetUrl);
            }, 2000)
        });
    }
}
