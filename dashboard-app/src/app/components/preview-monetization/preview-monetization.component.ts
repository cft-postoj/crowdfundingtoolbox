import {ChangeDetectorRef, Component, Input, OnInit} from '@angular/core';
import {Widget} from "../../_models/widget";
import {widgetTypes} from "../../_models/enums";
import {ConvertHexService} from "../../_services/convert-hex.service";
import {PreviewService} from "../../_services/preview.service";
import {Subscription} from "rxjs";
import {setActiveButton, validateForm, oneTimePayment, monthlyPayment } from "../preview/landing";

@Component({
    selector: 'app-preview-monetization',
    templateUrl: './preview-monetization.component.html',
    styleUrls: ['./preview-monetization.component.scss']
})
export class PreviewMonetizationComponent implements OnInit {

    @Input()
    public widget = new Widget();

    @Input()
    public deviceType;

    @Input()
    recreateStylesEmitter;

    private subscription: Subscription;

    constructor(private previewService: PreviewService, private convertHex: ConvertHexService,
                private ref: ChangeDetectorRef,) {
    }

    ngOnInit() {

        this.subscription = this.previewService.updatePreviewChange.subscribe(update => {
            this.ref.detectChanges();
            this.recreateStyles();
        })

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
            .active > .cft--monatization--donation-button {
                    color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color};
                    background-color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.background};
                    border-color: #32a300;
                }
        
            .cft--monatization--membership-checkbox.active:before {
                    background-color: ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.background};
                    border: 1px solid #32a300
                }
            .cft--monatization--membership-checkbox.active:after{
                    border: solid ${this.widget.settings[this.deviceType].payment_settings.default_price.styles.color};
                    border-width: 0 2px 2px 0;
                }
                
            .cft--monatization--hidden{
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
        script.setAttribute("class", "previewScripts");
        script.appendChild(document.createTextNode(setActiveButton.toString()+"\n"));

        script.appendChild(document.createTextNode(validateForm.toString()+"\n"));
        script.appendChild(document.createTextNode(oneTimePayment.toString()+"\n"));
        script.appendChild(document.createTextNode(monthlyPayment.toString()+"\n"));

        let targetScript = `
        if (typeof target === 'undefined'){ 
            let target = ${13}
        } else {
            target = ${13}
        }`

        script.appendChild(document.createTextNode(targetScript));
        parentScript.appendChild(script);


    }

    //functions to create inline styles

    getButtonStyles() {
        let ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        let additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        let boxShadow = ctaStyles.default.design.shadow.x + 'px ' +
            ctaStyles.default.design.shadow.y + 'px ' +
            ctaStyles.default.design.shadow.b + 'px ' + '0px ' +
            this.convertHex.convert((ctaStyles.default.design.shadow.color == undefined) ? '#000' : ctaStyles.default.design.shadow.color);

        let defaultStyles = {
            padding: this.addPx(ctaStyles.default.padding.top) + ' ' +
                this.addPx(ctaStyles.default.padding.right) + ' ' +
                this.addPx(ctaStyles.default.padding.bottom) + ' ' +
                this.addPx(ctaStyles.default.padding.left),
            fontFamily: ctaStyles.default.fontSettings.fontFamily,
            fontWeight: ctaStyles.default.fontSettings.fontWeight,
            textAlign: ctaStyles.default.fontSettings.alignment,
            color: ctaStyles.default.fontSettings.color,
            fontSize: ctaStyles.default.fontSettings.fontSize + 'px',
            display: this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display,
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
            textDecoration: 'none'
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
        let additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer;
        let ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        let containerStyles = {
            display: this.widget.settings[this.deviceType].widget_settings.call_to_action.default.display,
            width: additionalSettings.width,
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
        return {
            'max-width': '90%',
            'margin': 'auto'
        }
    }

    ctaReplaced() {
        return this.widget.widget_type.method === widgetTypes.landing.method && this.widget.settings[this.deviceType].payment_settings.active;
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
            display: 'block'
        }
    }

    getFormGroupStyle() {
        return {
            'padding-top': '16px'
        }
    }

    getEmailDonateStyle() {
        return {
            'padding': '6px',
            'margin-top': '12px',
            'width': '320px'
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
}
