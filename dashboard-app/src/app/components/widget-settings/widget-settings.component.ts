import {Component, OnInit} from '@angular/core';
import {Routing} from "../../constants/config.constants";
import {Router} from "@angular/router";
import {RadioButton} from "../../_parts/atoms/radio-button/radio-button";

@Component({
    selector: 'app-widget-settings',
    templateUrl: './widget-settings.component.html',
    styleUrls: ['./widget-settings.component.scss', '../settings/settings.component.scss']
})
export class WidgetSettingsComponent implements OnInit {

    constructor(private router: Router) {
    }

    ngOnInit() {
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

    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + Routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }
}
