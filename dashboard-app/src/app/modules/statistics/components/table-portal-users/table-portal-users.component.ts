import {Component, Input, OnInit} from '@angular/core';
import {DonorStats} from '../../models/donor-stats';
import {DonorService} from '../../services/donor.service';
import {Routing} from '../../../../constants/config.constants';

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
    public routing = Routing;

    public portalUsers: [DonorStats];

    constructor(private donorService: DonorService) {
    }

    ngOnInit() {
        this.getUsers();
    }


    getUsers() {
        this.donorService.getDonors(this.from, this.to, this.monthly).subscribe(
            result => {
                this.portalUsers = result;
            }
        );
    }
}
