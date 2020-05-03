import {ChangeDetectorRef, Component, Input, OnInit} from '@angular/core';
import {Widget} from '../../models';
import {Subscription} from 'rxjs';
import {devices, paymentMethods, paymentTypes, widgetTypes} from '../../../core/models';
import {environment} from '../../../../../environments/environment';
import {PreviewService} from '../../services';
import {ConvertHexService} from '../../../core/services';
import {
    changePaymentOptionsColumn,
    createBankButtonsColumn,
    donationInProgressColumn,
    getEnvs,
    handleSubmitColumn, paymentCountryTypeColumn,
    setActiveButtonMonthlyColumn,
    setBankButtonColumn,
    showSecondStepColumn,
    stepColumn,
    trackEmailOnChangeColumn,
    trackInsertValueColumn,
    validateFormColumn
} from './monetization-column';
import {paymentCountryTypeClassic} from '../preview-monetization/monetization-classic';

@Component({
    selector: 'app-preview-monetization-column',
    templateUrl: './preview-monetization-column.component.html',
    styleUrls: ['./preview-monetization-column.component.scss']
})
export class PreviewMonetizationColumnComponent implements OnInit {

    @Input()
    public widget = new Widget();

    @Input()
    public deviceType;

    deviceTypes = devices;

    private subscription: Subscription;
    public paymentTypes = paymentTypes;
    public environment = environment;
    public fontFamilyPreview = '';
    paymentMethods = paymentMethods;

    constructor(private previewService: PreviewService, private convertHex: ConvertHexService,
                private ref: ChangeDetectorRef) {
    }

    ngOnInit() {
        this.subscription = this.previewService.updatePreviewChange.subscribe(update => {
            this.ref.detectChanges();
            this.recreateStyles();
        });

        this.recreateStyles();
    }

    ngOnDestroy() {
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
    }

    recreateStyles() {
        const parent = document.getElementById('styles');

        const globalStyles = parent.getElementsByClassName('monetizationStyles') as any;
        for (const style of globalStyles) {
            style.remove();
        }
        const style = document.createElement('style');
        style.setAttribute('class', 'monetizationStyles');

        style.type = 'text/css';

        const css = `
            [id^=cr0wdfundingToolbox] .active > .cft--monatization--donation-button{
                    color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color}!important;
                    background-color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.background}!important;
                    border-color: #32a300;
                }

            [id^=cr0wdfundingToolbox] .only-not-active, [id^=cr0wdfundingToolbox] .only-active{
            display:inline;
            }
           [id^=cr0wdfundingToolbox] .cft--monatization--donation-button-container.active .only-not-active{
               visibility: hidden;
            }
           [id^=cr0wdfundingToolbox] .cft--monatization--donation-button-container:not(.active) .only-active{
               visibility: hidden;
           }

            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
             }

            [id^=cr0wdfundingToolbox] .container{
                margin-right: auto;
                margin-left: auto;
                padding-left: 14px;
                padding-right: 14px;
            }
            @media (min-width: 768px) {
              [id^=cr0wdfundingToolbox] .container {
                  width: 750px; }
            }
            @media (min-width: 992px) {
               [id^=cr0wdfundingToolbox] .container {
                  width: 970px; }
            }
            @media (min-width: 1200px) {
               [id^=cr0wdfundingToolbox] .container {
                   width: 1170px; }
               }

            [id^=cr0wdfundingToolbox] .cft--monatization--column-container__benefits .benefit__row.active .benefit__svg .cross{
               display: none;
            }

            [id^=cr0wdfundingToolbox] .cft--monatization--column-container__benefits .benefit__row:not(.active) .benefit__svg .check{
               display: none;
            }

            [id^=cr0wdfundingToolbox] .cft--monatization--column-container__benefits .benefit__row:not(.active) .benefit__text {
                color: #888c91;
            }

            [id^=cr0wdfundingToolbox] .cft--monatization--column-wrapper.header--active .cft--monatization--header::after{
              content: '';
              position: absolute;
              left: 0;
              top: 100%;
              width: 0;
              height: 0;
              border-right: 20px solid transparent;
              border-top: 20px solid;
              clear: both;
              z-index: 500;
            }

            [id^=cr0wdfundingToolbox] .cft--monatization--column-wrapper.active .cft--monatization--column-container{
               border: 1px solid !important;
               border-color: inherit;
               background-color: transparent !important;
            }
            [id^=cr0wdfundingToolbox] input[type="checkbox"]{
              position: absolute;
              opacity: 0;
              cursor: pointer;
              height: 0;
              width: 0;
            }
            [id^=cr0wdfundingToolbox] input[type="checkbox"] + .checkmark {
                position: absolute;
                top: 1px;
                left: 0;
                height: 16px;
                width: 16px;
                background-color: #d0d3d6;
                -webkit-border-radius: 3px;
                -moz-border-radius: 3px;
                border-radius: 3px;
                -webkit-transition: .3s;
                -moz-transition: .3s;
                -ms-transition: .3s;
                -o-transition: .3s;
                transition: .3s;
            }
            [id^=cr0wdfundingToolbox] input[type="checkbox"] + .checkmark:after {
                display: none;
                position: absolute;
                content: '';
                left: 6px;
                top: 2px;
                width: 4px;
                height: 8px;
                border: solid white;
                border-width: 0 1px 1px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            [id^=cr0wdfundingToolbox] input[type="checkbox"]:checked  + .checkmark {
                background-color: #158eea;
            }
            [id^=cr0wdfundingToolbox] input[type="checkbox"]:checked  + .checkmark:after {
                display: block;
            }
            [id^=cr0wdfundingToolbox] input.cft--monatization--donation-input-price.hide-arrows::placeholder{
               font-size:12px;
               text-align:center;
               color: inherit;
            }
        `
        ;

        style.appendChild(document.createTextNode(css));
        parent.appendChild(style);

        const parentScript = document.getElementById('scripts');
        for (const script of parentScript.getElementsByClassName('previewScripts') as any) {
            script.remove();
        }

        const script = document.createElement('script');
        script.setAttribute('class', 'previewScripts');
        script.type = 'text/javascript';
        script.charset = 'utf-8';
        script.setAttribute('script', 'text/javascript');

        // change path in getEnvs and add domain if there is relative path in envs
        const isAbsolute = new RegExp('^([a-z]+://|//)', 'i');
        let absolutePath;
        if (isAbsolute.test(this.environment.apiUrl)) {
            absolutePath = this.environment.apiUrl;
        } else {
            absolutePath = window.location.origin + this.environment.apiUrl;
        }

        const scriptGetEnvs = getEnvs.toString().replace('apiPublicUrlValue', absolutePath);

        script.appendChild(document.createTextNode(scriptGetEnvs + '\n'));


        script.appendChild(document.createTextNode(setActiveButtonMonthlyColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(validateFormColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(handleSubmitColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(stepColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(createBankButtonsColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(showSecondStepColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(donationInProgressColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(setBankButtonColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(trackEmailOnChangeColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(trackInsertValueColumn.toString() + '\n'));
        script.appendChild(document.createTextNode(paymentCountryTypeColumn.toString() + "\n"));
        script.appendChild(document.createTextNode(changePaymentOptionsColumn.toString() + "\n"));

        parentScript.appendChild(script);

    }

    getButtonStyles() {
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        const boxShadow = ctaStyles.default.design.shadow.x + 'px ' +
            ctaStyles.default.design.shadow.y + 'px ' +
            ctaStyles.default.design.shadow.b + 'px ' + '0px ' +
            this.convertHex.convert((ctaStyles.default.design.shadow.color == undefined) ? '#000' : ctaStyles.default.design.shadow.color);

        const defaultStyles = {
            height: '46px',
            width: ctaStyles.default.width,
            padding: this.addPx(ctaStyles.default.padding.top) + ' ' +
                this.addPx(ctaStyles.default.padding.right) + ' ' +
                this.addPx(ctaStyles.default.padding.bottom) + ' ' +
                this.addPx(ctaStyles.default.padding.left),
            fontFamily: ctaStyles.default.fontSettings.fontFamily,
            fontWeight: ctaStyles.default.fontSettings.fontWeight,
            textAlign: ctaStyles.default.fontSettings.alignment,
            color: ctaStyles.default.fontSettings.color,
            fontSize: ctaStyles.default.fontSettings.fontSize + 'px',
            display: this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display || 'block',
            'background-color': (ctaStyles.default.design.fill.active) ? this.convertHex.convert(ctaStyles.default.design.fill.color)
                : 'transparent',
            border: (ctaStyles.default.design.border.active) ? ctaStyles.default.design.border.size + 'px solid ' +
                this.convertHex.convert(ctaStyles.default.design.border.color) : 'none',
            '-webkit-box-shadow': (ctaStyles.default.design.shadow.active) ? boxShadow : 'none',
            '-moz-box-shadow': (ctaStyles.default.design.shadow.active) ? boxShadow : 'none',
            'box-shadow': (ctaStyles.default.design.shadow.active) ? boxShadow : 'none',

            '-webkit-border-top-left-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tl + 'px' : 0,
            '-moz-border-radius-topleft': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tl + 'px' : 0,
            'border-top-left-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tl + 'px' : 0,
            '-webkit-border-top-right-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tr + 'px' : 0,
            '-moz-border-radius-topright': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tr + 'px' : 0,
            'border-top-right-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.tr + 'px' : 0,
            '-webkit-border-bottom-left-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.bl + 'px' : 0,
            '-moz-border-radius-bottomleft': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.bl + 'px' : 0,
            'border-bottom-left-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.bl + 'px' : 0,
            '-webkit-border-bottom-right-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.br + 'px' : 0,
            '-moz-border-radius-bottomright': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.br + 'px' : 0,
            'border-bottom-right-radius': (ctaStyles.default.design.radius.active) ? ctaStyles.default.design.radius.br + 'px' : 0,
            cursor: 'pointer',
            transition: '0.5s all',
            'text-decoration': 'none'
        };

        if (this.widget.widget_type.method == widgetTypes.fixed.name) {
            defaultStyles['display'] = 'inline-block';
        }

        const result = {...defaultStyles};
        return result;
    }


    private addPx(input) {
        return isNaN(input) ? input : input + 'px';
    }

    getEmailButtonContainerStyles(displayNone = false) {
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer;
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const containerStyles = {
            display: 'inline-block',
            'vertical-align': 'top',
            position: additionalSettings.position,
            // top: additionalSettings.top,
            // right: additionalSettings.right,
            // bottom: additionalSettings.bottom,
            // left: additionalSettings.left,
            textAlign: ctaStyles.default.fontSettings.alignment,
            margin: this.addPx(ctaStyles.default.margin.top) + ' ' +
                this.addPx(ctaStyles.default.margin.right) + ' ' +
                this.addPx(ctaStyles.default.margin.bottom) + ' ' +
                this.addPx(ctaStyles.default.margin.left),
        };

        if (this.widget.widget_type.method == widgetTypes.fixed.name) {
            containerStyles['width'] = this.widget.settings[this.deviceType].additional_settings.buttonContainer.width + '%';
            containerStyles['float'] = 'left';
        }
        if (displayNone) {
            containerStyles.display = 'none';
        }

        return containerStyles;
    }

    getButtonContainerStyles() {
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer;
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const containerStyles = {
            display: this.widget.settings[this.deviceType].widget_settings.call_to_action.default.display,
            width: additionalSettings.width,
            position: additionalSettings.position,
            // top: additionalSettings.top,
            // right: additionalSettings.right,
            // bottom: additionalSettings.bottom,
            // left: additionalSettings.left,
            textAlign: ctaStyles.default.fontSettings.alignment,
            margin: this.addPx(ctaStyles.default.margin.top) + ' ' +
                this.addPx(ctaStyles.default.margin.right) + ' ' +
                this.addPx(ctaStyles.default.margin.bottom) + ' ' +
                this.addPx(ctaStyles.default.margin.left),
        };

        if (this.widget.widget_type.method == widgetTypes.fixed.name) {
            containerStyles['width'] = this.widget.settings[this.deviceType].additional_settings.buttonContainer.width + '%';
            containerStyles['float'] = 'left';
        }

        return containerStyles;
    }

    getRowStyle(hidden: false) {
        const defaultStyle = {
            'display': '-ms-flexbox',
            '-ms-flex-wrap': 'wrap',
            'flex-wrap': 'wrap',
            'margin-right': '-7px',
            'margin-left': '-7px'
        };

        const defaultStyleDisplay2 = {
            'display': 'flex'
        };

        const result = {...defaultStyle, ...defaultStyleDisplay2};

        return result;
    }

    getRowStyleDonationButton() {

        const defaultStyle = {
            'display': '-ms-flexbox',
            '-ms-flex-wrap': 'wrap',
            'flex-wrap': 'wrap',
            'width': '100%',
            'padding': '21px 14px 20px'
        };

        const defaultStyleDisplay2 = {
            'display': 'flex'
        };

        const result = {...defaultStyle, ...defaultStyleDisplay2};

        return result;
    }

    getDonationButtonStyle() {
        return {
            'min-height': '40px',
            'padding': '5px',
            'border': '1px solid #bdc2c6',
            'border-radius': '2px',
            'box-shadow': '0 1px 2px 0 rgba(91,107,120,.2)',
            'flex': '1',
            'display': 'flex',
            'flex-direction': 'column',
            'justify-content': 'center',
            'cursor': 'pointer',
            'background-color': this.widget.settings[this.deviceType].payment_settings.price_background_color,
            'color': this.widget.settings[this.deviceType].payment_settings.price_text_color,
        };

    }


    getMonetizationContainerStyle() {
        const paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            fontFamily: this.widget.settings[this.deviceType].payment_settings.monetization_title.fontSettings.fontFamily,
            'box-shadow': '0 8px 24px 0 rgba(74, 26, 8, 0.2)',
            color: paymentDesign.text_color,
            'width': paymentDesign.width,
            'height': paymentDesign.height,
            'background-color': paymentDesign.background_color,
            margin: this.addPx(paymentDesign.margin.top) + ' ' +
                this.addPx(paymentDesign.margin.right) + ' ' +
                this.addPx(paymentDesign.margin.bottom) + ' ' +
                this.addPx(paymentDesign.margin.left),
            padding: this.addPx(paymentDesign.padding.top) + ' ' +
                this.addPx(paymentDesign.padding.right) + ' ' +
                this.addPx(paymentDesign.padding.bottom) + ' ' +
                this.addPx(paymentDesign.padding.left),
        };
    }

    ctaReplaced() {
        return this.widget.settings[this.deviceType].payment_settings.active;
    }

    getMembershipStyle() {
        return {
            'padding-left': '50px',
            'margin': '12px 0'
        };
    }

    getLabelStyle() {
        return {
            'font-size': '11px',
            'font-weight': '700',
            'line-height': '15px',
            width: '100%',
            display: 'block',
            color: 'inherit',
            'text-align': 'left',
            'padding-top': '24px',
            'padding-bottom': '10px'
        };
    }

    getFormGroupStyle() {
        return {
            'display': 'inline-block',
            'padding-top': '6px',
            'width': '100%',
            'text-align': 'center'
        };
    }

    getEmailDonateStyle() {
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        return {
            padding: this.addPx(ctaStyles.default.padding.top - 1) + ' ' +
                '22px ' +
                this.addPx(ctaStyles.default.padding.bottom - 1) + ' ' +
                '22px',
            fontFamily: ctaStyles.default.fontSettings.fontFamily,
            fontWeight: ctaStyles.default.fontSettings.fontWeight,
            fontSize: ctaStyles.default.fontSettings.fontSize + 'px',
            width: '300px',
            'max-width': '100%',
            height: '46px',
            'border-radius': '3px',
            border: 'solid 1px #d0d3d6',
            background: '#fafafb'
        };
    }

    getDonationInputPriceStyle() {
        return {
            'font-size': '18px',
            'font-weight': '700',
            'line-height': '1',
            'padding': '1px 0',
            'text-align': 'center',
            'outline': 'none',
            'border': 'none',
            'background': 'transparent',
            'width': '100%',
            'color': 'inherit'
        };
    }

    getErrorStyle() {
        return {
            'display': 'none',
            'font-size': '14px',
            'color': 'red',
            'margin-top': '3px'
        };
    }

    getColumnWrapperStyle(column) {
        // for mobile device - only 1 column on full width in row
        if (this.deviceType === this.deviceTypes.mobile.name) {
            return {
                'flex': '0 0 100%',
                'max-width': '100%',
                'padding': '6px 7px',
                'width': '100%',
                'min-height': '1px',
                'box-sizing': 'border-box',
                'display': 'flex',
                'flex-direction': 'column',
                'color': column.header.background_color,
            };
        }
        return {
            'flex': `0 0 ${100 / this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count}%`,
            'max-width': `${100 / this.widget.settings[this.deviceType].payment_settings.monthly_prices.columns_count}%`,
            'padding': '6px 7px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column',
            'color': column.header.background_color,
        };
    }

    getColumnContainerStyle() {
        return {
            'display': 'flex',
            'flex-direction': 'column',
            'align-content': 'space-between',
            'position': 'relative',
            'background-color': '#F0F3F6',
            'height': '100%',
            'border-width': '1px solid transient',
            'border': '1px solid transparent'
        };

    }

    getColumnTitleStyle() {
        if (this.deviceType === this.deviceTypes.desktop.name) {
            return {
                'text-align': 'center',
                'padding': '40px 12px 60px',
                'font-size': '19px',
                'font-weight': 'bold'
            };
        }
        else { return {
            'text-align': 'center',
            'padding': '28px 12px 18px',
            'font-size': '19px',
            'font-weight': 'bold'
        };
        }
    }


    getMonatizationDonationButtonStyle(monthlyOrOneTime) {
        return {
            'flex': `0 0 ${100 / this.widget.settings[this.deviceType].payment_settings[monthlyOrOneTime].columns_count}%`,
            'max-width': `${100 / this.widget.settings[this.deviceType].payment_settings[monthlyOrOneTime].columns_count}%`,
            'padding': '6px 7px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column'
        };
    }

    getMonatizationButtonInColumnStyle(column) {
        return {
            'flex': `0 0 ${100 / column.count_of_options_in_row}%`,
            'max-width': `${100 / column.count_of_options_in_row}%`,
            'padding': '6px 7px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column'
        };
    }

    getMonatizationFrequencyButtonStyle() {
        return {
            'flex': '0 0 50%',
            'max-width': '50%',
            'padding': '6px 7px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column'
        };
    }


    getDonationButtonPriceStyle() {
        return {
            'font-size': '18px',
            'font-weight': '700',
            'line-height': '1',
            'padding': '1px 0',
            'text-align': 'center'
        };
    }

    getDonationButtonPeriodicityStyle() {
        return {
            'font-size': '12px',
            'text-align': 'center'
        };
    }

    additionalLinksStyle() {
        return {
            'text-align': 'center',
            padding: '16px'
        };
    }

    getMonetizationTitleStyles() {
        const title = this.widget.settings[this.deviceType].payment_settings.monetization_title;
        if (title) {
            this.usedFontFamily(title.fontSettings.fontFamily);
            return {
                'background-color': title.fontSettings.backgroundColor,
                fontFamily: title.fontSettings.fontFamily,
                'font-weight': title.fontSettings.bold,
                'font-size': title.fontSettings.fontSize + 'px',
                margin: this.addPx(title.margin.top) + ' ' +
                    this.addPx(title.margin.right) + ' ' +
                    this.addPx(title.margin.bottom) + ' ' +
                    this.addPx(title.margin.left),
                color: title.textColor,
                textAlign: title.alignment,
                width: '100%',
            };
        } else {
            return {};
        }
    }

    private usedFontFamily(fontFamily) {
        const tempArray = this.fontFamilyPreview.split('|');
        if (tempArray.indexOf(fontFamily) === -1) {
            if (fontFamily !== undefined) {
                tempArray.push(fontFamily);
            }
        }
        this.fontFamilyPreview = '';
        tempArray.forEach(font => {
            this.fontFamilyPreview +=
                (this.fontFamilyPreview !== '') ?
                    '|' + font : font;
        });
    }

    public getButtonPriceInfoStyle() {
        return {
            display: 'inline-block',
            width: '80%',
            textAlign: 'left',
            'vertical-align': 'top'
        };
    }

    public getButtonPriceInfoTitleStyle() {
        return {
            display: 'inline-block',
            padding: '20px 20px 0'
        };
    }

    public getButtonPriceInfoBenefitsStyle() {
        return {
            'padding-left': '30px',
            'color': 'black',
            'font-weight': 'normal'
        };
    }

    public getButtonPriceStyle() {
        return {
            display: 'inline-block',
            width: '20%',
            'vertical-align': 'top'
        };

    }

    public getButtonPriceValueStyle() {
        return {
            'font-size': '40px'
        };

    }

    public getButtonPriceDescriptionStyle() {

    }

    public getButtonPriceInfoTitleTextStyle() {
        return {
            'padding-left': '20px',
            display: 'inline-block',
        };
    }

    public isBenefitActive(column, benefit): boolean {
        return !!column.active_benefits.find(item => {
                return item && benefit && (item.id === benefit.id);
            }
        );

    }

    public getBenefitStyle() {
        return {
            display: 'block',
            padding: '4px 20px 5px 12px',
            'font-size': '14px'
        };
    }

    public getBenefitSvgStyle() {
        return {
            'padding-top': '4px',
            float: 'left'
        };
    }

    getBenefitTextStyle() {
        return {
            'padding-left': '20px'
        };
    }

    getHeaderStyle(column) {
        if (column.header.enable) {
            return {
                'text-align': 'center',
                'background-color': column.header.background_color,
                'color': column.header.background_color,
                'position': 'relative',
                'border-top-left-radius': '3px',
                'border-top-right-radius': '3px'
            };
        }
    }

    getHeaderTextStyle(column) {
        return {
            'color': column.header.color,
        };
    }

    public getColumnContainerBenefitsStyle(column) {
        return {
            'border-color': column.header.color,
            'flex': '1'
        };
    }

    public columnWrapperIsActive(column): boolean {
        return column && column.options && column.options.size !== 0 && column.options.find(option => {
            return this.widget.settings[this.deviceType].payment_settings.default_price.monthly_value == option.value;
        }) !== undefined;
    }

    public getColumnContentStyle() {
        return {
            color: this.widget.settings[this.deviceType].payment_settings.monetization_title.textColor,
            display: 'flex',
            'flex-direction': 'column',
            height: '100%'
        };
    }

    cardPayLogoStyles() {
        return {
            'display': 'block',
            'margin': '30px auto',
            'max-width': '194px'
        };
    }
}
