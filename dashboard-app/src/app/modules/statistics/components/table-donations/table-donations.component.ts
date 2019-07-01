import {Component, Input, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-table-donations',
    templateUrl: './table-donations.component.html',
    styleUrls: ['./table-donations.component.scss']
})
export class TableDonationsComponent implements OnInit {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    public routing = Routing;


    public donations: any;


    constructor(private donationService: DonationService) {
    }

    ngOnInit() {
        this.donationService.getDonations(this.from, this.to, this.monthly).subscribe(
            result => {
                this.donations = result;
            }
        );
    }


}
