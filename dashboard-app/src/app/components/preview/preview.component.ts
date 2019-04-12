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
import {Widget} from "../../_models/widget";
import {backgroundTypes, devices, widgetTypes} from "../../_models/enums";
import {PreviewService} from "../../_services/preview.service";
import {Subject} from 'rxjs/Subject';
import {ConvertHexService} from "../../_services/convert-hex.service";
import {WidgetService} from "../../_services/widget.service";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";
import {of, Subscription} from "rxjs";
import {iframeCode} from "../preview/previewCode"
import {DomSanitizer} from '@angular/platform-browser';

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

    public scale: number = 50;

    public iframeCode = iframeCode;
    private subscription: Subscription;

    constructor(private previewService: PreviewService, public el: ElementRef,
                private convertHex: ConvertHexService, private widgetService: WidgetService,
                private ref: ChangeDetectorRef, private sanitizer: DomSanitizer) {
    }

    ngOnInit() {
        this.deviceTypeButtons.push(new RadioButton(devices.desktop.name, devices.desktop.name, "/assets/images/icons/desktop_default.svg"))
        this.deviceTypeButtons.push(new RadioButton(devices.tablet.name, devices.tablet.name, "/assets/images/icons/tablet_default.svg"))
        this.deviceTypeButtons.push(new RadioButton(devices.mobile.name, devices.mobile.name, "/assets/images/icons/mobile_default.svg"))
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

        const win: Window = this.iframe.nativeElement.contentWindow;
        win['dataFromParent'] = this.data$;
        const doc: Document = win.document;
        doc.open();
        doc.write(this.iframeCode);
        doc.close();
        this.widget = this.widget ? this.widget : new Widget();
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
        while (parent.firstChild)
            parent.removeChild(parent.firstChild);
        const style = document.createElement('style');
        style.type = 'text/css';
        const css = `#cr0wdWidgetContent-${this.widget.widget_type.method} a:hover{${this.getHoverButtonStyles()}}body{overflow:hidden;}`;
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
            for (let type in this.deviceTypes) {
                if (this.deviceTypes.hasOwnProperty(type)) {
                    this.ref.detectChanges();
                    this.deviceType = this.deviceTypes[type].name
                    this.recreateStyles();
                    htmlsWrapper.widgets[index][this.deviceType] = this.previewContent.nativeElement.innerHTML + "";
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
    }


    closePreview() {
        this.show = false;
        this.showChange.emit(this.show);
        this.previewService.toggle(false);
    }

    getBackgroundStyle() {
        let defaultStyle = {
            position: this.widget.settings[this.deviceType].additional_settings.position,
            height: this.widget.settings[this.deviceType].additional_settings.height,
            width: this.widget.settings[this.deviceType].additional_settings.width,
            maxWidth: this.widget.settings[this.deviceType].additional_settings.maxWidth,
            top: 0,
            left: 0,
            margin: 'auto',
            'background-repeat': 'no-repeat',
            'background-size': 'cover',
            padding: '30px'
        };
        let fixedStyles = (this.widget.widget_type.method == widgetTypes.fixed.name) ? {
            bottom: (this.widget.settings[this.deviceType].additional_settings.fixedSettings.top == 'auto') ? 0 : 'auto',
            zIndex: this.widget.settings[this.deviceType].additional_settings.fixedSettings.zIndex,
            textAlign: this.widget.settings[this.deviceType].additional_settings.fixedSettings.textAlign,
            padding: '5px'
        } : {};

        let dynamicStyle = {};
        if (this.widget.settings[this.deviceType].widget_settings.general.background.type == backgroundTypes.imageOverlay.value ||
            this.widget.settings[this.deviceType].widget_settings.general.background.type == backgroundTypes.image.value) {
            dynamicStyle = {
                'background-image': 'url(' + this.widget.settings[this.deviceType].widget_settings.general.background.image.url + ')'
            }
        }
        let result = {...defaultStyle, ...dynamicStyle, ...fixedStyles};
        return result;
    }

    getCrowdStyles() {
        this.crowdStyles = '#cr0wdWidgetContent-' + this.widget.widget_type.method + ' ';
        this.crowdStyles += 'a:hover {color: red}';
        return this.crowdStyles;
    }

    getOverlayStyle() {
        let defaultStyle = {
            position: "absolute",
            top: 0,
            left: 0,
            width: "100%",
            height: "100%",

        };
        let dynamicStyle = {};
        if (this.widget.settings[this.deviceType].widget_settings.general.background.type == backgroundTypes.imageOverlay.value ||
            this.widget.settings[this.deviceType].widget_settings.general.background.type == backgroundTypes.color.value)
            dynamicStyle = {
                'background-color': this.widget.settings[this.deviceType].widget_settings.general.background.color,
                opacity: this.widget.settings[this.deviceType].widget_settings.general.background.opacity / 100
            }
        let result = {...defaultStyle, ...dynamicStyle};
        return result;
    }


    changePreview(preview) {
        this.data$.next(preview.innerHTML);
    }


    getBodyStyle() {
        let defaultStyle = {
            position: this.widget.settings[this.deviceType].additional_settings.bodyContainer.position,
            // top: this.widget.settings[this.deviceType].additional_settings.textContainer.top,
            // left: this.widget.settings[this.deviceType].additional_settings.textContainer.left,
            width: this.widget.settings[this.deviceType].additional_settings.bodyContainer.width,
            margin: this.widget.settings[this.deviceType].additional_settings.bodyContainer.margin,
            //height: this.widget.settings[this.deviceType].additional_settings.textContainer.height
        }
        let dynamicStyle = {
            'background-color': this.widget.settings[this.deviceType].widget_settings.general.background.color,
            backgroundColor: this.widget.settings[this.deviceType].widget_settings.general.fontSettings.backgroundColor,

        }

        let result = {...defaultStyle, ...dynamicStyle};
        return result;
    }

    getHeadlineTextStyle() {
        const headlineText = this.widget.settings[this.deviceType].widget_settings.general;
        this.usedFontFamily(headlineText.fontSettings.fontFamily);
        let dynamicStyle = {};
        dynamicStyle = {
            'text-align': headlineText.fontSettings.alignment,
            'font-size': headlineText.fontSettings.fontSize + 'px',
            'color': headlineText.fontSettings.color,
            fontFamily: headlineText.fontSettings.fontFamily,
            width: this.widget.settings[this.deviceType].additional_settings.textContainer.text.width,
            display: headlineText.text_display,

            margin: this.addPx(headlineText.text_margin.top) + ' ' +
                this.addPx(headlineText.text_margin.right) + ' ' +
                this.addPx(headlineText.text_margin.bottom) + ' ' +
                this.addPx(headlineText.text_margin.left)
        }
        let result = {...dynamicStyle};
        return result;
    }

    getAdditionalTextStyle() {
        const additionalText = this.widget.settings[this.deviceType].widget_settings.additional_text;
        this.usedFontFamily(additionalText.fontSettings.fontFamily);
        if (!additionalText) {
            return;
        }
        let dynamicStyle = {
            'text-align': additionalText.fontSettings.alignment,
            'font-size': additionalText.fontSettings.fontSize + 'px',
            'color': additionalText.fontSettings.color,
            fontFamily: additionalText.fontSettings.fontFamily,
            width: this.widget.settings[this.deviceType].additional_settings.textContainer.text.width,
            display: additionalText.text_display,

            margin: this.addPx(additionalText.text_margin.top) + ' ' +
                this.addPx(additionalText.text_margin.right) + ' ' +
                this.addPx(additionalText.text_margin.bottom) + ' ' +
                this.addPx(additionalText.text_margin.left)
        }
        let result = {...dynamicStyle};
        return result;
    }

    getButtonStyles() {
        let ctaStyles = this.widget.settings[this.deviceType].widget_settings.call_to_action;
        this.usedFontFamily(ctaStyles.default.fontSettings.fontFamily);
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

        if (this.widget.widget_type.method == widgetTypes.fixed.name){
            defaultStyles['display'] = 'inline-block';
        }

        let result = {...defaultStyles};
        return result;
    }

    getNormalStyles() {
        return JSON.stringify(this.getButtonStyles())
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

    getHoverButtonStyles() {
        let hoverDesignSettings = this.widget.settings[this.deviceType].widget_settings.call_to_action.hover.design;
        let hoverSettings = this.widget.settings[this.deviceType].widget_settings.call_to_action.hover;
        let hoverStyles: string = '';
        hoverStyles += `
            color:${hoverSettings.fontSettings.color}!important;
            font-weight:${hoverSettings.fontSettings.fontWeight}!important;
           `
        if (hoverDesignSettings.fill.active) {
            hoverStyles += `
            background-color:${hoverDesignSettings.fill.color}!important;
            opacity:${hoverDesignSettings.fill.opacity / 100}!important;
            `
        }
        if (hoverDesignSettings.border.active) {
            hoverStyles += `
            border: solid ${hoverDesignSettings.border.color} ${hoverDesignSettings.border.size}px !important;
            `
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

    // replaceContent() {
    //     var previewElement = document.getElementById('cr0wdWidgetContent-'+this.widget.widget_type.method).cloneNode(true);
    //     var pagePreviewElement = this.pagePreview.nativeElement.contentWindow.document.getElementById('cr0wdWidgetContent-'+this.widget.widget_type.method);
    //     console.log(previewElement);
    //     console.log(pagePreviewElement);
    //     console.log(this.pagePreview.nativeElement.contentWindow.document)
    //     pagePreviewElement.replaceWith(previewElement);
    // }

    getTextContainerStyle() {
        let dynamicStyle = {};
        if (this.widget.widget_type.method == widgetTypes.fixed.name){
            dynamicStyle['width'] = this.widget.settings[this.deviceType].additional_settings.textContainer.width + '%';
            dynamicStyle['float'] = 'left';
        }
        return dynamicStyle;
    }

    private usedFontFamily(fontFamily) {
        let tempArray = this.fontFamilyPreview.split('|');
        if (tempArray.indexOf(fontFamily) === -1) {
            tempArray.push(fontFamily);
        }
        this.fontFamilyPreview = '';
        tempArray.forEach(font => {
            this.fontFamilyPreview +=
                (this.fontFamilyPreview != '') ?
                    '|' + font : font;
        });
    }

}
