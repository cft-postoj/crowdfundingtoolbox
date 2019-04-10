import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";
import {DropdownItem} from "../../_models/dropdown-item";
import {CtaSettings} from "../../_models/cta-settings";
import {GeneralSettings} from "../../_models/general-settings";
import {GeneralSettingsService} from "../../_services/general-settings.service";
import {forEach} from "@angular/router/src/utils/collection";

@Component({
    selector: 'app-cta-settings',
    templateUrl: './cta-settings.component.html',
    styleUrls: ['./cta-settings.component.scss', '../settings/settings.component.scss']
})
export class CtaSettingsComponent implements OnInit {

    public generalSettings = new GeneralSettings();

    submitted: boolean = false;
    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';


    public cta = 'Default';
    public call_to_action = new CtaSettings();


    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    private radioButtons: RadioButton[] = [];
    private fontWeight: DropdownItem[] = [];
    public fontFamily: DropdownItem[] = [];
    private shadowButtons: any[];
    public allRadiusesButton: RadioButton[] = [];
    public specificRadiusButtons: RadioButton[] = [];
    public radiusButtons: RadioButton[] = [];
    private specificRadius: boolean;

    constructor(public router: Router, private settingsService: GeneralSettingsService) {
        this.fetchGeneralSettings();
        this.fetchCtaSettings();
    }

    ngOnInit() {
        this.radioButtons.push(new RadioButton("left", "left", "/assets/images/icons/left.svg"))
        this.radioButtons.push(new RadioButton("center", "center", "/assets/images/icons/center.svg"))
        this.radioButtons.push(new RadioButton("right", "right", "/assets/images/icons/right.svg"))

        this.fontWeight.push({title: "Bold", value: "bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});

        this.generalSettings.fonts.map((val, key) => {
            this.fontFamily.push({title: val, value: val});
        });

        this.shadowButtons = [];
        this.shadowButtons.push(new RadioButton("x", this.call_to_action.default.design.shadow.x, '', "X:"))
        this.shadowButtons.push(new RadioButton("y", this.call_to_action.default.design.shadow.y, '', "Y:"))
        this.shadowButtons.push(new RadioButton("b", this.call_to_action.default.design.shadow.b, '', "B:"))

        this.allRadiusesButton.push(new RadioButton("all", 0, "/assets/images/icons/radius_AllTogether.svg"))

        this.specificRadiusButtons.push(new RadioButton("tl", this.call_to_action.default.design.radius.tl, "/assets/images/icons/radius_LeftTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("tr", this.call_to_action.default.design.radius.tr, "/assets/images/icons/radius_RightTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("br", this.call_to_action.default.design.radius.br, "/assets/images/icons/radius_LeftBottom.svg"))
        this.specificRadiusButtons.push(new RadioButton("bl", this.call_to_action.default.design.radius.bl, "/assets/images/icons/radius_LeftBottom.svg"))

        this.radiusButtons.push(new RadioButton("active", false, "/assets/images/icons/radius_disable.svg"));
        this.radiusButtons.push(new RadioButton("disabled", true, "/assets/images/icons/radius_enable.svg"));

        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton("top", this.call_to_action.default.padding.top, "/assets/images/icons/padding_top.svg"))
        this.paddingButtons.push(new RadioButton("right", this.call_to_action.default.padding.right, "/assets/images/icons/padding_right.svg"))
        this.paddingButtons.push(new RadioButton("bottom", this.call_to_action.default.padding.bottom, "/assets/images/icons/padding_bottom.svg"))
        this.paddingButtons.push(new RadioButton("left", this.call_to_action.default.padding.left, "/assets/images/icons/padding_left.svg"))

        this.marginButtons = [];
        this.marginButtons.push(new RadioButton("top", this.call_to_action.default.margin.top, "/assets/images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.call_to_action.default.margin.right, "/assets/images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.call_to_action.default.margin.bottom, "/assets/images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.call_to_action.default.margin.left, "/assets/images/icons/margin_left.svg"))

        this.calcSpecificRadius();
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    setSpecificRadius(value: boolean) {
        this.specificRadius = value;
    }

    writeRadiusValue(value) {
        this.specificRadiusButtons.forEach(rb => {
            this.call_to_action.default.design.radius[rb.name] = value;
        })
        this.specificRadiusButtons.forEach(button => {
            button.value = value;
        })
    }

    calcSpecificRadius() {
        let firstValue;
        let result = false;
        this.specificRadiusButtons.forEach(rb => {
            firstValue = firstValue ? firstValue : rb.value;
            if (rb.value !== firstValue) {
                result = true;
            }
        })
        this.setSpecificRadius(result)
    }

    fetchGeneralSettings() {
        this.settingsService.getGeneralPageSettings().subscribe(response => {
            this.generalSettings = response;
        })
    }

    fetchCtaSettings() {
        this.settingsService.getCtaSettings().subscribe(response => {
           this.call_to_action = response;
        });
    }

    updateSettings() {
        this.submitted = true;
        this.settingsService.updateCtaSettings(this.call_to_action).subscribe(response => {
            let targetUrl = Routing.CONFIGURATION_FULL_PATH;
            this.alertOpen = true;
            this.alertType = 'success';
            this.alertMessage = 'Successfully updated CTA Settings.';
            setTimeout(() => {
                this.router.navigateByUrl(targetUrl);
            }, 2000)
        });
    }

}
