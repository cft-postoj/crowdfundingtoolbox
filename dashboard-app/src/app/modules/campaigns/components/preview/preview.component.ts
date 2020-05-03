import {
    ChangeDetectorRef,
    Component,
    ElementRef,
    EventEmitter,
    Input,
    OnChanges,
    OnDestroy,
    OnInit,
    Output,
    ViewChild
} from '@angular/core';
import {Subject} from 'rxjs/Subject';
import {of, Subscription} from 'rxjs';
import {globalStyles, iframeCode} from '../preview/previewCode';
import {DomSanitizer} from '@angular/platform-browser';
import {Widget} from '../../models';
import {backgroundTypes, devices, RadioButton, widgetTypes} from '../../../core/models';
import {PreviewService, WidgetService} from '../../services';
import {ConvertHexService} from '../../../core/services';
import {monetizationTypes} from '../../models/enums';
import {forEach} from '@angular/router/src/utils/collection';

@Component({
    selector: 'app-preview',
    templateUrl: './preview.component.html',
    styleUrls: ['./preview.component.scss']
})
export class PreviewComponent implements OnInit, OnChanges, OnDestroy {

    @Input()
    public widget: Widget;

    @Input()
    public campaignId;

    @Input()
    public widgets: Widget[] = [];

    @Input()
    public deviceType;

    @Input()
    public show = false;

    @Input() class;

    @Input() generateHTML;

    @Input() createdCampaign;

    @Output()
    public showChange = new EventEmitter();

    @Output() emitHtml = new EventEmitter();

    @Input()
    public loading: boolean;

    public backgroundTypes = backgroundTypes;

    public mouseOver: boolean = false;
    public crowdStyles: string;

    public fontFamilyPreview: string = '';

    @ViewChild('iframe') iframe: ElementRef;
    @ViewChild('preview') previewContent: ElementRef;
    // @ViewChild('pagePreview') pagePreview: ElementRef;
    data$: Subject<string> = new Subject();
    public deviceTypeButtons: RadioButton[] = [];
    public deviceTypes = devices;

    public scale: number = 100;
    public deviceWidth: number = 1366;
    public deviceHeight: number = 600;

    public iframeCode = iframeCode;
    public globalStyles = globalStyles;
    private subscription: Subscription;
    public monetizationTypes = monetizationTypes;

    constructor(private previewService: PreviewService, public el: ElementRef,
                private convertHex: ConvertHexService, private widgetService: WidgetService,
                private ref: ChangeDetectorRef, private sanitizer: DomSanitizer) {
    }

    ngOnInit() {
        this.deviceTypeButtons.push(new RadioButton(devices.desktop.name, devices.desktop.name, '/assets/images/icons/desktop_default.svg'))
        this.deviceTypeButtons.push(new RadioButton(devices.tablet.name, devices.tablet.name, '/assets/images/icons/tablet_default.svg'))
        this.deviceTypeButtons.push(new RadioButton(devices.mobile.name, devices.mobile.name, '/assets/images/icons/mobile_default.svg'))
        // get widgets by widgetId only when campaign id is defined and widgets aren't defined using Input()
        if (this.campaignId && !(this.widgets && this.widgets.length > 0)) {
            this.loading = true;
            this.widget = new Widget();
            this.widgetService.getListByCampaignId(this.campaignId).subscribe(success => {
                this.widgets = success.data;
                this.widget = this.widgets[0];
                this.loading = false;
            })
        }

        this.widget = this.widget ? this.widget : new Widget();

        const win: Window = this.iframe.nativeElement.contentWindow;
        win['dataFromParent'] = this.data$;
        const doc: Document = win.document;
        doc.open();
        doc.write(this.iframeCode);
        doc.close();
        if (!this.deviceType) {
            this.deviceType = this.deviceTypes.desktop.name;
        }

        this.subscription = this.previewService.updatePreviewChange.subscribe(update => {
            this.ref.detectChanges();
            this.recreateStyles();
        })

        this.recreateStyles();

    }

    recreateStyles() {

        const parent = document.getElementById('styles');

        for (let style of parent.getElementsByClassName('globalStyles') as any) {
            style.remove()
        }

        let style = document.createElement('style');
        style.setAttribute('class', 'globalStyles');
        style.type = 'text/css';
        const css = globalStyles;
        style.appendChild(document.createTextNode(css));
        parent.appendChild(style);

        // hover styles
        let hoverStyleElement = document.createElement('style');
        hoverStyleElement.setAttribute('class', 'hoverStyles');
        hoverStyleElement.type = 'text/css';

        let hoverStyles = parent.getElementsByClassName("hoverStyles") as any;
        for (let style of hoverStyles) {
            style.remove()
        }

        const cssHoverStyles = `
            [id^=cr0wdfundingToolbox] .cft__cta__button:hover{
                ${this.getHoverButtonStyles()}
             }
            `;

        hoverStyleElement.appendChild(document.createTextNode(cssHoverStyles));
        parent.appendChild(hoverStyleElement);


    }

    public generateHTMLFromWidgets() {
        let htmlsWrapper: any = {};
        htmlsWrapper.widgets = [];

        // get widgets from createdCampaign
        if (this.createdCampaign) {
            this.widgets = this.createdCampaign.widgets;
        }

        if (!this.widgets.length) {
            this.widgets.push(this.widget);
        }
        const previousDeviceType = this.deviceType;
        this.widgets.forEach((wid, index) => {
            this.widget = wid;
            htmlsWrapper.widgets.push({});
            htmlsWrapper.widgets[index].id = this.widget.id;
            for (const type in this.deviceTypes) {
                if (this.deviceTypes.hasOwnProperty(type)) {
                    this.deviceType = this.deviceTypes[type].name;
                    if (this.widget.contains_additional_widget_settings) {
                        htmlsWrapper.widgets[index][this.deviceType] = [];
                        this.widget.additional_widget_settings.forEach((widgetSettings: any) => {
                            if (widgetSettings.active) {
                                this.widget.settings = widgetSettings.settings;
                                this.widget.widget_type.active_subtype = this.widget.widget_type.widgetSubtypes.find(
                                    x => {
                                        return x.name = widgetSettings.name;
                                    }
                                );
                                this.ref.detectChanges();
                                this.recreateStyles();
                                htmlsWrapper.widgets[index][this.deviceType] +=
                                    `<div data-position="${widgetSettings.name}">${this.previewContent.nativeElement.innerHTML}</div>`;
                            }
                        });
                    } else {
                        this.ref.detectChanges();
                        this.recreateStyles();
                        htmlsWrapper.widgets[index][this.deviceType] = this.previewContent.nativeElement.innerHTML;
                    }
                }
            }
        });
        this.deviceType = previousDeviceType;
        this.previewService.sendGeneratedHtml(htmlsWrapper);
        return of(htmlsWrapper);

    }

    ngOnChanges() {
        if (this.show) {
            this.previewService.toggle(true);

        }
        this.setDeviceDimensions();

    }

    private setDeviceDimensions() {
        // set device width/height
        if (this.deviceType === 'tablet') {
            this.deviceWidth = 768;
            this.deviceHeight = 600;
        } else if (this.deviceType === 'mobile') {
            this.deviceWidth = 380;
            this.deviceHeight = 600;
        } else {
            this.deviceWidth = 966;
            this.deviceHeight = 800;
        }
    }


    closePreview() {
        this.show = false;
        this.showChange.emit(this.show);
        this.previewService.toggle(false);
    }

    getBackgroundLivePreviewStyle() {
        const styles = this.getBackgroundStyle();
        styles.position = 'relative';
        return styles;
    }

    getBackgroundStyle() {
        const backgroundStyles = this.widget.settings[this.deviceType].additional_settings;
        const paddingBackground = backgroundStyles.padding;
        if (paddingBackground === undefined || paddingBackground === null) {
            backgroundStyles.padding = {
                top: '0px',
                right: '0px',
                bottom: '0px',
                left: '0px'
            };
        }
        const defaultStyle = {
            position: (backgroundStyles.position !== undefined) ? backgroundStyles.position : 'relative',
            height: (backgroundStyles.height !== undefined) ? this.addPx(backgroundStyles.height) : 0,
            width: (backgroundStyles.width !== undefined) ? this.addPx(backgroundStyles.width) : 0,
            maxWidth: (backgroundStyles.maxWidth !== undefined) ? backgroundStyles.maxWidth : '100%',
            top: (backgroundStyles.fixedSettings !== null) ? backgroundStyles.fixedSettings.top : 0,
            bottom: (backgroundStyles.fixedSettings !== null) ? backgroundStyles.fixedSettings.bottom : 'auto',
            left: (this.widget.widget_type.method === 'popup' && (this.deviceType !== 'mobile'))
                ? 'calc(50% - ' + parseInt(backgroundStyles.width, 10) / 2 + 'px)' : 0, // center popup
            margin: '0 auto',
            'background-repeat': 'no-repeat',
            'background-size': 'cover',
            padding: (paddingBackground !== null && paddingBackground !== undefined) ? this.addPx(paddingBackground.top) + ' ' +
                this.addPx(paddingBackground.right) + ' ' +
                this.addPx(paddingBackground.bottom) + ' ' +
                this.addPx(paddingBackground.left) : backgroundStyles.padding,
            backgroundPosition: 'center'
        };


        const fixedStyles = (this.widget.widget_type.method === widgetTypes.fixed.name) ? {
            bottom: (backgroundStyles.fixedSettings.top === 'auto') ? 0 : 'auto',
            zIndex: backgroundStyles.fixedSettings.zIndex,
            textAlign: backgroundStyles.fixedSettings.textAlign,
            padding: '5px'
        } : {};

        if (this.widget.widget_type.method === widgetTypes.popup.name) {
            fixedStyles.zIndex = 99999;
        }

        let dynamicStyle = {};
        if (this.widget.settings[this.deviceType].widget_settings.general.background.type === backgroundTypes.imageOverlay.value ||
            this.widget.settings[this.deviceType].widget_settings.general.background.type === backgroundTypes.image.value) {
            dynamicStyle = {
                'background-image': 'url(' + this.widget.settings[this.deviceType].widget_settings.general.background.image.url + ')'
            };
        }
        const result = {...defaultStyle, ...dynamicStyle, ...fixedStyles};
        return result;
    }

    getCrowdStyles() {
        this.crowdStyles = '#cr0wdWidgetContent-' + this.widget.widget_type.method + ' ';
        this.crowdStyles += 'a:hover {color: red}';
        return this.crowdStyles;
    }

    getOverlayStyle() {
        const defaultStyle = {
            position: 'absolute',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',

        };
        let dynamicStyle = {};
        if (this.widget.settings[this.deviceType].widget_settings.general.background.type === backgroundTypes.imageOverlay.value ||
            this.widget.settings[this.deviceType].widget_settings.general.background.type === backgroundTypes.color.value) {
            dynamicStyle = {
                'background-color': this.widget.settings[this.deviceType].widget_settings.general.background.color,
                opacity: this.widget.settings[this.deviceType].widget_settings.general.background.opacity / 100
            };
        }
        const result = {...defaultStyle, ...dynamicStyle};
        return result;
    }


    changePreview(preview) {
        if (!this.loading)
            this.data$.next(preview.innerHTML);
    }


    getBodyStyle() {
        const bodyContainer = this.widget.settings[this.deviceType].additional_settings.bodyContainer;
        return {
            position: (bodyContainer) ? bodyContainer.position : 'relative',
            width: (bodyContainer) ? bodyContainer.width : '100%',
            margin: (bodyContainer) ? bodyContainer.margin : 0,
            // set color from headline to bodyStyle to enable inheritation for all childs components
            color: this.widget.settings[this.deviceType].widget_settings.general.fontSettings.color,
            height: (this.widget.widget_type.method === widgetTypes.popup.name && this.deviceType === 'mobile')
                ? '95vh' : 'auto',
            overflowY: (this.widget.widget_type.method === widgetTypes.popup.name && this.deviceType === 'mobile')
                ? 'auto' : 'hidden',
            overflowX: 'hidden'
        };
    }

    getHeadlineTextStyle() {
        const headlineText = this.widget.settings[this.deviceType].widget_settings.general;
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.textContainer;
        this.usedFontFamily(headlineText.fontSettings.fontFamily);
        const dynamicStyle = {
            'text-align': this.widget.settings[this.deviceType].widget_settings.general.fontSettings.alignment,
            'font-size': (additionalSettings.text.fontSize === undefined) ? headlineText.fontSettings.fontSize + 'px'
                : additionalSettings.text.fontSize + 'px',
            'color': headlineText.fontSettings.color,
            fontFamily: headlineText.fontSettings.fontFamily,
            width: (additionalSettings !== undefined) ?
                this.subMarginFromWidth(this.widget.settings[this.deviceType].additional_settings.textContainer.text.width,
                    headlineText.text_margin.left, headlineText.text_margin.right) :
                this.subMarginFromWidth('100%', headlineText.text_margin.left, headlineText.text_margin.right),
            display: (headlineText.text_display !== undefined) ? headlineText.text_display : 'block',
            'background-color': headlineText.fontSettings.backgroundColor,
            margin: this.addPx(headlineText.text_margin.top) + ' ' +
                this.addPx(headlineText.text_margin.right) + ' ' +
                this.addPx(headlineText.text_margin.bottom) + ' ' +
                this.addPx(headlineText.text_margin.left)
        };
        const result = {...dynamicStyle};
        return result;
    }

    getAdditionalTextStyle(additionalText = this.widget.settings[this.deviceType].widget_settings.additional_text) {
        this.usedFontFamily(additionalText.fontSettings.fontFamily);
        if (!additionalText) {
            return;
        }
        const dynamicStyle = {
            'text-align': additionalText.fontSettings.alignment,
            'font-size': additionalText.fontSettings.fontSize + 'px',
            'color': additionalText.fontSettings.color,
            fontFamily: additionalText.fontSettings.fontFamily,
            width: (this.widget.settings[this.deviceType].additional_settings.textContainer !== undefined) ?
                this.subMarginFromWidth(this.widget.settings[this.deviceType].additional_settings.textContainer.text.width,
                    additionalText.text_margin.left, additionalText.text_margin.right) :
                this.subMarginFromWidth('100%', additionalText.text_margin.left, additionalText.text_margin.right),
            display: (additionalText.text_display !== undefined) ? additionalText.text_display : 'block',
            padding: (this.widget.settings[this.deviceType].additional_settings.bodyContainer !== undefined) ?
                this.widget.settings[this.deviceType].additional_settings.bodyContainer.padding : 0,
            'background-color': additionalText.text_background,
            margin: this.addPx(additionalText.text_margin.top) + ' ' +
                this.addPx(additionalText.text_margin.right) + ' ' +
                this.addPx(additionalText.text_margin.bottom) + ' ' +
                this.addPx(additionalText.text_margin.left)
        }
        const result = {...dynamicStyle};
        return result;
    }

    getButtonStyles() {
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer.button;
        this.usedFontFamily(ctaStyles.default.fontSettings.fontFamily);
        const boxShadow = ctaStyles.default.design.shadow.x + 'px ' +
            ctaStyles.default.design.shadow.y + 'px ' +
            ctaStyles.default.design.shadow.b + 'px ' + '0px ' +
            this.convertHex.convert((ctaStyles.default.design.shadow.color === undefined) ? '#000' : ctaStyles.default.design.shadow.color);

        const defaultStyles = {
            padding: this.addPx(ctaStyles.default.padding.top) + ' ' +
                this.addPx(ctaStyles.default.padding.right) + ' ' +
                this.addPx(ctaStyles.default.padding.bottom) + ' ' +
                this.addPx(ctaStyles.default.padding.left),
            width: ctaStyles.default.width,
            fontFamily: ctaStyles.default.fontSettings.fontFamily,
            fontWeight: ctaStyles.default.fontSettings.fontWeight,
            textAlign: ctaStyles.default.fontSettings.alignment,
            color: ctaStyles.default.fontSettings.color,
            fontSize: ctaStyles.default.fontSettings.fontSize + 'px',
            display: (this.widget.settings[this.deviceType].additional_settings.buttonContainer !== undefined &&
                this.widget.settings[this.deviceType].additional_settings.buttonContainer.button &&
                this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display !== undefined) ?
                this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display : 'inline-block',
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

        if (this.widget.widget_type.method === widgetTypes.fixed.name ||
            this.widget.widget_type.method === widgetTypes.locked.name) {
            defaultStyles['display'] = 'inline-block';
        }

        const result = {...defaultStyles};
        return result;
    }

    getNormalStyles() {
        return JSON.stringify(this.getButtonStyles())
    }

    private addPx(input) {
        return isNaN(input) ? input : input + 'px';
    }

    getHoverButtonStyles() {
        const hoverDesignSettings = this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design;
        const hoverSettings = this.widget.settings[this.deviceType].widget_settings.call_to_action.hover;
        let hoverStyles: string = '';
        hoverStyles += `
            color:${hoverSettings.fontSettings.color}!important;
            font-weight:${hoverSettings.fontSettings.fontWeight}!important;`;
        if (hoverDesignSettings.fill.active) {
            hoverStyles += `
            background-color:${hoverDesignSettings.fill.color}!important;
            opacity:${hoverDesignSettings.fill.opacity / 100}!important;`;
        }
        if (hoverDesignSettings.border.active) {
            hoverStyles += `
            border: solid ${hoverDesignSettings.border.color} ${hoverDesignSettings.border.size}px !important;`;
        }
        if (hoverDesignSettings.shadow.active) {
            hoverStyles += ` box-shadow: ${hoverDesignSettings.shadow.x}px ${hoverDesignSettings.shadow.y}px ${hoverDesignSettings.shadow.b}px ${hoverDesignSettings.shadow.color}!important;`
        }
        return hoverStyles;
    }

    getPreview() {

        this.emitHtml.emit(this.previewContent);
    }

    changeWidget(wid) {
        this.widget = wid;
        this.ref.detectChanges();
        this.recreateStyles();
    }

    ngOnDestroy() {
        this.closePreview();
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
    }

    getTextContainerStyle() {
        const dynamicStyle = {};
        if (this.widget.widget_type.method === widgetTypes.fixed.name
            || this.widget.widget_type.method === widgetTypes.locked.name) {
            dynamicStyle['width'] = this.widget.settings[this.deviceType].additional_settings.textContainer.width + '%';
            dynamicStyle['float'] = 'left';
        }
        return dynamicStyle;
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

    ctaReplaced() {
        return this.widget.settings[this.deviceType].payment_settings.active;
    }

    getButtonContainerStyles() {
        const additionalSettings = this.widget.settings[this.deviceType].additional_settings.buttonContainer;
        const ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        const containerStyles = {
            margin: this.addPx(ctaStyles.default.margin.top) + ' ' +
                this.addPx(ctaStyles.default.margin.right) + ' ' +
                this.addPx(ctaStyles.default.margin.bottom) + ' ' +
                this.addPx(ctaStyles.default.margin.left),
            display: this.widget.settings[this.deviceType].widget_settings.call_to_action.default.display,
            width: (additionalSettings !== undefined) ? additionalSettings.width : '100%',
            position: (additionalSettings !== undefined) ? additionalSettings.position : 'relative',
            textAlign: ctaStyles.default.fontSettings.alignment,
        };

        if (this.widget.widget_type.method === widgetTypes.fixed.name
            || this.widget.widget_type.method === widgetTypes.locked.name) {
            containerStyles['width'] = this.widget.settings[this.deviceType].additional_settings.buttonContainer.width + '%';
            containerStyles['float'] = 'left';
        }
        return containerStyles;
    }

    getCloseWidgetStyles() {
        let widgetSettings = this.widget.settings[this.deviceType].widget_settings;
        const styles = {
            position: 'absolute',
            right: (this.deviceType === 'tablet') ? '7px' : ((this.deviceType === 'mobile') ? '25px' : '15px'),
            top: widgetSettings.close_top || ((this.widget.widget_type.method === 'fixed')
                ? 'calc(50% - 10px)' : ((this.deviceType === 'tablet') ? '7px' : ((this.deviceType === 'mobile') ? '0px' : '15px'))),
            width: widgetSettings.close_text ? 'auto' : '20px',
            height: '20px',
            cursor: 'pointer',
            color: widgetSettings.close_color || widgetSettings.general.fontSettings.color,
            'font-size' : this.addPx(widgetSettings.close_font_size) || '12px',
            display: (this.widget.widget_type.method === 'fixed' || this.widget.widget_type.method === 'popup')
                ? 'block' : 'none'
        };
        return styles;
    }

    getCloseButtonStyles() {
        const styles = {
            fill: this.widget.settings[this.deviceType].widget_settings.close_color ||
                this.widget.settings[this.deviceType].widget_settings.general.fontSettings.color
        };
        return styles;
    }

    getPopupOverlay() {
        const styles = {
            display: (this.widget.widget_type.method === 'popup') ? 'block' : 'none',
            width: '100%',
            height: 'calc(100% + 140px)',
            top: '-140px',
            position: 'absolute',
            zIndex: 9999,
            left: 0,
            background: 'rgba(0, 0, 0, .7)'
        };
        return styles;
    }

    getContinueReadingButtonContainer() {
        const styles = {
            display: (this.widget.widget_type.method === 'locked') ? 'block' : 'none',
            width: this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer.width,
            position: this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer.position,
            textAlign: this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer.button.alignment
        };
        return styles;
    }

    getContinueReadingButton() {
        const buttonStyles = this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer.button;
        const buttonContainerStyles = this.widget.settings[this.deviceType].additional_settings.continueReadingButtonContainer;
        const styles = {
            width: buttonStyles.width,
            cursor: 'pointer',
            maxWidth: buttonStyles.maxWidth,
            margin: this.addPx(buttonContainerStyles.margin.top) + ' ' +
                this.addPx(buttonContainerStyles.margin.right) + ' ' +
                this.addPx(buttonContainerStyles.margin.bottom) + ' ' +
                this.addPx(buttonContainerStyles.margin.left),
            padding: this.addPx(buttonStyles.padding.top) + ' ' +
                this.addPx(buttonStyles.padding.right) + ' ' +
                this.addPx(buttonStyles.padding.bottom) + ' ' +
                this.addPx(buttonStyles.padding.left),
            fontWeight: buttonStyles.fontSettings.fontWeight,
            color: buttonStyles.fontSettings.color,
            fontFamily: buttonStyles.fontSettings.fontFamily,
            fontSize: buttonStyles.fontSettings.fontSize + 'px',
            backgroundColor: (buttonStyles.design.fill.active) ? buttonStyles.design.fill.color : '',
            border: (buttonStyles.design.border.active) ? buttonStyles.design.border.size + 'px solid ' +
                this.convertHex.convert(buttonStyles.design.border.color) : 'none',
            boxShadow: (buttonStyles.design.shadow.active) ? buttonStyles.design.shadow.x + 'px ' +
                buttonStyles.design.shadow.y + 'px ' + buttonStyles.design.shadow.b + 'px ' + 'rgba(' +
                buttonStyles.design.shadow.color + ', ' + parseInt(buttonStyles.design.shadow.opacity, 10) / 100 + ')' : 'none',
            borderRadius: (buttonStyles.design.radius.active) ? buttonStyles.design.radius.tl + 'px ' +
                buttonStyles.design.radius.tr + 'px ' + buttonStyles.design.radius.bl + 'px ' +
                buttonStyles.design.radius.br + 'px' : 0
        };
        return styles;
    }

    getArticleWidgetTextStyles() {
        const styles = {
            position: 'relative',
            display: (this.widget.widget_type.method !== 'article') ? 'none' : 'block'
        };

        return styles;
    }

    getCustomHtmlWidgetStyles() {
        const styles = {
            display: (this.widget.widget_type.method !== 'custom') ? 'none' : 'block'
        }
        return styles;
    }

    handleDeviceChange(event) {
        this.setDeviceDimensions();
    }

    private subMarginFromWidth(width: string, left: string, right: string): string {
        let result = width;
        let px = width.split('px');
        let percent = width.split('%');
        if (px.length > 1 ) {
            result = `calc(${Number(px[0])}px - (${this.addPx(left)} + ${this.addPx(right)}))`;
        }
        if (percent.length > 1 ) {
            result = `calc(${Number(percent[0])}% - (${this.addPx(left)} + ${this.addPx(right)}))`;
        }
        return result;
    }

}
