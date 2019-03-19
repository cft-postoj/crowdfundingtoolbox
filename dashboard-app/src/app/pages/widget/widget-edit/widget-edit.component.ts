import {Component, DoCheck, OnChanges, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {Routing} from "../../../constants/config.constants";
import {Widget} from "../../../_models/widget";
import {WidgetService} from "../../../_services/widget.service";
import {RadioButton} from "../../../_parts/atoms/radio-button/radio-button";
import {backgroundTypes, devices, paymentTypes} from "../../../_models/enums";
import {DropdownItem} from "../../../_models/dropdown-item";
import {ComponentCommunicationService} from "../../../_services/component-communication.service";
import {PreviewService} from "../../../_services/preview.service";
import {Subscription} from "rxjs";
import {environment} from "../../../../environments/environment";

@Component({
    selector: 'app-widget-edit',
    templateUrl: './widget-edit.component.html',
    styleUrls: ['./widget-edit.component.scss']
})
export class WidgetEditComponent implements OnInit, OnDestroy, DoCheck  {

    public opened = 1;
    public routing = Routing;
    loading = true;
    widget = new Widget();
    id;
    backgroundTypes = backgroundTypes;
    public backgroundTypesButtons: RadioButton[] = [];
    public radioButtons: RadioButton[] = [];
    deviceType = devices.desktop.name;
    public paymentTypeRadioButtons: RadioButton[]= []
    public paymentTypes = paymentTypes ;
    public copyPrices;
    public preview: boolean;
    public saving: boolean = false;
    public paddingButtons: RadioButton[]= [];
    public marginButtons: RadioButton[]= [];
    public marginText: RadioButton[]= [];
    public shadowButtons: RadioButton[] =[];
    public fontWeight: DropdownItem[] = [];
    public displaySettings: DropdownItem[] = [];
    public positionSettings: DropdownItem[] = [];
    public ctaSettings:string="Default";
    creatingHTMLs=false;

    @ViewChild('previewGenerateHTML') previewGenerateHTML;
    public subcriptions: Subscription;
    cta: string="Default";
    private pricesOptions: DropdownItem[];

    constructor(private router: Router,
                private route: ActivatedRoute,
                private widgetService: WidgetService,
                private componentComService:ComponentCommunicationService,
                private previewService:PreviewService) {

    }

    ngDoCheck() {
        if (this.preview)
           this.previewService.updatePreview();
    }
    ngOnInit() {
        let assetsUrl = (environment.production) ? 'public/app/assets/' : '../../../../assets/';
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.color.name,backgroundTypes.color.value))
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.image.name,backgroundTypes.image.value))
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.imageOverlay.name,backgroundTypes.imageOverlay.value))

        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value))
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value))

        this.id = this.route.snapshot.paramMap.get("widgetId");

        this.widgetService.getById(this.id).subscribe((response: any) => {
            this.widget = response.data;
            this.loading = false;

            this.fontWeight.push({title:"Bold",value:"bold"});
            this.fontWeight.push({title: "Light", value: 100});
            this.fontWeight.push({title: "Medium", value: 400});

            this.displaySettings.push({title: 'Inline', value: 'inline'});
            this.displaySettings.push({title: 'Block', value: 'block'});

            this.positionSettings.push({title: 'Top', value: '0'}); // top: 0
            this.positionSettings.push({title: 'Bottom', value: 'auto'}); // top: auto

            this.radioButtons.push( new RadioButton("left","left",assetsUrl + "images/icons/left.svg"))
            this.radioButtons.push( new RadioButton("center","center",assetsUrl + "images/icons/center.svg"))
            this.radioButtons.push( new RadioButton("right","right",assetsUrl + "images/icons/right.svg"))

            this.recreateRadioButtons();

        }, (error) => {
            console.error(error);
        });

        this.subcriptions = this.previewService.htmls.subscribe(htmlsWrapper => {
            let subs =  this.widgetService.updateWidgetsHTML(this.widget.id, htmlsWrapper).subscribe(
                result => {
                    this.componentComService.setAlertMessage("Widget " + this.widget.widget_type.name + " successfully updated.");
                    this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
                    subs.unsubscribe();
                }
            )
        })
    }

    ngOnDestroy(){
        this.subcriptions.unsubscribe();
    }

    closeEditWindow() {
        this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
    }

    public openTab(tabNumber: number) {
        this.opened = this.opened == tabNumber ? 0 : tabNumber;
    }

    public isOpened(tabNumber: number) {
        return this.opened === tabNumber;
    }

    //add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPrices(event) {
        while(this.widget.settings[this.deviceType].payment_settings.monthly_prices.count_of_options != event && (!!event || event==0) ) {
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
    updateNumberOfOnOfPrices(event) {
        while(this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options != event && (!!event || event==0) ) {
            if (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options > event) {
                this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options--;
                this.widget.settings[this.deviceType].payment_settings.once_prices.options.pop();
            }
            if (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options < event) {
                this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options++;
                this.widget.settings[this.deviceType].payment_settings.once_prices.options.push(
                    { value: this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options * 5}
                );
            }
        }
    }

    createActivePriceOptions():DropdownItem[]{
        var result : DropdownItem[] = [];
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.options.forEach( (option,i) => {
            result.push({
                title: 'Price No.'+(i+1),
                value: option.value
            })
        })
        if (!this.pricesOptions || this.pricesOptions.length==0 || this.pricesOptions.length!= result.length ) {
            this.pricesOptions = result;
        }
        return this.pricesOptions;
    }

    togglePreview(){
        this.preview= !this.preview;
    }

    updateWidget(){
        this.saving = true;
        this.creatingHTMLs = true
        this.widgetService.updateWidget(this.widget).subscribe(result => {
            this.previewGenerateHTML.generateHTMLFromWidgets();
        })
    }

    recreateRadioButtons(){
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

        this.marginButtons = [];
        this.marginButtons.push(new RadioButton("top", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.left, assetsUrl + "images/icons/margin_left.svg"))

        this.shadowButtons = [];
        this.shadowButtons.push( new RadioButton("x",this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.x,'',"X:"))
        this.shadowButtons.push( new RadioButton("y",this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.y,'',"Y:"))
        this.shadowButtons.push( new RadioButton("b",this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.b,'',"B:"))

    }

}
