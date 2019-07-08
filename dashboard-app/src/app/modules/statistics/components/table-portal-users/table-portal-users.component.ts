import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
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
export class TablePortalUsersComponent implements OnInit, OnChanges {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public limit;
    @Input() public showDates: boolean = true;
    @Input() public enablePortalUsersCount: boolean = false;

    @Output() public showMoreClicked = new EventEmitter();

    public routing = Routing;

    public loading = true;
    public model: TableModel = new TableModel();
    public portalUsers: DonorStats[] = [];
    public sortedPortalUsers: any;
    private portalUsersCount: number;

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
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'last_donation_payment_method',
            description: 'Last payment method',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'first_donation_at',
            description: 'First donation',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'donations_sum',
            description: 'Total donations',
            type: 'number',
            filter: new Filter()
        });
    }

    ngOnChanges(changes: SimpleChanges) {
        this.getUsers();
    }


    getUsers() {
        this.loading = true;
        this.donorService.getDonors(this.from, this.to, this.monthly, this.dataType, this.limit).subscribe(
            result => {
                this.portalUsers = result.donors;
                this.portalUsersCount = result.count;
                this.sortedPortalUsers = Object.assign([], this.portalUsers);
                this.loading = false;
            }
        );
    }

    sortTable() {
        this.sortedPortalUsers = this.tableService.sort(this.model, this.portalUsers);
    }

    public showMore() {
        this.showMoreClicked.next(false);
    }
}
