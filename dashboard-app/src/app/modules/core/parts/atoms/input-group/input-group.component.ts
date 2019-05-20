import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {RadioButton} from "../../../models";

@Component({
    selector: 'app-input-group',
    templateUrl: './input-group.component.html',
    styleUrls: ['./input-group.component.scss']
})
export class InputGroupComponent implements OnInit {

    @Input()
    public buttons: RadioButton[];

    @Output()
    public buttonChange: EventEmitter<RadioButton> = new EventEmitter();

    @Input()
    public fill:boolean;

    @Input()
    public class;

    constructor() {
    }

    ngOnInit() {

    }

    valueChange(event, rb) {
        rb.value = event;
        this.buttonChange.emit(rb);
    }

}
