import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Routing} from '../../constants/config.constants';
import {DropdownItem} from "../../_models/dropdown-item";
import {GeneralSettings} from "../../_models/general-settings";
import {GeneralSettingsService} from "../../_services/general-settings.service";
import {ComponentCommunicationService} from "../../_services/component-communication.service";

@Component({
    selector: 'app-general-settings',
    templateUrl: './general-settings.component.html',
    styleUrls: ['./general-settings.component.scss', '../settings/settings.component.scss']
})

export class GeneralSettingsComponent implements OnInit {

    public opened: number;

    submitted: boolean = false;
    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';

    loading: boolean = true;

    saving: boolean = false;

    public colors = ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
        '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'];

    public fontWeight: DropdownItem[] = [];

    public generalSetting = new GeneralSettings();

    public fontFamilyDropdownButtons = [];

    constructor(private router: Router, private settingsService: GeneralSettingsService, private componentComService: ComponentCommunicationService) {
        this.fetchSettings();
    }

    ngOnInit() {
        this.fontWeight.push({title: "Bold", value: "bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});
    }

    public isOpened(tabNumber: number) {
        return this.opened === tabNumber;
    }

    public openTab(tabNumber: number) {
        this.opened = this.opened === tabNumber ? 0 : tabNumber;
    }

    public delete(deleteIndex: number) {
        this.generalSetting.colors.splice(deleteIndex, 1);
    }

    addColor() {
        this.generalSetting.colors.push('#fff');
    }

    changeValueInArray(index, color) {
        this.generalSetting.colors[index] = color;
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    updateValues(event) {
        this.generalSetting.fonts = event.map(ngxSelected =>
            ngxSelected.value
        )
        this.fontFamilyDropdownButtons = this.generalSetting.fonts.map(font => {
            return {title: font, value: font}
        })
    }

    fetchSettings() {
        this.settingsService.getGeneralPageSettings().subscribe(result => {
            if (result.colors != null && result.fonts != null) {
                this.generalSetting.colors = result.colors;
                this.generalSetting.fonts = result.fonts;
                this.generalSetting.font_settings_headline_text = result.font_settings_headline_text;
                this.generalSetting.font_settings_additional_text = result.font_settings_additional_text;
                this.loading = false;
                this.fontFamilyDropdownButtons = this.generalSetting.fonts.map(font => {
                    return {title: font, value: font}
                })
            }
        });
    }

    updateSettings() {
        this.submitted = true;
        this.saving = true;
        this.settingsService.updateGeneralPageSettings(this.generalSetting).subscribe(result => {
            let targetUrl = Routing.CONFIGURATION_FULL_PATH;
            this.alertOpen = true;
            this.alertType = 'success';
            this.alertMessage = 'Successfully updated General Page Settings.';
            setTimeout(() => {
                this.saving = false;
                this.router.navigateByUrl(targetUrl);
            }, 2000)

        });
    }
}
