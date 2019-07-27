import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {DonorStats} from '../../models/donor-stats';
import {DonorService} from '../../services/donor.service';
import {Routing} from '../../../../constants/config.constants';
import {Filter} from '../../../core/models/filter';
import {TableModel} from '../../../core/models/table-model';
import {TableService} from '../../../core/services/table.service';
import {Column} from '../../../core/models/column';
import {PortalUser} from '../../../portal-users/models/portal-user';
import {Router} from '@angular/router';
import moment from 'moment/src/moment';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {HelpersService} from '../../../core/services/helpers.service';

@Component({
    selector: 'app-table-portal-users',
    templateUrl: './table-portal-users.component.html',
    styleUrls: ['./table-portal-users.component.scss']
})
export class TablePortalUsersComponent implements OnInit, OnChanges {

    @Input() public statsDateSelected;
    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public limit;
    @Input() public showDates: boolean = true;
    @Input() public enablePortalUsersCount: boolean = false;
    @Input() public export: boolean = false;
    @Input() public exportTitle: string = '';
    @Input() public exportType: string = '';
    @Input() public exportFileName: string = '';
    @Input() public isDashboardPreview: boolean = false;

    public showDelete: boolean = false;

    exportCsvLoading: boolean = false;

    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';

    @Output() public showMoreClicked = new EventEmitter();

    public routing = Routing;

    public loading = true;
    public model: TableModel = new TableModel();
    public portalUsers: DonorStats[] = [];
    public sortedPortalUsers: PortalUser[];
    public portalUsersCount: number;

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };
    public availableColumns: Column[];

    constructor(private donorService: DonorService,
                private router: Router,
                private _modalService: NgbModal,
                private helperService: HelpersService,
                public tableService: TableService) {
    }

    ngOnInit() {
        if (this.dataType === 'allPortalUsers') {
            this.showDelete = true;
        }
        this.model.columns.push({
            value_name: 'order',
            description: '#',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'status',
            description: 'Status',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'user.email',
            description: 'Email',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'user.user_detail.searchName',
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
            value_name: 'payment_type',
            description: 'Type',
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
            value_name: 'last_donation_at',
            description: 'Last donation ',
            type: 'none',
            filter: new Filter()
        });

        this.model.columns.push({
            value_name: 'user.updated_at',
            description: 'Date modified',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'campaign_name',
            description: 'Campaign name',
            type: 'text',
            filter: new Filter()
        });

        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push({
            value_name: 'user.id',
            description: 'User id',
            type: 'number',
            filter: new Filter()
        });

        this.availableColumns.push({
            value_name: 'variable_symbol.variable_symbol',
            description: 'Variable symbol',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'iban',
            description: 'IBAN',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'is_monthly_donor',
            description: 'frequency',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'created_by',
            description: 'Registration by',
            type: 'none',
            filter: new Filter()
        });
        setTimeout(() => {
            this.statsDateSelected = {
                start: moment(this.from),
                end: moment(this.to)
            };
        }, 500);
    }

    ngOnChanges(changes: SimpleChanges) {
        console.log(this.from)
        this.getUsers();
    }


    getUsers() {
        if (this.from !== undefined && this.to !== undefined) {
            this.loading = true;
            this.donorService.getDonors(this.from, this.to, this.monthly, this.dataType, this.limit).subscribe(
                result => {
                    this.portalUsers = result.donors;
                    console.log(result);
                    console.log('HERE')
                    this.portalUsersCount = result.count;
                    this.sortedPortalUsers = Object.assign([], this.portalUsers);
                    console.log(result)
                    this.loading = false;
                }
            );
        }
    }

    sortTable() {
        this.sortedPortalUsers = this.tableService.sort(this.model, this.portalUsers);
    }

    public showMore() {
        this.showMoreClicked.next(false);
    }

    public showUserDetail(id) {
        return this.router.navigateByUrl(`${Routing.PORTAL_USERS_FULL_PATH}/${id}`);
    }

    export2Csv(event) {
        this.alertOpen = event.alertOpen;
        this.alertMessage = event.alertMessage;
        this.alertType = event.alertType;
    }

    exportLoading(event) {
        console.log(event)
        this.loading = event;
        this.exportCsvLoading = event;
    }

    public momentDateChange(event) {
        this.from = event.start;
        this.to = event.end;
        this.getUsers();
    }

    public deleteUser(e, id) {
        e.preventDefault();
        e.stopPropagation();
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = 'Delete user with id ' + id;
        modalRef.componentInstance.text = 'Are you sure you want to delete user with id ' + id;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';

        modalRef.result.then((data) => {
            // change id for donation
            this.donorService.deleteUser(id).subscribe((data) => {
                this.alertMessage = 'Successfully remove portal user with id ' + id + '.';
                this.alertType = 'success';
                this.alertOpen = true;
                this.router.navigateByUrl(`${Routing.PORTAL_USER_LIST_FULL_PATH}`);
            });
        });

    }

    public paymentMehotd(data) {
        if (data !== null) {
           return this.helperService.getPaymentType(data);
        }
    }

}
