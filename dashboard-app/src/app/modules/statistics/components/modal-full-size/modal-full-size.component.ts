import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
    selector: 'app-modal-full-size',
    templateUrl: './modal-full-size.component.html',
    styleUrls: ['./modal-full-size.component.scss']
})
export class ModalFullSizeComponent implements OnInit {


    @Input() open;

    @Output() openChange: EventEmitter<any> = new EventEmitter();

    constructor() {
    }

    ngOnInit() {
    }

    close() {
        this.open = false;
        this.openChange.emit(this.open);
    }

}
