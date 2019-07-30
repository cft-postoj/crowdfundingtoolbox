import {Component, EventEmitter, Input, Output} from '@angular/core';
import {environment} from 'environments/environment';

@Component({
    selector: 'app-loading',
    templateUrl: './loading.component.html',
    styleUrls: ['./loading.component.scss']
})
export class LoadingComponent {
    @Input() isLoading: boolean;
    @Input() height;
    @Input() extraText: string;
    @Output()
    openChange = new EventEmitter<boolean>();
    public environment = environment;

    constructor() {}
}
