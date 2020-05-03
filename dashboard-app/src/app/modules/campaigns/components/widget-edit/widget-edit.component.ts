import {Component, DoCheck, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {Subscription} from 'rxjs';
import {Widget} from '../../models';
import {Routing} from '../../../../constants/config.constants';
import {
    backgroundTypes,
    devices,
    DropdownItem,
    paymentMethods,
    paymentTypes,
    RadioButton,
    widgetTypes
} from '../../../core/models';
import {PreviewService, WidgetService} from '../../services';
import {ComponentCommunicationService, GeneralSettingsService} from '../../../core/services';
import {environment} from '../../../../../environments/environment';
import {monetizationTypes as monetizationTypesEnums} from '../../models/enums';
import {forEach} from '@angular/router/src/utils/collection';

@Component({
    selector: 'app-widget-edit',
    templateUrl: './widget-edit.component.html',
    styleUrls: ['./widget-edit.component.scss',
        '../../../core/components/settings/settings.component.scss', '../campaign-settings/campaign-settings.component.scss']
})
export class WidgetEditComponent implements OnInit, OnDestroy, DoCheck {

    uploadUrl: string = environment.backOfficeUrl + '/upload-wysiwyg';
    public opened: number[] = [];
    public routing = Routing;
    loading = true;
    widget = new Widget();
    id;
    backgroundTypes = backgroundTypes;
    public backgroundTypesButtons: RadioButton[] = [];
    public radioButtons: RadioButton[] = [];
    deviceType = devices.desktop.name;
    public paymentTypeRadioButtons: RadioButton[] = [];
    public currencyOptionseRadioButtons: RadioButton[] = [];
    public currencyPriceOptions: string = '€';
    public paymentTypes = paymentTypes;
    public copyPrices;
    public preview;
    public saving: boolean = false;
    public paddingButtons: RadioButton[] = [];
    public paddingContinueReadingButton: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    public marginContinueReadingButton: RadioButton[] = [];
    public marginText: RadioButton[] = [];
    private marginAdditionalText: RadioButton[] = [];
    public shadowButtons: RadioButton[] = [];
    public fontWeight: DropdownItem[] = [];
    public positionSettings: DropdownItem[] = [];
    public ctaSettings: string = 'Default';
    creatingHTMLs = false;
    widgetTypes = widgetTypes;
    paymentMethods = paymentMethods;
    public allRadiusesButton: RadioButton[] = [];
    private specificRadius: boolean;
    public specificRadiusButtons: RadioButton[] = [];
    private radiusButtons: any[];

    @ViewChild('previewGenerateHTML') previewGenerateHTML;
    public subcriptions: Subscription;
    cta: string = 'Default';
    private pricesOptionsMonthly: DropdownItem[];
    private pricesOptionsOneTime: DropdownItem[];
    public colors = ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
        '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'];
    fontFamily = [];
    fontFamilyDropdownButtons = [];

    public paddingMonetization: RadioButton[] = [];
    public marginMonetization: RadioButton[] = [];
    public monetizationTypes: DropdownItem[] = [];
    private backgroundPadding: RadioButton[] = [];
    private marginMonetizationHeadlineText: RadioButton[] = [];
    public paymentMethodsDropdown: DropdownItem[] = [];
    public monetizationTypesEnums = monetizationTypesEnums;

    private widgetSettings: [];
    private activeWidgetSettings: '';
    private availableSubtypes: DropdownItem[] = [];

    alertType: string = 'danger';
    alertOpen = false;
    alertMessage;
    private closeAfterDone: boolean = true;
    private deviceTypeBeforeUpdate: string;


    constructor(private router: Router,
                private route: ActivatedRoute,
                private widgetService: WidgetService,
                private componentComService: ComponentCommunicationService,
                private previewService: PreviewService,
                private generaSettingsService: GeneralSettingsService) {

    }

    ngDoCheck() {
        if (this.preview) {
            this.previewService.updatePreview();
        }
    }

    ngOnInit() {
        const assetsUrl = (environment.production) ? 'assets/' : '../../../../assets/';
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.color.name, backgroundTypes.color.value));
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.image.name, backgroundTypes.image.value));
        this.backgroundTypesButtons.push(new RadioButton(backgroundTypes.imageOverlay.name, backgroundTypes.imageOverlay.value));

        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.monthly.title, this.paymentTypes.monthly.value));
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.once.title, this.paymentTypes.once.value));
        this.paymentTypeRadioButtons.push(new RadioButton(this.paymentTypes.both.title, this.paymentTypes.both.value));

        this.currencyOptionseRadioButtons.push(new RadioButton('Show with sum', 'sum'));
        this.currencyOptionseRadioButtons.push(new RadioButton('Show with period', 'period'));
        this.currencyOptionseRadioButtons.push(new RadioButton('Disabled', 'disabled'));

        this.paymentMethodsDropdown.push(new DropdownItem(this.paymentMethods.bankTransfer.title, this.paymentMethods.bankTransfer.value));
        this.paymentMethodsDropdown.push(new DropdownItem(this.paymentMethods.payBySquare.title, this.paymentMethods.payBySquare.value));
        this.id = this.route.snapshot.paramMap.get('widgetId');

        this.getWidget(this.id);

        this.generaSettingsService.getFonts().subscribe(result => {
            this.fontFamily = result.fonts;
            this.recreateRadioButtons();
        });

        this.subcriptions = this.previewService.htmls.subscribe(htmlsWrapper => {
            const subs = this.widgetService.updateWidgetsHTML(this.widget.id, htmlsWrapper).subscribe(
                result => {
                    if (this.closeAfterDone) {
                        this.componentComService.setAlertMessage('Widget ' + this.widget.widget_type.name + ' successfully updated.');
                        this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
                        subs.unsubscribe();
                    } else {
                        this.loading = false;
                        this.saving = false;
                        this.alertType = 'success';
                        this.alertOpen = true;
                        this.alertMessage = 'Widet updated.';
                        this.deviceType = this.deviceTypeBeforeUpdate;
                    }
                }
            );
        });
        this.preview = true;
    }

    ngOnDestroy() {
        if (this.subcriptions !== undefined) {
            this.subcriptions.unsubscribe();
        }
    }

    getWidget(id) {
        this.widgetService.getById(id).subscribe((response: any) => {
            if (response.data.contains_additional_widget_settings) {
                this.widgetSettings = response.data['additional_widget_settings'];
            }
            this.widget = response.data;
            this.loading = false;

            this.fontWeight.push({title: 'Bold', value: 'bold'});
            this.fontWeight.push({title: 'Light', value: 100});
            this.fontWeight.push({title: 'Medium', value: 400});

            this.positionSettings.push({title: 'Top', value: '0'}); // top: 0
            this.positionSettings.push({title: 'Bottom', value: 'auto'}); // top: auto
            for (const monetizationType of Object.keys(monetizationTypesEnums)) {
                this.monetizationTypes.push({
                    title: monetizationTypesEnums[monetizationType].name,
                    value: monetizationTypesEnums[monetizationType].type
                });
            }

// if (this.widget.settings[this.deviceType].additional_settings.buttonContainer.button !== undefined) {
//     if (this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.fontSize !== undefined) {
//         this.widget.settings[this.deviceType].widget_settings.call_to_action.default.fontSettings.fontSize =
//             this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.fontSize;
//     }
// }

            this.recreateRadioButtons();
        }, (error) => {
            console.error(error);
        });
    }

    closeEditWindow() {
        this.router.navigateByUrl(this.router.url.split(Routing.RIGHT_OUTLET)[0]);
    }

    public openTab(tabNumber: number) {
        if (this.isOpened(tabNumber)) {
            this.opened.splice(this.opened.indexOf(tabNumber), 1);
        } else {
            this.opened.push(tabNumber);
        }
    }

    public isOpened(tabNumber: number) {
        return this.opened.indexOf(tabNumber) > -1;
    }

    // add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPrices(event) {
        let monthlyPrices = this.widget.settings[this.deviceType].payment_settings.monthly_prices;
        while (monthlyPrices.count_of_options !== event && (!!event || event === 0)) {
            if (monthlyPrices.count_of_options > event) {
                monthlyPrices.count_of_options--;
                monthlyPrices.options.pop();
            }
            if (monthlyPrices.count_of_options < event) {
                monthlyPrices.count_of_options++;
                monthlyPrices.options.push(
                    {value: monthlyPrices.count_of_options * 5});
            }
        }
    }

    // add or remove items in monthly_prices to match with value from monthly_prices
    updateNumberOfMonthlyPricesInColumn(event, column) {
        while (column.count_of_options !== event && (!!event || event === 0)) {
            if (column.count_of_options > event) {
                column.count_of_options--;
                column.options.pop();
            }
            if (column.count_of_options < event) {
                column.count_of_options++;
                column.options.push(
                    {value: column.count_of_options * 5});
            }
        }
    }

    // add or remove items in once_prices to match with value from monthly_prices
    updateNumberOfSinglePayments(event) {
        while (this.widget.settings[this.deviceType].payment_settings.once_prices.count_of_options !== event && (!!event || event === 0)) {
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

    createActivePriceOptionsMonthly(): DropdownItem[] {
        let result: DropdownItem[] = [];
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.options.forEach((option, i) => {
            result.push({
                title: 'Price No.' + (i + 1) + ': ' + option.value + ' € monthly',
                value: option.value
            });
        });
        if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.custom_price) {
            result.push({
                title: 'Custom price option',
                value: 'custom'
            });
        }
        if (!this.pricesOptionsMonthly || this.pricesOptionsMonthly.length === 0 || this.pricesOptionsMonthly.length !== result.length) {
            this.pricesOptionsMonthly = result;
        }
        return this.pricesOptionsMonthly;
    }

    // crate active price options but for column monetization type. In column monetization type, all prices are diveded
    // into more columns, therefore data stracture
    // is different as in another types, where is used function @createActivePriceOptionsMonthly()
    createActivePriceOptionsColumnMonthly(): DropdownItem[] {
        let result: DropdownItem[] = [];
        let order = 0;
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns.forEach(
            column => {
                column.options.forEach(option => {
                    result.push({
                        title: 'Price No.' + (order + 1) + ': ' + option.value + ' € monthly',
                        value: option.value
                    });
                    order++;
                });
            }
        );
        if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.custom_price) {
            result.push({
                title: 'Custom price option',
                value: 'custom'
            });
        }
        if (!this.pricesOptionsMonthly || this.pricesOptionsMonthly.length == 0 || this.pricesOptionsMonthly.length != result.length) {
            this.pricesOptionsMonthly = result;
        }
        return this.pricesOptionsMonthly;
    }

    createActivePriceOptionsOneTime(): DropdownItem[] {
        let result: DropdownItem[] = [];
        this.widget.settings[this.deviceType].payment_settings.once_prices.options.forEach((option, i) => {
            result.push({
                title: 'Price No.' + (i + 1) + ': ' + option.value + ' € one time',
                value: option.value
            });
        });
        if (this.widget.settings[this.deviceType].payment_settings.once_prices.custom_price) {
            result.push({
                title: 'Custom price option',
                value: 'custom'
            });
        }
        if (!this.pricesOptionsOneTime || this.pricesOptionsOneTime.length === 0 || this.pricesOptionsOneTime.length !== result.length) {
            this.pricesOptionsOneTime = result;
        }
        return this.pricesOptionsOneTime;
    }

    togglePreview() {
        this.preview = !this.preview;
    }

    updateWidget(close: boolean) {
        this.deviceTypeBeforeUpdate = this.deviceType;
        // on submit, change device type to desktop (for correctly saving html output)
        this.deviceType = 'desktop';

        this.saving = true;
        this.creatingHTMLs = true;
        this.closeAfterDone = close;
        this.widgetService.updateWidget(this.widget).subscribe(result => {
            this.previewGenerateHTML.generateHTMLFromWidgets();
        });

    }

    recreateRadioButtons() {
        let assetsUrl = (environment.production) ? 'assets/' : '../../../../assets/';

        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton('top',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.top,
            assetsUrl + 'images/icons/padding_top.svg'));
        this.paddingButtons.push(new RadioButton('right',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.right,
            assetsUrl + 'images/icons/padding_right.svg'));
        this.paddingButtons.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.bottom,
            assetsUrl + 'images/icons/padding_bottom.svg'));
        this.paddingButtons.push(new RadioButton('left',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.padding.left,
            assetsUrl + 'images/icons/padding_left.svg'));

        this.paddingContinueReadingButton = [];
        this.marginContinueReadingButton = [];
        if (this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer !== undefined) {
            const buttonStyles = this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer;
            this.paddingContinueReadingButton.push(new RadioButton('top',
                buttonStyles.button.padding.top, assetsUrl + 'images/icons/padding_top.svg'));
            this.paddingContinueReadingButton.push(new RadioButton('right',
                buttonStyles.button.padding.right, assetsUrl + 'images/icons/padding_right.svg'));
            this.paddingContinueReadingButton.push(new RadioButton('bottom',
                buttonStyles.button.padding.bottom, assetsUrl + 'images/icons/padding_bottom.svg'));
            this.paddingContinueReadingButton.push(new RadioButton('left',
                buttonStyles.button.padding.left, assetsUrl + 'images/icons/padding_left.svg'));

            this.marginContinueReadingButton.push(new RadioButton('top',
                buttonStyles.margin.top, assetsUrl + 'images/icons/margin_top.svg'));
            this.marginContinueReadingButton.push(new RadioButton('right',
                buttonStyles.margin.right, assetsUrl + 'images/icons/margin_right.svg'));
            this.marginContinueReadingButton.push(new RadioButton('bottom',
                buttonStyles.margin.bottom, assetsUrl + 'images/icons/margin_bottom.svg'));
            this.marginContinueReadingButton.push(new RadioButton('left',
                buttonStyles.margin.left, assetsUrl + 'images/icons/margin_left.svg'));
        }

        if (this.widget.settings[this.deviceType].widget_settings.general.text_margin.top === undefined) {
            this.widget.settings[this.deviceType].widget_settings.general.text_margin = {
                top: 'auto',
                right: 'auto',
                bottom: 'auto',
                left: 'auto'
            };
        }


        this.marginText = [];
        this.marginText.push(new RadioButton('top',
            this.widget.settings[this.deviceType].widget_settings.general.text_margin.top,
            assetsUrl + 'images/icons/margin_top.svg'));
        this.marginText.push(new RadioButton('right',
            this.widget.settings[this.deviceType].widget_settings.general.text_margin.right,
            assetsUrl + 'images/icons/margin_right.svg'));
        this.marginText.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].widget_settings.general.text_margin.bottom,
            assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginText.push(new RadioButton('left',
            this.widget.settings[this.deviceType].widget_settings.general.text_margin.left,
            assetsUrl + 'images/icons/margin_left.svg'));


        const backgroundStyles = this.widget.settings[this.deviceType].additional_settings;
        this.backgroundPadding = [];
        if (backgroundStyles.padding !== null) {
            this.backgroundPadding.push(new RadioButton('top', backgroundStyles.padding.top,
                assetsUrl + 'images/icons/padding_top.svg'));
            this.backgroundPadding.push(new RadioButton('right', backgroundStyles.padding.right,
                assetsUrl + 'images/icons/padding_right.svg'));
            this.backgroundPadding.push(new RadioButton('bottom', backgroundStyles.padding.bottom,
                assetsUrl + 'images/icons/padding_bottom.svg'));
            this.backgroundPadding.push(new RadioButton('left', backgroundStyles.padding.left,
                assetsUrl + 'images/icons/padding_left.svg'));

        }


        this.marginAdditionalText = [];
        this.marginAdditionalText.push(new RadioButton('top',
            this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.top,
            assetsUrl + 'images/icons/margin_top.svg'));
        this.marginAdditionalText.push(new RadioButton('right',
            this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.right,
            assetsUrl + 'images/icons/margin_right.svg'));
        this.marginAdditionalText.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.bottom,
            assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginAdditionalText.push(new RadioButton('left',
            this.widget.settings[this.deviceType].widget_settings.additional_text.text_margin.left,
            assetsUrl + 'images/icons/margin_left.svg'));

        this.marginButtons = [];

        this.marginButtons.push(new RadioButton('top',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.top,
            assetsUrl + 'images/icons/margin_top.svg'));
        this.marginButtons.push(new RadioButton('right',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.right,
            assetsUrl + 'images/icons/margin_right.svg'));
        this.marginButtons.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.bottom,
            assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginButtons.push(new RadioButton('left',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.margin.bottom,
            assetsUrl + 'images/icons/margin_left.svg'));


        this.shadowButtons = [];
        this.shadowButtons.push(new RadioButton('x',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.x, '', 'X:'));
        this.shadowButtons.push(new RadioButton('y',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.y, '', 'Y:'));
        this.shadowButtons.push(new RadioButton('b',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design.shadow.b, '', 'B:'));

        this.radioButtons = [];
        this.radioButtons.push(new RadioButton('left', 'left', '/assets/images/icons/left.svg'));
        this.radioButtons.push(new RadioButton('center', 'center', '/assets/images/icons/center.svg'));
        this.radioButtons.push(new RadioButton('right', 'right', '/assets/images/icons/right.svg'));

        this.allRadiusesButton = [];
        this.allRadiusesButton.push(new RadioButton('all', 0, '/assets/images/icons/radius_AllTogether.svg'));

        this.radiusButtons = [];
        this.radiusButtons.push(new RadioButton('active', false, '/assets/images/icons/radius_disable.svg'));
        this.radiusButtons.push(new RadioButton('disabled', true, '/assets/images/icons/radius_enable.svg'));

        this.specificRadiusButtons = [];
        this.specificRadiusButtons.push(new RadioButton('tl',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.tl,
            '/assets/images/icons/radius_LeftTop.svg'));
        this.specificRadiusButtons.push(new RadioButton('tr',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.tr,
            '/assets/images/icons/radius_RightTop.svg'));
        this.specificRadiusButtons.push(new RadioButton('br',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.br,
            '/assets/images/icons/radius_LeftBottom.svg'));
        this.specificRadiusButtons.push(new RadioButton('bl',
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius.bl,
            '/assets/images/icons/radius_LeftBottom.svg'));


        this.paddingMonetization = [];
        this.paddingMonetization.push(new RadioButton('top',
            this.widget.settings[this.deviceType].payment_settings.design.padding.top, assetsUrl + 'images/icons/padding_top.svg'));
        this.paddingMonetization.push(new RadioButton('right',
            this.widget.settings[this.deviceType].payment_settings.design.padding.right, assetsUrl + 'images/icons/padding_right.svg'));
        this.paddingMonetization.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].payment_settings.design.padding.bottom, assetsUrl + 'images/icons/padding_bottom.svg'));
        this.paddingMonetization.push(new RadioButton('left',
            this.widget.settings[this.deviceType].payment_settings.design.padding.left, assetsUrl + 'images/icons/padding_left.svg'));


        this.marginMonetization = [];
        this.marginMonetization.push(new RadioButton('top',
            this.widget.settings[this.deviceType].payment_settings.design.margin.top,
            assetsUrl + 'images/icons/margin_top.svg'));
        this.marginMonetization.push(new RadioButton('right',
            this.widget.settings[this.deviceType].payment_settings.design.margin.right,
            assetsUrl + 'images/icons/margin_right.svg'));
        this.marginMonetization.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].payment_settings.design.margin.bottom,
            assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginMonetization.push(new RadioButton('left',
            this.widget.settings[this.deviceType].payment_settings.design.margin.left,
            assetsUrl + 'images/icons/margin_left.svg'));

        this.marginMonetizationHeadlineText = [];
        this.marginMonetizationHeadlineText.push(new RadioButton('top',
            this.widget.settings[this.deviceType].payment_settings.monetization_title.margin.top,
            assetsUrl + 'images/icons/margin_top.svg'));
        this.marginMonetizationHeadlineText.push(new RadioButton('right',
            this.widget.settings[this.deviceType].payment_settings.monetization_title.margin.right,
            assetsUrl + 'images/icons/margin_right.svg'));
        this.marginMonetizationHeadlineText.push(new RadioButton('bottom',
            this.widget.settings[this.deviceType].payment_settings.monetization_title.margin.bottom,
            assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginMonetizationHeadlineText.push(new RadioButton('left',
            this.widget.settings[this.deviceType].payment_settings.monetization_title.margin.left,
            assetsUrl + 'images/icons/margin_left.svg'));


        this.fontFamilyDropdownButtons = [];
        this.fontFamily.forEach(fontFamily => {
            this.fontFamilyDropdownButtons.push({title: fontFamily, value: fontFamily});
        });


        this.availableSubtypes = [];
        if (this.widgetSettings != null) {
            this.widgetSettings.forEach((x: any) => {
                    this.availableSubtypes.push(new DropdownItem(x.name, x.name));
                    if (this.activeWidgetSettings === undefined) {
                        this.activeWidgetSettings = x.name;
                        this.updateCurrentWidgetSettings(x.name);
                    }
                }
            );
        }

    }

    writeRadiusValue(value) {
        this.specificRadiusButtons.forEach(rb => {
            this.widget.settings[this.deviceType].widget_settings.call_to_action.default.design.radius[rb.name] = value;
        });
        this.specificRadiusButtons.forEach(button => {
            button.value = value;
        });
    }

    calcSpecificRadius() {
        let firstValue;
        let result = false;
        this.specificRadiusButtons.forEach(rb => {
            firstValue = firstValue ? firstValue : rb.value;
            if (rb.value !== firstValue) {
                result = true;
            }
        });
        this.setSpecificRadius(result);
    }

    setSpecificRadius(value: boolean) {
        this.specificRadius = value;
    }

    changeUploadedFile(event) {
        this.widget.settings[this.deviceType].widget_settings.general.background.image = event;
    }

    // handle change in columns_count and create or delete columns
    public updateColumnsCount(event: any) {
        while (this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count !== event && (!!event || event === 0)) {
            if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count > event) {
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count--;
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns.pop();
            }
            if (this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count < event) {
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count++;
                this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns.push(
                    {
                        header: {
                            enable: false,
                            text: 'BEST OPTION',
                            color: '#00f',
                        },
                        title: 'Title',
                        active_benefits: [],
                        show_benefits: [],
                        custom_price: false,
                        count_of_options: 2,
                        count_of_options_in_row: 2,
                        options: [
                            {value: 30},
                            {value: 20}
                        ],
                    }
                );
            }
        }
    }

    // add new benefit with new id
    addNewBenefit() {
        let benefits = this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefits;
        const maxId = Math.max(...benefits.map(o => o.id), 0);
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefits.push({
            id: maxId + 1,
            text: 'new benefit'
        });
    }

    // delete benefit and remove reference to this benefit in show_benefits and active_benefits
    public deleteBenefit(benefit) {
        this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefits =
            this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefits.filter(singleItem => {
                    return benefit.id !== singleItem.id;
                }
            );
        let columns = this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns;
        columns.forEach(column => {
            ['show_benefits', 'active_benefits'].forEach(benefitType => {
                column[benefitType] = column[benefitType].filter(singleItem => {
                        return benefit.id !== singleItem.id;
                    }
                );
            });
        });
    }

    // called when item from show_benefits is removed. Remove this item also in active_benefit to prevent 'is active but not showed' state
    updateActiveItems(column) {
        column.active_benefits = column.active_benefits.filter(singleItem => {
            const deleted = column.show_benefits.find(
                item => {
                    return item.id === singleItem.id;
                }
            );
            return deleted !== undefined;
        });
    }

    getBenefits(column) {
        const benefits = JSON.parse(JSON.stringify(this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefits));
        return JSON.parse(JSON.stringify(benefits));
    }


    public getShowBenefits(column) {
        return JSON.parse(JSON.stringify(column.show_benefits));
    }

    // update benefit text in show_benefits and active_benefits arrays
    updateBenefit(benefit, event) {
        let columns = this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns;
        columns.forEach(column => {
            ['show_benefits', 'active_benefits'].forEach(benefitType => {
                column[benefitType] = column[benefitType].map(item => {
                    let updatedBenefit = column[benefitType].find(finding => {
                        return (finding.id === benefit.id) && (item.id === benefit.id);
                    });
                    if (updatedBenefit) {
                        return {id: updatedBenefit.id, text: event}
                    } else {
                        return item;
                    }
                });
            });
        });
    }

    public updateCurrentWidgetSettings($event: any) {
        this.widget.widget_type.active_subtype = this.widget.widget_type.widgetSubtypes.find(
            x => {
                return x.name = $event;
            }
        );
        return this.widget.settings = this.widgetSettings.find((x: any) => {
            return x.name === $event;
        })['settings'];
    }

}
