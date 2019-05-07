import {Component, EventEmitter, Input, Output} from '@angular/core';
import {environment} from 'environments/environment';

@Component({
    selector: 'app-button',
    templateUrl: './button.component.html',
    styleUrls: ['../../../../sass/classes.scss', './button.component.scss']
})
export class ButtonComponent {
    @Input() type: string;
    @Input() class: string;
    @Input() label: string;
    @Input() iconName: string;
    @Output() onClick = new EventEmitter<any>();

    public environment = environment;

    constructor() {}

    onButtonClick(event) {
        this.onClick.emit(event);
    }
}
