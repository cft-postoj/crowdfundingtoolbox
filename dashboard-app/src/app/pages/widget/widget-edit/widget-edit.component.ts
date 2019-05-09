import {Component, DoCheck, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Routing} from "../../../constants/config.constants";
import {Widget} from "../../../_models/widget";
import {WidgetService} from "../../../_services/widget.service";
import {RadioButton} from "../../../_parts/atoms/radio-button/radio-button";
import {backgroundTypes, devices, paymentTypes, widgetTypes} from "../../../_models/enums";
import {DropdownItem} from "../../../_models/dropdown-item";
import {ComponentCommunicationService} from "../../../_services/component-communication.service";
import {PreviewService} from "../../../_services/preview.service";
import {Subscription} from "rxjs";
import {environment} from "../../../../environments/environment";
import {GeneralSettingsService} from "../../../_services/general-settings.service";

@Component({
    selector: 'app-widget-edit',
    templateUrl: './widget-edit.component.html',
    styleUrls: ['./widget-edit.component.scss', '../../../components/settings/settings.component.scss']
})
export class WidgetEditComponent implements OnInit, OnDestroy, DoCheck {

    public opened: number[] = [];
    public routing = Routing;
    loading = true;
    widget = new Widget();
    id;
    backgroundTypes = backgroundTypes;
    public backgroundTypesButtons: RadioButton[] = [];
    public radioButtons: RadioButton[] = [];
    deviceType = devices.desktop.name;
    public paymentTypeRadioButtons: RadioButton[] = []
    public paymentTypes = paymentTypes;
    public copyPrices;
    public preview;
    public saving: boolean = false;
    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    public marginText: RadioButton[] = [];
    private marginAdditionalText: RadioButton[] = [];
    public shadowButtons: RadioButton[] = [];
    public fontWeight: DropdownItem[] = [];
    public positionSettings: DropdownItem[] = [];
    public ctaSettings: string = "Default";
    creatingHTMLs = false;
    widgetTypes = widgetTypes;
    public allRadiusesButton: RadioButton[] = [];
    private specificRadius: boolean;
    public specificRadiusButtons: RadioButton[] = [];
    private radiusButtons: any[];

    @ViewChild('previewGenerateHTML') previewGenerateHTML;
    public subcriptions: Subscription;
    cta: string = "Default";
    private pricesOptions: DropdownItem[];
    public colors = ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
        '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'];
    fontFamily = [];
    fontFamilyDropdownButtons = [];

    public paddingMonetization: RadioButton[] = [];
    public marginMonetization: RadioButton[] = [];

    constructor(private router: Router,
                private route: ActivatedRoute,
                private widgetService: WidgetService,
                private componentComService: ComponentCommunicationService,
                private previewService: PreviewService,
                private generaSettingsService : GeneralSettingsService) {

    }

    ngDoCheck() {
        if (this.preview)
            this.previewService.updatePreview();
    }

    ngOnInit() {
        let assetsUrl = (environment.production) ? 'public/app/assets/' : '../../../../assets/';
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.color.name, backgroundTypes.color.value))
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.image.name, backgroundTypes.image.value))
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.imageOverlay.name, backgroundTypes.imageOverlay.value))

        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value))

        this.id = this.route.snapshot.paramMap.get("widgetId");

        this.widgetService.getById(this.id).subscribe((response: any) => {
//            TODO: change backend to support additional_text and then remove this mock (uncomment next line)
            this.widget = response.data;
            this.loading = false;

            this.fontWeight.push({title: "Bold", value: "bold"});
            this.fontWeight.push({title: "Light", value: 100});
            this.fontWeight.push({title: "Medium", value: 400});

            this.positionSettings.push({title: 'Top', value: '0'}); // top: 0
            this.positionSettings.push({title: 'Bottom', value: 'auto'}); // top: auto

            this.recreateRadioButtons();

        }, (error) => {
            console.error(error);
        });

        this.generaSettingsService.getFonts().subscribe(  result =>{
            this.fontFamily = result.fonts;
            this.recreateRadioButtons();
        });

        this.subcriptions = this.previewService.htmls.subscribe(htmlsWrapper => {
            let subs = this.widgetService.updateWidgetsHTML(this.widget.id, htmlsWrapper).subscribe(
                result => {
                    this.componentComService.setAlertMessage("Widget " + this.widget.widget_type.name + " successfully updated.");
                    this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
                    subs.unsubscribe();
                }
            )
        })
        this.preview = true;
    }

    ngOnDestroy() {
        this.subcriptions.unsubscribe();
    }

    closeEditWindow() {
        this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
    }

    public openTab(tabNumber: number) {
        if (this.isOpened(tabNumber)) {
            this.opened.splice(this.opened.indexOf(tabNumber), 1)
        } else {
            this.opened.push(tabNumber);
        }
    }

    public isOpened(tabNumber: number) {
        return this.opened.indexOf(tabNumber) > -1;
    }

    //add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPrices(event) {
        while (this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options != event && (!!event || event == 0)) {
            if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options > event) {
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options--;
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.options.pop();
            }
            if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options < event) {
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options++;
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.options.push(
                    {value: this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options * 5});
            }
        }
    }

    //add or remove items in once_prices to match with value from monthly_prices
    updateNumberOfSinglePayments(event) {
        while (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options != event && (!!event || event == 0)) {
            if (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options > event) {
                this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options--;
                this.widget.settings[this.deviceType].payment_settings.once_prices.options.pop();
            }
            if (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options < event) {
                this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options++;
                this.widget.settings[this.deviceType].payment_settings.once_prices.options.push(
                    {value: this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options * 5});
            }
        }
    }

    createActivePriceOptions(): DropdownItem[] {
        var result: DropdownItem[] = [];
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.options.forEach((option, i) => {
            result.push({
                title: 'Price No.' + (i + 1),
                value: option.value
            })
        })
        if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.custom_price){
            result.push({
                title: 'Custom price option',
                value: 'custom'
            })
        }
        if (!this.pricesOptions || this.pricesOptions.length == 0 || this.pricesOptions.length != result.length) {
            this.pricesOptions = result
        }
        return this.pricesOptions;
    }

    togglePreview() {
        this.preview = !this.preview;
    }

    updateWidget() {
        this.saving = true;
        this.creatingHTMLs = true
        this.widgetService.updateWidget(this.widget).subscribe(result => {
            this.previewGenerateHTML.generateHTMLFromWidgets();
        })
    }

    recreateRadioButtons() {
        let assetsUrl = (environment.production) ? 'public/app/assets/' : '../../../../assets/';

        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton("top", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.top, assetsUrl + "images/icons/padding_top.svg"))
        this.paddingButtons.push(new RadioButton("right", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.right, assetsUrl + "images/icons/padding_right.svg"))
        this.paddingButtons.push(new RadioButton("bottom", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.bottom, assetsUrl + "images/icons/padding_bottom.svg"))
        this.paddingButtons.push(new RadioButton("left", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.left, assetsUrl + "images/icons/padding_left.svg"))


        this.marginText = [];
        this.marginText.push(new RadioButton("top", this.widget.settings[this.deviceType].widget_settings.general.text_margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginText.push(new RadioButton("right", this.widget.settings[this.deviceType].widget_settings.general.text_margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginText.push(new RadioButton("bottom", this.widget.settings[this.deviceType].widget_settings.general.text_margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginText.push(new RadioButton("left", this.widget.settings[this.deviceType].widget_settings.general.text_margin.left, assetsUrl + "images/icons/margin_left.svg"))


        this.marginAdditionalText = [];
        this.marginAdditionalText.push(new RadioButton("top", this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginAdditionalText.push(new RadioButton("right", this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginAdditionalText.push(new RadioButton("bottom", this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginAdditionalText.push(new RadioButton("left", this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.left, assetsUrl + "images/icons/margin_left.svg"))

        this.marginButtons = [];

        this.marginButtons.push(new RadioButton("top", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.left, assetsUrl + "images/icons/margin_left.svg"))


        this.shadowButtons = [];
        this.shadowButtons.push(new RadioButton("x", this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.x, '', "X:"))
        this.shadowButtons.push(new RadioButton("y", this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.y, '', "Y:"))
        this.shadowButtons.push(new RadioButton("b", this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.b, '', "B:"))

        this.radioButtons = [];
        this.radioButtons.push(new RadioButton("left", "left", "/assets/images/icons/left.svg"))
        this.radioButtons.push(new RadioButton("center", "center", "/assets/images/icons/center.svg"))
        this.radioButtons.push(new RadioButton("right", "right", "/assets/images/icons/right.svg"))

        this.allRadiusesButton = [];
        this.allRadiusesButton.push(new RadioButton("all", 0, "/assets/images/icons/radius_AllTogether.svg"))

        this.radiusButtons = [];
        this.radiusButtons.push(new RadioButton("active", false, "/assets/images/icons/radius_disable.svg"));
        this.radiusButtons.push(new RadioButton("disabled", true, "/assets/images/icons/radius_enable.svg"));

        this.specificRadiusButtons = [];
        this.specificRadiusButtons.push(new RadioButton("tl", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.tl, "/assets/images/icons/radius_LeftTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("tr", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.tr, "/assets/images/icons/radius_RightTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("br", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.br, "/assets/images/icons/radius_LeftBottom.svg"))
        this.specificRadiusButtons.push(new RadioButton("bl", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.bl, "/assets/images/icons/radius_LeftBottom.svg"))


        this.paddingMonetization = [];
        this.paddingMonetization.push(new RadioButton("top", this.widget.settings[this.deviceType].payment_settings.design.padding.top, assetsUrl + "images/icons/padding_top.svg"))
        this.paddingMonetization.push(new RadioButton("right", this.widget.settings[this.deviceType].payment_settings.design.padding.right, assetsUrl + "images/icons/padding_right.svg"))
        this.paddingMonetization.push(new RadioButton("bottom", this.widget.settings[this.deviceType].payment_settings.design.padding.bottom, assetsUrl + "images/icons/padding_bottom.svg"))
        this.paddingMonetization.push(new RadioButton("left", this.widget.settings[this.deviceType].payment_settings.design.padding.left, assetsUrl + "images/icons/padding_left.svg"))


        this.marginMonetization = [];
        this.marginMonetization.push(new RadioButton("top", this.widget.settings[this.deviceType].payment_settings.design.margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginMonetization.push(new RadioButton("right", this.widget.settings[this.deviceType].payment_settings.design.margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginMonetization.push(new RadioButton("bottom", this.widget.settings[this.deviceType].payment_settings.design.margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginMonetization.push(new RadioButton("left", this.widget.settings[this.deviceType].payment_settings.design.margin.left, assetsUrl + "images/icons/margin_left.svg"))



        this.fontFamilyDropdownButtons = [];
        this.fontFamily.forEach( fontFamily => {
            this.fontFamilyDropdownButtons.push({title:fontFamily,value:fontFamily})
        });
        
        
    }

    writeRadiusValue(value) {
        this.specificRadiusButtons.forEach(rb => {
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius[rb.name] = value;
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

    setSpecificRadius(value: boolean) {
        this.specificRadius = value;
    }

}
