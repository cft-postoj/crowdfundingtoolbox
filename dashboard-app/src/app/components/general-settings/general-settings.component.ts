import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {Routing} from '../../constants/config.constants';
import {DropdownItem} from "../../_models/dropdown-item";
import {GeneralSettings} from "../../_models/general-settings";
import {GeneralSettingsService} from "../../_services/general-settings.service";

@Component({
    selector: 'app-general-settings',
    templateUrl: './general-settings.component.html',
    styleUrls: ['./general-settings.component.scss', '../settings/settings.component.scss']
})
export class GeneralSettingsComponent implements OnInit {

    public opened: number;

    public loading = false;

    public colors = ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
        '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'];

    public fontWeight: DropdownItem[] = [];

    // public generalSetting = {
    //     colors :  ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
    //         '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'],
    //     fonts: ['Open Sans', 'Lato', 'Oswald'],
    //     title:
    //         {
    //             fontWeight: '9E0B0F',
    //             color: "#eee",
    //             size: '24'
    //         },
    //     subtitle: {
    //         fontWeight: 400,
    //         color: "#ED1C24",
    //         size: '20'
    //     },
    // };

    public generalSetting = new GeneralSettings();

    constructor(private router: Router, private settingsService: GeneralSettingsService) {
    }

    ngOnInit() {
        this.fontWeight.push({title: "Bold", value: "bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});
        console.log(this.generalSetting.font_settings_additional_text)
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


    generateDropdowns(fonts: string[]) {
       return fonts.map(font => {
           return {title: font, value: font}
        })
    }

    updateValues(event) {
        this.generalSetting.fonts = event.map(ngxSelected =>
            ngxSelected.value
        )
    }

    updateSettings() {
       this.settingsService.updateGeneralPageSettings(this.generalSetting).subscribe(result => {
           console.log(result);
       });
    }
}
