import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";
import {environment} from "../../../environments/environment";
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

    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    private radioButtons: RadioButton[] = [];
    private fontWeight: DropdownItem[] = [];
    public fontFamily: DropdownItem[] = [];

    constructor(public router: Router) {
    }

    ngOnInit() {
        this.radioButtons.push(new RadioButton("left", "left", "/assets/images/icons/left.svg"))
        this.radioButtons.push(new RadioButton("center", "center", "/assets/images/icons/center.svg"))
        this.radioButtons.push(new RadioButton("right", "right", "/assets/images/icons/right.svg"))

        this.fontWeight.push({title: "Bold", value: "bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});

        this.fontFamily.push({title:"Roboto",value:'Roboto'})
        this.fontFamily.push({title:'Indie Flower',value:'Indie Flower'})
        this.fontFamily.push({title:"Oswald",value:"Oswald"})

        this.recreateRadioButtons();
    }

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    recreateRadioButtons() {
        let assetsUrl = (environment.production) ? 'public/app/assets/' : '../../../../assets/';

        this.paddingButtons = [];
        this.paddingButtons.push(new RadioButton("top", this.cta_widget.default.padding.top, "/assets/images/icons/padding_top.svg"))
        this.paddingButtons.push(new RadioButton("right", this.cta_widget.default.padding.right, "/assets/images/icons/padding_right.svg"))
        this.paddingButtons.push(new RadioButton("bottom", this.cta_widget.default.padding.bottom, "/assets/images/icons/padding_bottom.svg"))
        this.paddingButtons.push(new RadioButton("left", this.cta_widget.default.padding.left, "/assets/images/icons/padding_left.svg"))

        this.marginButtons = [];
        this.marginButtons.push(new RadioButton("top", this.cta_widget.default.margin.top, assetsUrl + "images/icons/margin_top.svg"))
        this.marginButtons.push(new RadioButton("right", this.cta_widget.default.margin.right, assetsUrl + "images/icons/margin_right.svg"))
        this.marginButtons.push(new RadioButton("bottom", this.cta_widget.default.margin.bottom, assetsUrl + "images/icons/margin_bot.svg"))
        this.marginButtons.push(new RadioButton("left", this.cta_widget.default.margin.left, assetsUrl + "images/icons/margin_left.svg"))

    }

}
