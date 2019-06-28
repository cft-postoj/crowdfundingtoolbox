import {Component, Input, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {DonorStats} from '../../models/donor-stats';

@Component({
    selector: 'app-table-portal-users',
    templateUrl: './table-portal-users.component.html',
    styleUrls: ['./table-portal-users.component.scss']
})
export class TablePortalUsersComponent implements OnInit {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;


    public portalUsers: [DonorStats];

    constructor(private donationService: DonationService) {
    }

    ngOnInit() {
        this.getUsers();
    }


    getUsers() {
        this.donationService.getDonors(this.from, this.to, this.monthly).subscribe(
            result => {
                this.portalUsers = result;
            }
        );
    }
}
