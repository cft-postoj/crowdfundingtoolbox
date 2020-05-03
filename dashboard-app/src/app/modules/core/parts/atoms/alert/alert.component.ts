import {Component, EventEmitter, Input, Output} from '@angular/core';

@Component({
    selector: 'app-alert',
    templateUrl: './alert.component.html',
    styleUrls: ['./alert.component.scss']
})
export class AlertComponent {
    @Input() type: 'success' | 'info' | 'warning' | 'danger' | 'primary' | 'secondary' | 'light' | 'dark';
    @Input() message: string;
    @Input() open: boolean;
    @Input() class: string;
    @Input() fixed: boolean;
    @Output()
    openChange = new EventEmitter<boolean>();

    constructor() {
    }

    closeAlert() {
        this.openChange.emit(false);
    }
}
