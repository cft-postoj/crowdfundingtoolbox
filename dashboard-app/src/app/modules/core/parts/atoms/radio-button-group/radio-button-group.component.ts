import {Component, EventEmitter, Input, OnInit, Output, OnChanges} from '@angular/core';
import {RadioButton} from "../../../models/radio-button";

@Component({
    selector: 'app-radio-button-group',
    templateUrl: './radio-button-group.component.html',
    styleUrls: ['./radio-button-group.component.scss']
})
export class RadioButtonGroupComponent implements OnInit, OnChanges {

    @Input()
    public radioButtons: RadioButton[] = [];

    public currentButton: RadioButton

    @Input()
    public currentValue;

    @Output()
    public currentValueChange: EventEmitter<any> = new EventEmitter();

    @Input()
    public class;

    constructor() {
    }

    ngOnInit() {
        if (this.radioButtons) {
            this.radioButtons.forEach(rb => {
                if (rb.value == this.currentValue) {
                    this.currentButton = rb;
                }
            })
        }
    }

    ngOnChanges() {
        if (this.radioButtons) {
            this.radioButtons.forEach(rb => {
                if (rb.value == this.currentValue) {
                    this.currentButton = rb;
                }
            })
        }
    }


    setActive(selected: RadioButton) {
        this.currentButton = selected;
        this.currentValue = this.currentButton.value;
        this.currentValueChange.emit(this.currentValue)
    }

}
