import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {RadioButton} from "../../../models/radio-button";

@Component({
    selector: 'app-radio-button',
    templateUrl: './radio-button.component.html',
    styleUrls: ['./radio-button.component.scss']
})
export class RadioButtonComponent implements OnInit {


    @Input()
    public radioButtons: RadioButton[];

    @Input()
    public colClass: string;

    @Input()
    public name:string;

    @Input()
    public currentValue;

    @Output()
    public currentValueChange: EventEmitter<any> = new EventEmitter();


    constructor() {

    }

    ngOnInit() {
        if (!this.currentValue) {
            this.currentValue = this.radioButtons[0].value;
        }
    }

    onChange(value: string) {
        this.currentValue = value;
        this.currentValueChange.emit(this.currentValue);
    }
}
