import {Component, Input, OnInit} from '@angular/core';
import {DonorStats} from '../../models/donor-stats';
import {DonorService} from '../../services/donor.service';
import {Routing} from '../../../../constants/config.constants';
import {Filter} from '../../../core/models/filter';
import {TableModel} from '../../../core/models/table-model';
import {TableService} from '../../../core/services/table.service';

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

    public loading = true;
    private model: TableModel = new TableModel();
    public portalUsers: DonorStats[] = [];
    private sortedPortalUsers: any;

    constructor(private donorService: DonorService,
                private tableService: TableService) {
    }

    ngOnInit() {
        this.getUsers();
        this.model.columns.push({
            value_name: 'user.user_detail.last_name',
            description: 'User name',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'last_donation_value',
            description: 'Last donation value',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'last_donation_monthly',
            description: 'Last donation type',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'last_donation_at',
            description: 'Last donation date',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'last_donation_payment_method',
            description: 'Last payment method',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'first_donation_at',
            description: 'First donation',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'donations_sum',
            description: 'Total donations',
            type: 'number',
            filter: new Filter()
        });
    }


    getUsers() {
        this.donorService.getDonors(this.from, this.to, this.monthly).subscribe(
            result => {
                this.portalUsers = result;
                this.sortedPortalUsers = Object.assign([], result);
                this.loading = false;
            }
        );
    }

    sortTable() {
        this.sortedPortalUsers = this.tableService.sort(this.model, this.portalUsers);
    }
}
