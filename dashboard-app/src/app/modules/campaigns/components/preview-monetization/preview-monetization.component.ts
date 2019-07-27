import {ChangeDetectorRef, Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';
import {Subscription} from 'rxjs';
import {
    changePaymentOptions,
    createBankButtons,
    donationInProgress,
    getEnvs,
    handleSubmit,
    monthlyPayment,
    oneTimePayment,
    setActiveButtonMonthly,
    setActiveButtonOneTime,
    setBankButton,
    showSecondStep,
    step,
    trackEmailOnChange,
    trackInsertValue,
    validateForm
} from './monetization-classic';
import {Widget} from '../../models';
import {PreviewService} from '../../services';
import {ConvertHexService} from '../../../core/services';
import {paymentTypes, widgetTypes} from '../../../core/models';
import {environment} from '../../../../../environments/environment';

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
    public fontFamilyPreview ='';

    constructor(private previewService: PreviewService, private convertHex: ConvertHexService,
                private ref: ChangeDetectorRef) {
    }

    ngOnInit() {
        this.subscription = this.previewService.updatePreviewChange.subscribe(update => {
            this.ref.detectChanges();
            this.recreateStyles();
        })

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

        let globalStyles = parent.getElementsByClassName("monetizationStyles") as any;
        for (let style of globalStyles) {
            style.remove()
        }
        let style = document.createElement('style');
        style.setAttribute("class", "monetizationStyles");

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
                
            [id^=cr0wdfundingToolbox] .cft--monatization--hidden{
                display: none!important
             }
            `;

        style.appendChild(document.createTextNode(css));
        parent.appendChild(style);

        const parentScript = document.getElementById('scripts');
        for (let script of parentScript.getElementsByClassName("previewScripts") as any) {
            script.remove()
        }

        let script = document.createElement('script');
        script.type = 'text/javascript';
        script.charset = 'utf-8';
        script.setAttribute("class", "previewScripts");

        const scriptActiveButtonMonthly = setActiveButtonMonthly.toString().replace('var target;',
            'let target = ' + this.widget.settings[this.deviceType].payment_settings.monthly_prices.benefit.value) + ';';

        const scriptActiveButtonOneTime = setActiveButtonOneTime.toString().replace('var target;',
            'let target = ' + this.widget.settings[this.deviceType].payment_settings.once_prices.benefit.value) + ';';

        script.appendChild(document.createTextNode(scriptActiveButtonMonthly + '\n'));
        script.appendChild(document.createTextNode(scriptActiveButtonOneTime + '\n'));


        script.appendChild(document.createTextNode(validateForm.toString() + '\n'));
        script.appendChild(document.createTextNode(oneTimePayment.toString() + '\n'));
        script.appendChild(document.createTextNode(monthlyPayment.toString() + '\n'));
        script.appendChild(document.createTextNode(trackInsertValue.toString() + '\n'));
        script.appendChild(document.createTextNode(trackEmailOnChange.toString() + '\n'));
        script.appendChild(document.createTextNode(handleSubmit.toString() + '\n'));
        script.appendChild(document.createTextNode(showSecondStep.toString() + '\n'));
        script.appendChild(document.createTextNode(setBankButton.toString() + '\n'));
        script.appendChild(document.createTextNode(createBankButtons.toString() + '\n'));
        script.appendChild(document.createTextNode(donationInProgress.toString() + '\n'));
        script.appendChild(document.createTextNode(changePaymentOptions.toString() + '\n'));
        script.appendChild(document.createTextNode(step.toString() + '\n'));

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
        let ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        let additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        let boxShadow = ctaStyles.default.design.shadow.x + 'px ' +
            ctaStyles.default.design.shadow.y + 'px ' +
            ctaStyles.default.design.shadow.b + 'px ' + '0px ' +
            this.convertHex.convert((ctaStyles.default.design.shadow.color == undefined) ? '#000' : ctaStyles.default.design.shadow.color);
        let defaultStyles = {
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
            //top: additionalSettings.top,
            //right: additionalSettings.right,
            //bottom: additionalSettings.bottom,
            //left: additionalSettings.left,
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
            'margin-right': '-15px',
            'margin-left': '-15px'
        }

        let defaultStyleDisplay2 = {
            'display': 'flex'
        }

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
        }
    }


    getMonetizationContainerStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            color: paymentDesign.text_color,
            'width': paymentDesign.width,
            'height': paymentDesign.height,
            'background-color': paymentDesign.background_color,
            margin: this.addPx(paymentDesign.margin.top) + ' ' +
                this.addPx(paymentDesign.margin.right) + ' ' +
                this.addPx(paymentDesign.margin.bottom) + ' ' +
                this.addPx(paymentDesign.margin.left),
        }
    }
    getMonetizationContainerBodyStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            padding: this.addPx(paymentDesign.padding.top) + ' ' +
                this.addPx(paymentDesign.padding.right) + ' ' +
                this.addPx(paymentDesign.padding.bottom) + ' ' +
                this.addPx(paymentDesign.padding.left),
        }
    }

    getMonetizationHeaderStyle() {
        let paymentDesign = this.widget.settings[this.deviceType].payment_settings.design;
        return {
            color: paymentDesign.text_color,
            'width': '100%',
            'text-align': 'center',
            position: 'relative',
            'height': paymentDesign.height,
        }

    }

    ctaReplaced() {
        return this.widget.settings[this.deviceType].payment_settings.active;
    }

    getMembershipStyle() {
        return {
            'padding-left': '50px',
            'margin': '12px 0'
        }
    }

    getLabelStyle() {
        return {
            width: '100%',
            display: 'block',
            color: 'inherit',
            'text-align': 'left',
            'font-size': '100%'
        }
    }

    getFormGroupStyle() {
        return {
            'padding-top': '16px'
        }
    }

    getEmailDonateStyle() {
        return {
            'color': 'inherit',
            'padding': '6px',
            width: '100%'
        }
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
        }
    }

    getErrorStyle() {
        return {
            'display': 'none',
            'font-size': '14px',
            'color': 'red',
            'margin-top': '3px'
        }
    }

    getMonatizationDonationButtonStyle() {
        return {
            'flex': '0 0 33.33333333%',
            'max-width': '33.33333333%',
            'padding': '6px 15px',
            'width': '100%',
            'min-height': '1px',
            'box-sizing': 'border-box',
            'display': 'flex',
            'flex-direction': 'column'
        }
    }


    getDonationButtonPriceStyle() {
        return {
            'font-size': '18px',
            'font-weight': '700',
            'line-height': '1',
            'padding': '1px 0',
            'text-align': 'center'
        }
    }

    getDonationButtonPeriodicityStyle() {
        return {
            'font-size': '14px',
            'text-align': 'center'
        }
    }

    additionalLinksStyle() {
        return {
            'text-align': 'center',
            padding: '16px'
        }
    }

    getMonetizationTitleStyles() {
        const title = this.widget.settings[this.deviceType].payment_settings.monetization_title;
        if (title) {

            this.usedFontFamily(title.fontSettings.fontFamily);
            return {
                'background-color': title.fontSettings.backgroundColor,
                fontFamily: title.fontSettings.fontFamily,
                'font-weight': title.fontSettings.bold,
                'font-size': title.fontSettings.fontSize+'px',
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

}
