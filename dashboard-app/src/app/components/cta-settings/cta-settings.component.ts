import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";
import {DropdownItem} from "../../_models/dropdown-item";

@Component({
    selector: 'app-cta-settings',
    templateUrl: './cta-settings.component.html',
    styleUrls: ['./cta-settings.component.scss', '../settings/settings.component.scss']
})
export class CtaSettingsComponent implements OnInit {

    public cta = 'Default';
    public cta_widget: any = {
        default: {
            padding: {
                top: '20',
                right: '0',
                bottom: '20',
                left: '0'
            },
            margin: {
                top: '15',
                right: 'auto',
                bottom: '15',
                left: 'auto'
            },
            fontSettings: {
                fontFamily: 'Roboto',
                fontWeight: 'bold',
                alignment: 'center',
                color: '#FFFFFF',
                fontSize: 24
            },
            design: {
                fill: {
                    active: true,
                    color: '#B71100',
                    opacity: 100
                },
                border: {
                    active: false,
                    color: '#B71100',
                    size: 2,
                    opacity: 0
                },
                shadow: {
                    active: false,
                    color: '#B71100',
                    x: 2,
                    y: 2,
                    b: 2,
                    opacity: 15
                },
                radius: {
                    active: true,
                    tl: 3,
                    tr: 4,
                    br: 2,
                    bl: 1
                },

            },
        },
        hover: {
            type: 'fade',
            fontSettings: {
                fontWeight: 'bold',
                color: '#FFFFFF'
            },
            design: {
                fill: {
                    active: true,
                    color: '#B71100',
                    opacity: 100
                },
                border: {
                    active: false,
                    color: '#B71100',
                    size: 2,
                    opacity: 0
                },
                shadow: {
                    active: false,
                    color: '#B71100',
                    x: 2,
                    y: 2,
                    b: 2,
                    opacity: 15
                },
            },
        }
    };
    public cta_global = {
        text: "Poporte nás",
        url: "https://podpora.postoj.sk"
    };

    //TODO: get generalSettings from backend
    public generalSettings = {
        colors: ['#9E0B0F', '#114B7D', '#FF7C12', '#598527', '#754C24', '#000',
            '#ED1C24', '#0087ED', '#F7AF00', '#8DC63F', '#fff', '#555555'],
        fonts: ['Open Sans', 'Lato', 'Oswald'],
        title:
            {
                fontWeight: '9E0B0F',
                color: "#eee",
                size: '24'
            },
        subtitle: {
            fontWeight: 400,
            color: "#ED1C24",
            size: '20'
        },
    };

    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    private radioButtons: RadioButton[] = [];
    private fontWeight: DropdownItem[] = [];
    public fontFamily: DropdownItem[] = [];
    private shadowButtons: any[];
    public allRadiusesButton: RadioButton[] = [];
    public specificRadiusButtons: RadioButton[] = [];
    public radiusButtons: RadioButton[] = [];
    private specificRadius: boolean;

    constructor(public router: Router) {
    }

    ngOnInit() {
        this.radioButtons.push(new RadioButton("left", "left", "/assets/images/icons/left.svg"))
        this.radioButtons.push(new RadioButton("center", "center", "/assets/images/icons/center.svg"))
        this.radioButtons.push(new RadioButton("right", "right", "/assets/images/icons/right.svg"))

        this.fontWeight.push({title: "Bold", value: "bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});

        this.fontFamily.push({title: "Roboto", value: 'Roboto'})
        this.fontFamily.push({title: 'Indie Flower', value: 'Indie Flower'})
        this.fontFamily.push({title: "Oswald", value: "Oswald"})

        this.shadowButtons = [];
        this.shadowButtons.push(new RadioButton("x", this.cta_widget.default.design.shadow.x, '', "X:"))
        this.shadowButtons.push(new RadioButton("y", this.cta_widget.default.design.shadow.y, '', "Y:"))
        this.shadowButtons.push(new RadioButton("b", this.cta_widget.default.design.shadow.b, '', "B:"))

        this.allRadiusesButton.push(new RadioButton("all", 0, "/assets/images/icons/radius_AllTogether.svg"))

        this.specificRadiusButtons.push(new RadioButton("tl", this.cta_widget.default.design.radius.tl, "/assets/images/icons/radius_LeftTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("tr", this.cta_widget.default.design.radius.tr, "/assets/images/icons/radius_RightTop.svg"))
        this.specificRadiusButtons.push(new RadioButton("br", this.cta_widget.default.design.radius.br, "/assets/images/icons/radius_LeftBottom.svg"))
        this.specificRadiusButtons.push(new RadioButton("bl", this.cta_widget.default.design.radius.bl, "/assets/images/icons/radius_LeftBottom.svg"))

        this.radiusButtons.push(new RadioButton("active", false, "/assets/images/icons/radius_disable.svg"));
        this.radiusButtons.push(new RadioButton("disabled", true, "/assets/images/icons/radius_enable.svg"));

        this.calcSpecificRadius();
        this.recreateRadioButtons();
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    recreateRadioButtons() {

        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton("top", this.cta_widget.default.padding.top, "/assets/images/icons/padding_top.svg"))
        this.paddingButtons.push(new RadioButton("right", this.cta_widget.default.padding.right, "/assets/images/icons/padding_right.svg"))
        this.paddingButtons.push(new RadioButton("bottom", this.cta_widget.default.padding.bottom, "/assets/images/icons/padding_bottom.svg"))
        this.paddingButtons.push(new RadioButton("left", this.cta_widget.default.padding.left, "/assets/images/icons/padding_left.svg"))

        this.marginButtons = [];
        this.marginButtons.push(new RadioButton("top", this.cta_widget.default.margin.top, "/assets/images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.cta_widget.default.margin.right, "/assets/images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.cta_widget.default.margin.bottom, "/assets/images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.cta_widget.default.margin.left, "/assets/images/icons/margin_left.svg"))

    }

    setSpecificRadius(value: boolean) {
        this.specificRadius = value;
    }

    writeRadiusValue(value) {
        this.specificRadiusButtons.forEach(rb => {
            this.cta_widget.default.design.radius[rb.name] = value;
        })
        this.specificRadiusButtons.forEach(button => {
            button.value = value;
        })
    }

    calcSpecificRadius() {
        let firstValue;
        let result = false;
        this.specificRadiusButtons.forEach(rb => {
            firstValue = firstValue? firstValue : rb.value;
            if (rb.value !== firstValue) {
                result = true;
            }
        })
        this.setSpecificRadius(result)
    }

}
