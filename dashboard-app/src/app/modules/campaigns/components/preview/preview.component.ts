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
import {iframeCode, globalStyles} from '../preview/previewCode';
import {DomSanitizer} from '@angular/platform-browser';
import {Widget} from '../../models';
import {devices, widgetTypes, backgroundTypes, RadioButton} from '../../../core/models';
import {PreviewService, WidgetService} from '../../services';
import {ConvertHexService} from '../../../core/services';

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
    public deviceHeight: number = 768;

    public iframeCode = iframeCode;
    public globalStyles = globalStyles;
    private subscription: Subscription;


    constructor(private previewService: PreviewService, public el: ElementRef,
                private convertHex: ConvertHexService, private widgetService: WidgetService,
                private ref: ChangeDetectorRef, private sanitizer: DomSanitizer) {
    }

    ngOnInit() {
        this.deviceTypeButtons.push(new RadioButton(devices.desktop.name, devices.desktop.name, '/assets/images/icons/desktop_default.svg'))
        this.deviceTypeButtons.push(new RadioButton(devices.tablet.name, devices.tablet.name, '/assets/images/icons/tablet_default.svg'))
        this.deviceTypeButtons.push(new RadioButton(devices.mobile.name, devices.mobile.name, '/assets/images/icons/mobile_default.svg'))
        //get widgets by widgetId only when campaign id is defined and widgets aren't defined using Input()
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
            this.deviceType = this.deviceTypes.desktop.name
        }

        this.subscription = this.previewService.updatePreviewChange.subscribe(update => {
            this.ref.detectChanges();
            this.recreateStyles();
        })

        this.recreateStyles();

    }

    recreateStyles() {
        const parent = document.getElementById('styles');

        for (let style of  parent.getElementsByClassName('globalStyles') as any) {
            style.remove()
        }

        let style = document.createElement('style');
        style.setAttribute('class', 'globalStyles');
        style.type = 'text/css';
        const css = globalStyles;
        style.appendChild(document.createTextNode(css));
        parent.appendChild(style);

    }

    public generateHTMLFromWidgets() {
        let htmlsWrapper: any = {};
        htmlsWrapper.widgets = [];

        //get widgets from createdCampaign
        if (this.createdCampaign) {
            this.widgets = this.createdCampaign.widgets;
        }

        if (!this.widgets.length) {
            this.widgets.push(this.widget)
        }
        this.widgets.forEach((wid, index) => {
            this.widget = wid;
            htmlsWrapper.widgets.push({});
            htmlsWrapper.widgets[index].id = this.widget.id;
            for (const type in this.deviceTypes) {
                if (this.deviceTypes.hasOwnProperty(type)) {
                    this.ref.detectChanges();
                    this.deviceType = this.deviceTypes[type].name;
                    this.recreateStyles();
                    htmlsWrapper.widgets[index][this.deviceType] = this.previewContent.nativeElement.innerHTML;
                }
            }
        });
        this.previewService.sendGeneratedHtml(htmlsWrapper);
        return of(htmlsWrapper);

    }

    ngOnChanges() {
        if (this.show) {
            this.previewService.toggle(true);

        }

        // set device width/height
        if (this.deviceType === 'tablet') {
            this.deviceWidth = 768;
            this.deviceHeight = 1366;
        } else if (this.deviceType === 'mobile') {
            this.deviceWidth = 380;
            this.deviceHeight = 600;
        } else {
            this.deviceWidth = 1366;
            this.deviceHeight = 768;
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
        if (paddingBackground === undefined) {
            backgroundStyles.padding = {
                top: '0px',
                right: '0px',
                bottom: '0px',
                left: '0px'
            };
        }
        const defaultStyle = {
            position: (backgroundStyles.position !== undefined) ? backgroundStyles.position : 'relative',
            height: (backgroundStyles.height !== undefined) ? backgroundStyles.height : 0,
            width: (backgroundStyles.width !== undefined) ? backgroundStyles.width : 0,
            maxWidth: (backgroundStyles.maxWidth !== undefined) ? backgroundStyles.maxWidth : '100%',
            top: 0,
            left: 0,
            margin: 0,
            'background-repeat': 'no-repeat',
            'background-size': 'cover',
            padding: this.addPx(paddingBackground.top) + ' ' +
                this.addPx(paddingBackground.right) + ' ' +
                this.addPx(paddingBackground.bottom) + ' ' +
                this.addPx(paddingBackground.left)
        };

        const fixedStyles = (this.widget.widget_type.method === widgetTypes.fixed.name) ? {
            bottom: (backgroundStyles.fixedSettings.top === 'auto') ? 0 : 'auto',
            zIndex: backgroundStyles.fixedSettings.zIndex,
            textAlign: backgroundStyles.fixedSettings.textAlign,
            padding: '5px'
        } : {};

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
        const defaultStyle = {
            position: (bodyContainer) ? bodyContainer.position : 'relative',
            width: (bodyContainer) ? bodyContainer.width : '100%',
            margin: (bodyContainer) ? bodyContainer.margin : 0,
            // set color from headline to bodyStyle to enable inheritation for all childs components
            color: this.widget.settings[this.deviceType].widget_settings.general.fontSettings.color
        };
        const dynamicStyle = {
            'background-color': this.widget.settings[this.deviceType].widget_settings.general.background.color,
            backgroundColor: this.widget.settings[this.deviceType].widget_settings.general.fontSettings.backgroundColor,

        }

        const result = {...defaultStyle, ...dynamicStyle};
        return result;
    }

    getHeadlineTextStyle() {
        const headlineText = this.widget.settings[this.deviceType].widget_settings.general;
        this.usedFontFamily(headlineText.fontSettings.fontFamily);
        const dynamicStyle = {
            'text-align': headlineText.fontSettings.alignment,
            'font-size': headlineText.fontSettings.fontSize + 'px',
            'color': headlineText.fontSettings.color,
            fontFamily: headlineText.fontSettings.fontFamily,
            width: (this.widget.settings[this.deviceType].additional_settings.textContainer !== undefined) ?
                this.widget.settings[this.deviceType].additional_settings.textContainer.text.width : '100%',
            display: (headlineText.text_display !== undefined) ? headlineText.text_display : 'block',

            margin: this.addPx(headlineText.text_margin.top) + ' ' +
                this.addPx(headlineText.text_margin.right) + ' ' +
                this.addPx(headlineText.text_margin.bottom) + ' ' +
                this.addPx(headlineText.text_margin.left)
        };
        const result = {...dynamicStyle};
        return result;
    }

    getAdditionalTextStyle() {
        const additionalText = this.widget.settings[this.deviceType].widget_settings.additional_text;
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
                this.widget.settings[this.deviceType].additional_settings.textContainer.text.width : '100%',
            display: (additionalText.text_display !== undefined) ? additionalText.text_display : 'block',
            padding: (this.widget.settings[this.deviceType].additional_settings.bodyContainer !== undefined) ?
                this.widget.settings[this.deviceType].additional_settings.bodyContainer.padding : 0,

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
            fontFamily: ctaStyles.default.fontSettings.fontFamily,
            fontWeight: ctaStyles.default.fontSettings.fontWeight,
            textAlign: ctaStyles.default.fontSettings.alignment,
            color: ctaStyles.default.fontSettings.color,
            fontSize: ctaStyles.default.fontSettings.fontSize + 'px',
            display: (this.widget.settings[this.deviceType].additional_settings.buttonContainer !== undefined) ?
                this.widget.settings[this.deviceType].additional_settings.buttonContainer.button.display : 'block',
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

        if (this.widget.widget_type.method === widgetTypes.fixed.name) {
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
            font-weight:${hoverSettings.fontSettings.fontWeight}!important;
           `;
        if (hoverDesignSettings.fill.active) {
            hoverStyles += `
            background-color:${hoverDesignSettings.fill.color}!important;
            opacity:${hoverDesignSettings.fill.opacity / 100}!important;
            `;
        }
        if (hoverDesignSettings.border.active) {
            hoverStyles += `
            border: solid ${hoverDesignSettings.border.color} ${hoverDesignSettings.border.size}px !important;
            `;
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
        if (this.widget.widget_type.method === widgetTypes.fixed.name) {
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
            display: this.widget.settings[this.deviceType].widget_settings.call_to_action.default.display,
            width: (additionalSettings !== undefined) ? additionalSettings.width : '100%',
            position: (additionalSettings !== undefined) ? additionalSettings.position : 'relative',
            textAlign: ctaStyles.default.fontSettings.alignment,
            margin: this.addPx(ctaStyles.default.margin.top) + ' ' +
                this.addPx(ctaStyles.default.margin.right) + ' ' +
                this.addPx(ctaStyles.default.margin.bottom) + ' ' +
                this.addPx(ctaStyles.default.margin.left),
        };

        if (this.widget.widget_type.method === widgetTypes.fixed.name) {
            containerStyles['width'] = this.widget.settings[this.deviceType].additional_settings.buttonContainer.width + '%';
            containerStyles['float'] = 'left';
        }
        return containerStyles;
    }

}
