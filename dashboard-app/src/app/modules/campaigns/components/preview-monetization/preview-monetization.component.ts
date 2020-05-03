import {ChangeDetectorRef, Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';
import {Subscription} from 'rxjs';
import {
    changePaymentOptionsClassic,
    createBankButtonsClassic,
    donationInProgressClassic,
    getEnvs,
    handleSubmitClassic,
    monthlyPaymentClassic,
    oneTimePaymentClassic,
    setActiveButtonMonthlyClassic,
    setActiveButtonOneTimeClassic,
    setBankButtonClassic,
    showSecondStepClassic,
    stepClassic,
    trackEmailOnChangeClassic,
    trackInsertValueClassic,
    validateFormClassic,
    paymentCountryTypeClassic
} from './monetization-classic';
import {Widget} from '../../models';
import {PreviewService} from '../../services';
import {ConvertHexService} from '../../../core/services';
import {paymentTypes, widgetTypes} from '../../../core/models';
import {environment} from '../../../../../environments/environment';
import {TranslateService} from '@ngx-translate/core';

@Component({
    selector: 'app-preview-monetization',
    templateUrl: './preview-monetization.component.html',
    styleUrls: ['./preview-monetization.component.scss']
})
export class PreviewMonetizationComponent implements OnInit, OnChanges {

    @Input()
    public widget = new Widget();

    @Input()
    public deviceType;

    @Input()
    recreateStylesEmitter;

    private subscription: Subscription;

    public paymentTypes = paymentTypes;

    public environment = environment;
    public fontFamilyPreview = '';


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

    public ngOnChanges(changes: SimpleChanges): void {
        this.ref.detectChanges();
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
                    color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color};
                    background-color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.background};
                    border-color: #32a300;
                }

            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:before{
                    background-color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.background};
                    border: 1px solid ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color}
                }
            [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
                    border: solid ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color};
                    border-width: 0 2px 2px 0;
                }

            [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button:after {
                    content: '€';
                    position: absolute;
                    top: 23px;
                    right: 25px;
                    font-size: 16px;
                    font-family: Arial,Verdana,sans-serif;
                    color: ${this.widget.settings[this.deviceType].payment_settings.design.text_color};
            }
           [id^=cr0wdfundingToolbox] .custom.active .cft--monatization--donation-button input:focus::placeholder {
                    color:transparent;
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
            [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label :checked + span{
               color: #158eea;
            }
            [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label span:after {
                content: "";
                position: absolute;
                left: 0;
                bottom: -14px;
                display: block;
                width: 0;
                height: 1px;
                background-color: #d0d3d6;
                transition: all 0.4s ease;
                width: 100%;
            }
            [id^=cr0wdfundingToolbox] .cft--monetization--nationalPayment label :checked + span:after {
                 background-color: #158eea;
                 height:3px
            }
            [id^=cr0wdfundingToolbox] .cft--benefits--list ul{
                list-style-type: none;
                margin-top: 6px;
                color: rgb(85, 85, 85);
            }
            [id^=cr0wdfundingToolbox] .cft--benefits--list ul b{
               font-size: ${this.widget.settings[this.deviceType].payment_settings.monetization_title.fontSettings.fontSize};
               color: ${this.widget.settings[this.deviceType].payment_settings.monetization_title.textColor};
            }
            [id^=cr0wdfundingToolbox] .cft--benefits--list li:before{
               content: "";
               position: absolute;
               background: url(${environment.assetsUrl}icons/shape-copy.svg) no-repeat center;
               width: 22px;
               height: 14px;
               right: 7px;
               left: 7px;
               margin-top: 4px;
            }
             [id^=cr0wdfundingToolbox] .submitted .cft--min-support--error__active{
                display: block!important;
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
            `;

        style.appendChild(document.createTextNode(css));
        parent.appendChild(style);

        const parentScript = document.getElementById('scripts');
        for (const script of parentScript.getElementsByClassName('previewScripts') as any) {
            script.remove();
        }

        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.charset = 'utf-8';
        script.setAttribute('class', 'previewScripts');

        const scriptActiveButtonMonthly = setActiveButtonMonthlyClassic.toString().replace('var target;',
            'let target = ' + this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefit.value) + ';';

        const scriptActiveButtonOneTime = setActiveButtonOneTimeClassic.toString().replace('var target;',
            'let target = ' + this.widget.settings[this.deviceType].payment_settings.once_prices.benefit.value) + ';';

        script.appendChild(document.createTextNode(scriptActiveButtonMonthly + '\n'));
        script.appendChild(document.createTextNode(scriptActiveButtonOneTime + '\n'));


        script.appendChild(document.createTextNode(validateFormClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(oneTimePaymentClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(monthlyPaymentClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(trackInsertValueClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(trackEmailOnChangeClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(handleSubmitClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(showSecondStepClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(setBankButtonClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(createBankButtonsClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(donationInProgressClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(changePaymentOptionsClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(stepClassic.toString() + '\n'));
        script.appendChild(document.createTextNode(paymentCountryTypeClassic.toString() + '\n'));

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

        parentScript.appendChild(script);
    }

    // functions to create inline styles

    getButtonStyles() {
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        const boxShadow = ctaStyles.default.design.shadow.x + 'px ' +
            ctaStyles.default.design.shadow.y + 'px ' +
            ctaStyles.default.design.shadow.b + 'px ' + '0px ' +
            this.convertHex.convert((ctaStyles.default.design.shadow.color == undefined) ? '#000' : ctaStyles.default.design.shadow.color);
        const defaultStyles = {
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
            display: this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display || 'inline-block',
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

        let result = {...defaultStyles};
        return result;
    }


    private addPx(input) {
        return isNaN(input) ? input : input + 'px';
    }

    getButtonContainerStyles() {
        let additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        let ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        let containerStyles = {
            display: ctaStyles.default.display,
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
        let defaultStyle = {
            'display': '-ms-flexbox',
            '-ms-flex-wrap': 'wrap',
            'flex-wrap': 'wrap',
            'margin-right': '-7px',
            'margin-left': '-7px'
        };

        let defaultStyleDisplay2 = {
            'display': 'flex'
        };

        let result = {...defaultStyle, ...defaultStyleDisplay2};

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
        };
    }

    public getDonationOneTimeButtonStyle() {
        let result = this.getDonationButtonStyle();
        result['padding'] = '15px 5px';
        return result;
    }


    getMonetizationContainerStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            'box-shadow': (this.widget.widget_type.method === widgetTypes.popup.method) ? 'none' :
                ((this.widget.settings[this.deviceType].payment_settings.design.shadowBox) ? '0 8px 24px 0 rgba(74, 26, 8, 0.2)' : 'none'),
            color: paymentDesign.text_color,
            'width': this.addPx(paymentDesign.width),
            'height': this.addPx(paymentDesign.height),
            'background-color': paymentDesign.background_color,
            margin: this.addPx(paymentDesign.margin.top) + ' ' +
                this.addPx(paymentDesign.margin.right) + ' ' +
                this.addPx(paymentDesign.margin.bottom) + ' ' +
                this.addPx(paymentDesign.margin.left),
        };
    }

    getMonetizationContainerBodyStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            padding: this.addPx(paymentDesign.padding.top) + ' ' +
                this.addPx(paymentDesign.padding.right) + ' ' +
                this.addPx(paymentDesign.padding.bottom) + ' ' +
                this.addPx(paymentDesign.padding.left),
        };
    }

    getMonetizationHeaderStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            color: paymentDesign.text_color,
            'width': '100%',
            'text-align': 'center',
            position: 'relative',
            'height': paymentDesign.height,
            'display': (this.widget.settings[this.deviceType].payment_settings.design.stepsPanel) ? 'block' : 'none'
        };

    }

    ctaReplaced() {
        return this.widget.settings[this.deviceType].payment_settings.active;
    }

    getMembershipStyle() {
        // membership will have same width like button by default
        let buttonWidth = 0;
        if (this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width != null) {
            buttonWidth = (this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width.indexOf('%') === -1) ?
                parseInt(this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width.split('px')[0], 10) :
                this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width;
        }

        return {
            'padding-left': '50px',
            'margin': '12px 0',
            'width': (this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width !== '100%' && buttonWidth !== 0) ?
                ((buttonWidth < 700) ? '700px' : buttonWidth + 'px')
                : this.widget.settings[this.deviceType].widget_settings.call_to_action.default.width,
            'max-width': '100%',
            'min-height': '34px',
            'font-height': '16px'

        };
    }

    getLabelStyle() {
        return {
            width: '100%',
            display: 'block',
            color: 'inherit',
            'text-align': 'left',
            'font-size': '100%'
        };
    }

    getFormGroupStyle() {
        return {
            'padding-top': '16px',
            'font-size': '16px'
        };
    }

    getEmailDonateStyle() {
        return {
            'color': '#555',
            'padding': '6px',
            width: '100%',
            'font-size': '16px',
            'height': '45px'

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
            'height': '100%',
            'color': this.widget.settings[this.deviceType].payment_settings.design.text_color,
            'background-color': 'white',
        };
    }

    getDonationInputCustomPriceStyle() {
        let result = this.getDonationInputPriceStyle();
        result['font-size'] = '16px';
        result['font-weight'] = '400';
        result['font-family'] = 'Arial, Verdana, sans-serif;';
        result['-moz-appearance'] = 'textfield';
        return result;
    }

    getErrorStyle() {
        return {
            'display': 'none',
            'font-size': '14px',
            'color': 'red',
            'margin-top': '3px'
        };
    }

    getMonatizationDonationButtonStyle(monthlyOrOneTime) {
        return {
            'flex': `0 0 ${100 / this.widget.settings[this.deviceType].payment_settings[monthlyOrOneTime].count_of_options_in_row}%`,
            'max-width': `${100 / this.widget.settings[this.deviceType].payment_settings[monthlyOrOneTime].count_of_options_in_row}%`,
            'padding': '6px 7px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column',
            'position': 'relative'
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
            'font-size': '14px',
            'text-align': 'center'
        };
    }

    additionalLinksStyle() {
        return {
            'text-align': 'center',
            padding: '16px'
        };
    }

    nationalPaymentStyles() {
        return {
            display: 'inline-block'
        };
    }

    nationalPaymentLabelStyles() {
        return {
            position: 'relative',
            paddingLeft: '35px',
            marginBottom: '12px',
            cursor: 'pointer',
            fontSize: '22px',
            '-webkit-user-select': 'none',
            '-moz-user-select': 'none',
            '-ms-user-select': 'none',
            'user-select': 'none'
        };
    }

    nationalPaymentInputStyles() {

    }

    nationalPaymentCheckmarkStyles() {
        return {
            position: 'absolute',
            top: 0,
            left: 0,
            height: '25px',
            width: '25px',
            backgroundColor: '#eee'
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
                textAlign: title.alignment
            };
        } else {
            return {};
        }
    }

    monthlyBenefitReached() {
        return this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefit.value <=
            this.widget.settings[this.deviceType].payment_settings.default_price.monthly_value;
    }

    oneTimeBenefitReached() {
        return this.widget.settings[this.deviceType].payment_settings.once_prices.benefit.value <=
            this.widget.settings[this.deviceType].payment_settings.default_price.one_time_value;
    }

    cardPayLogoStyles() {
        return {
            'display': 'block',
            'margin': '30px auto',
            'max-width': '194px'
        };
    }

    public changePaymentFrequencyTypeStyles() {
        return {
            'text-decoration': 'underline',
            'color': '#2393e8',
            'font-size': '16px'
        };
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


    public descriptionStyle() {
        return {
            'font-size': '12px',
            'color': '#555'
        };
    }

    public getThirdStepDecriptionStyle() {
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
                'margin-bottom': '0px',
                color: title.textColor,
                textAlign: title.alignment
            };
        } else {
            return {};
        }
    }

    public getThirdStepListStyle() {
        return {
            'position': 'relative',
            'margin-left': '10%',
            'margin-right': '10%',
            'margin-bottom': '24px'
        };
    }
}
