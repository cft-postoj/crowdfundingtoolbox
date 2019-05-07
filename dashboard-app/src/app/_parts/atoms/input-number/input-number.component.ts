import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {environment} from 'environments/environment';


@Component({
    selector: 'app-inputNumber',
    templateUrl: './input-number.component.html',
    styleUrls: ['./input-number.component.scss']
})
export class InputNumberComponent {

    @Input() public class;

    @Input() public id: number;
    @Input() public value: number;
    @Input() public name: string;

    @Output() valueChange: EventEmitter<any> = new EventEmitter();
    public environment = environment;

    constructor() {
    }

    onChange() {
        this.valueChange.emit(this.value);
    }


}
