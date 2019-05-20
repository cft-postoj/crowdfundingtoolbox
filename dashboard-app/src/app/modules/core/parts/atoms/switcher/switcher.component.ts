import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: 'app-switcher',
    templateUrl: './switcher.component.html',
    styleUrls: ['./switcher.component.scss']
})
export class SwitcherComponent implements OnInit {
    @Input()
    public id: number;

    @Input()
    public extraClass: string;

    @Input()
    public checked:boolean;

    @Output()
    public checkedChange = new EventEmitter<boolean>();

    constructor() {
    }

    ngOnInit(): void {
    }

    toggle() {
        this.checkedChange.emit(this.checked);
    }
}
