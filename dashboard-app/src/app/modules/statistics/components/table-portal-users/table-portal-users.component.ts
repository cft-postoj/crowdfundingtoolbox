import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {DonorStats} from '../../models/donor-stats';
import {DonorService} from '../../services/donor.service';
import {Routing} from '../../../../constants/config.constants';
import {Filter} from '../../../core/models/filter';
import {TableModel} from '../../../core/models/table-model';
import {TableService} from '../../../core/services/table.service';
import {Column} from '../../../core/models/column';

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
    public portalUsersCount: number;

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };
    public availableColumns: Column[];

    constructor(private donorService: DonorService,
                private tableService: TableService) {
    }

    ngOnInit() {
        this.getUsers();
        this.model.columns.push({
            value_name: 'todo1',
            description: 'Donor status (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'user.email',
            description: 'email',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'user.user_detail.last_name',
            description: 'User name',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'amount_sum',
            description: 'Total donations',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'todo2',
            description: 'Type (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'user.user_detail.created_at',
            description: 'User created at',
            type: 'none',
            filter: new Filter()
        });

        this.model.columns.push({
            value_name: 'todo3',
            description: 'Date modified (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'todo4',
            description: 'Campaign name (todo?)',
            type: 'none',
            filter: new Filter()
        });

        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push({
            value_name: 'user.id',
            description: 'user id',
            type: 'number',
            filter: new Filter()
        });

        this.availableColumns.push({
            value_name: 'todo5',
            description: 'variable symbol (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'todo6',
            description: 'iban (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'todo7',
            description: 'frequency (todo)',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'todo8',
            description: 'registration by (todo)',
            type: 'none',
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

    public activeColumn(searchColumnByValueName: any) {
        let result = false;
        this.model.columns.forEach(column => {
            if (column.value_name === searchColumnByValueName) {
                result = true;
                return true;
            }
        });
        return result;
    }
}
