import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';


@Component({
    selector: 'app-checkbox',
    templateUrl: './checkbox.component.html',
    styleUrls: ['./checkbox.component.scss']
})
export class CheckboxComponent implements OnInit {

    @Input() public id: number;
    @Input() public name: string;


    @Input() public checked: boolean;
    @Output() checkedChange = new EventEmitter<boolean>();

    constructor() {
    }

    ngOnInit() {
    }

    toggle() {
        this.checked = !this.checked;
        this.checkedChange.emit(this.checked);
    }

}
