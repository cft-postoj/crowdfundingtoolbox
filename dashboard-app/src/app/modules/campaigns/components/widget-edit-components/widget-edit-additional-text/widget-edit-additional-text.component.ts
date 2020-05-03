import {Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';
import {
    RadioButton,
} from '../../../../core/models';
import {WidgetEditBase} from '../widget-edit-base';
import {AdditionalText} from '../../../models/additional-text';

@Component({
    selector: 'app-widget-edit-additional-text',
    templateUrl: './widget-edit-additional-text.component.html',
    styleUrls: ['./widget-edit-additional-text.component.scss', '../../campaign-settings/campaign-settings.component.scss']
})
export class WidgetEditAdditionalTextComponent extends WidgetEditBase implements OnInit, OnChanges {

    @Input() additionalText: any;
    radioButtons: RadioButton[];
    marginAdditionalText: RadioButton[] = [];

    constructor() {
        super();
    }

    ngOnInit() {
        this.recreateRadioButtons();
    }

    ngOnChanges(changes: SimpleChanges) {
        this.createAdditionalSettingIfDontExists();
    }

    createAdditionalSettingIfDontExists() {
        if (!this.additionalText) {
            this.additionalText = new AdditionalText();
            this.widget.settings[this.deviceType].widget_settings.additional_text_bottom = this.additionalText;
        }
    }


    recreateRadioButtons() {
        this.radioButtons = [];
        this.radioButtons.push(new RadioButton('left', 'left', '/assets/images/icons/left.svg'));
        this.radioButtons.push(new RadioButton('center', 'center', '/assets/images/icons/center.svg'));
        this.radioButtons.push(new RadioButton('right', 'right', '/assets/images/icons/right.svg'));

        this.marginAdditionalText = [];
        this.marginAdditionalText.push(new RadioButton(
            'top', this.additionalText.text_margin.top,
            this.assetsUrl + 'images/icons/margin_top.svg'));
        this.marginAdditionalText.push(new RadioButton('right',
            this.additionalText.text_margin.right,
            this.assetsUrl + 'images/icons/margin_right.svg'));
        this.marginAdditionalText.push(new RadioButton('bottom',
            this.additionalText.text_margin.bottom,
            this.assetsUrl + 'images/icons/margin_bot.svg'));
        this.marginAdditionalText.push(new RadioButton('left',
            this.additionalText.text_margin.left,
            this.assetsUrl + 'images/icons/margin_left.svg'));

    }
}
