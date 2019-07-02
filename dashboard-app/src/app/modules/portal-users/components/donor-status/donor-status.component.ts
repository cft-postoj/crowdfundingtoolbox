import {Component, Input, OnInit} from '@angular/core';

@Component({
    selector: 'app-donor-status',
    templateUrl: './donor-status.component.html',
    styleUrls: ['./donor-status.component.scss']
})
export class DonorStatusComponent implements OnInit {

    @Input()
    donorStatuses: any;

    @Input()
    isMonthlyDonor: boolean;

    constructor() {
    }

    ngOnInit() {
    }

    getDonorStatus() {
        if (this.isMonthlyDonor) {
            return 'active';
        }
        return 'inactive';
    }
}
