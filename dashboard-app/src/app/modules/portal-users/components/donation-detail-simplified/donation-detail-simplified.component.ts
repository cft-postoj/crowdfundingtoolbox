import {Component, Input, OnInit} from '@angular/core';
import {Donation} from '../../../payment/models/donation';

@Component({
    selector: 'app-donation-detail-simplified',
    templateUrl: './donation-detail-simplified.component.html',
    styleUrls: ['./donation-detail-simplified.component.scss']
})
export class DonationDetailSimplifiedComponent implements OnInit {

    @Input()
    public donation: Donation;

    constructor() {
    }

    ngOnInit() {
    }

}
