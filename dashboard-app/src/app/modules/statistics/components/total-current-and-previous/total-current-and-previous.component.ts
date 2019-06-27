import {Component, Input, OnInit} from '@angular/core';

@Component({
    selector: 'app-total-current-and-previous',
    templateUrl: './total-current-and-previous.component.html',
    styleUrls: ['./total-current-and-previous.component.scss']
})
export class TotalCurrentAndPreviousComponent implements OnInit {

    @Input() current;
    @Input() previous;
    @Input() currency;

    constructor() {
    }

    ngOnInit() {
    }

}
