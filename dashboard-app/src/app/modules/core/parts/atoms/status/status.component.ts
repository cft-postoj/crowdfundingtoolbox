import {Component, Input, OnInit} from '@angular/core';

@Component({
    selector: 'app-status',
    templateUrl: './status.component.html',
    styleUrls: ['./status.component.scss']
})
export class StatusComponent implements OnInit {

    @Input() public active: boolean;
    @Input() public titles = ['active', 'inactive'];

    constructor() {
    }

    ngOnInit() {
    }

    getDonorStatus() {
        if (this.active) {
            return 'active';
        }
        return 'inactive';
    }

}
