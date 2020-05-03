import {
    Component,
    EventEmitter,
    Input,
    OnChanges,
    OnDestroy,
    OnInit,
    Output,
    SimpleChanges,
    ViewChild
} from '@angular/core';
import {DonorService} from '../../../statistics/services/donor.service';
import {Routing} from '../../../../constants/config.constants';
import {Filter} from '../../../core/models/filter';
import {TableModel} from '../../../core/models/table-model';
import {TableService} from '../../../core/services/table.service';
import {Column} from '../../../core/models/column';
import {PortalUser} from '../../models/portal-user';
import {Router} from '@angular/router';
import moment from 'moment/src/moment';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {HelpersService} from '../../../core/services/helpers.service';
import {Subscription} from 'rxjs';
import {Paginator} from 'primeng/primeng';
import {PortalUserService} from '../../services/portal-user.service';
import {environment} from '../../../../../environments/environment';
import {UserService} from '../../../user-management/services';

@Component({
    selector: 'app-portal-user-table',
    templateUrl: './portal-user-table.component.html',
    styleUrls: ['./portal-user-table.component.scss']
})
export class PortalUserTableComponent implements OnInit, OnChanges, OnDestroy {

    @Input() public id;
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

    @Output() public showMoreClicked = new EventEmitter();

    public showDelete: boolean = false;
    private subscription: Subscription;

    exportCsvLoading: boolean = false;

    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';

    public routing = Routing;

    public loading = true;
    public model: TableModel = new TableModel();
    public portalUsers: PortalUser[] = [];
    public portalUsersCount: number;
    public helperText: string;

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };
    public availableColumns: Column[];
    private timerTriggerFilterLazy;
    private timeToTriggerFilterLazy = 1000;

    // primeng paginator paginate from 0, laravel paginator first page is 1, therefore add +1 before sending request to backend
    public paginatorData: { page: number, rows: number, first: number, pageCount: number };

    @ViewChild('paginator') paginator: Paginator;

    constructor(private donorService: DonorService,
                private portalUserService: PortalUserService,
                private userService: UserService,
                private router: Router,
                private _modalService: NgbModal,
                private helperService: HelpersService,
                public tableService: TableService) {
    }

    ngOnInit() {
        this.model = new TableModel(this.id);
        this.paginatorData = {page: 0, rows: this.limit || 10, first: 10, pageCount: 0};

        if (this.dataType === 'allPortalUsers') {
            this.showDelete = true;
        }
        this.model.columns.push(new Column('order', '#', 'none'));
        this.model.columns.push(new Column('status', 'Status', 'none'));
        this.model.columns.push(new Column('email', 'Email', 'text'));
        this.model.columns.push(new Column('full_name', 'User name', 'text'));
        this.model.columns.push(new Column('amount_sum', 'Total donations', 'number'));
        this.model.columns.push(new Column('last_donation_payment_method_name', 'Type', 'text'));
        this.model.columns.push(new Column('created_at', 'User created at', 'none'));
        this.model.columns.push(new Column('last_donation_at', 'Last donation ', 'none'));
        this.model.columns.push(new Column('updated_at', 'Date modified', 'none'));
        this.model.columns.push(new Column('campaign_name', 'Campaign name', 'text'));
        this.model.columns.push(new Column('unlocked_at', 'Registered at', 'none'));
        this.model.columns.push(new Column('impersonate', 'Impersonate user', 'none'));
        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push(new Column('user_id', 'User id', 'number'));
        this.availableColumns.push(new Column('variable_symbol', 'Variable symbol', 'number'));
        this.availableColumns.push(new Column('bank_account_number', 'IBAN', 'text'));
        this.availableColumns.push(new Column('monthly_donor_donation_id', 'Frequency', 'none'));
        this.availableColumns.push(new Column('register_by', 'Registration by', 'none'));
        setTimeout(() => {
            this.statsDateSelected = {
                start: moment(this.from),
                end: moment(this.to)
            };
        }, 500);

        if (this.dataType === 'stoppedSupporting') {
            this.helperText = 'Users in this list are there because they stopped their monthly support :( ' +
                'During the last 40 days, there was no donation from them.';
        }
        if (this.dataType === 'didNotPay') {
            this.helperText = 'Users in this list are there because they created donation but no payment was record from them :(';
        }
        if (this.dataType === 'onlyInitializeDonation') {
            this.helperText = 'Users in this list are there because the only initialized monetization ' +
                'widget and didn\'t complete any step :(';
        }
        this.getUsers();
    }

    ngOnChanges(changes: SimpleChanges) {
        // update users only when input from or to is changed
        if ((changes.from && !changes.from.isFirstChange()) || (changes.to && !changes.to.isFirstChange())) {
            this.getUsers();
        }
    }


    getUsers(changedColumns?: Column[], sort?) {
        if (this.from !== undefined && this.to !== undefined) {
            this.loading = true;
            if (this.subscription !== undefined) {
                this.subscription.unsubscribe();
            }
            this.subscription = this.portalUserService.getPortalUsersFilter(this.from, this.to, this.monthly,
                this.dataType, this.paginatorData.page + 1 + '', changedColumns, sort,
                this.paginatorData.rows + '').subscribe(
                result => {
                    this.portalUsers = result.data;
                    this.portalUsersCount = result.total;
                    this.loading = false;
                }
            );
        }
    }

    public lazyFilterUsers() {
        clearTimeout(this.timerTriggerFilterLazy);
        // suspend sort for 1000 ms and wait to prevent multiple selects when user is writing string
        this.timerTriggerFilterLazy = setTimeout(() => {
            this.paginatorData.page = 0;
            // changePage triggers update
            if (this.paginator) {
                this.paginator.changePage(this.paginatorData.page);
            } else {
                this.filterUsers();
            }

        }, this.timeToTriggerFilterLazy);
    }

    public instantFilterUsers() {
        this.paginatorData.page = 0;
        // changePage triggers update
        if (this.paginator) {
            this.paginator.changePage(this.paginatorData.page);
        } else {
            this.filterUsers();
        }
    }

    public changePage(event) {
        this.paginatorData = event;
        this.filterUsers();
    }

    public filterUsers() {
        // get only values, where some kind of filter is applied
        const onlyChangedColumns: Column[] = this.model.columns.filter(column => {
            return column.type !== 'none' &&
                ((column.type === 'text' && column.filter.text !== '') ||
                    (column.type === 'number' && (column.filter.min != null || column.filter.max != null)));
        });
        this.getUsers(onlyChangedColumns,
            {
                sort_by: this.model.sortBy,
                asc: this.model.asc
            });
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
            this.donorService.deleteUser(id).subscribe((success) => {
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

    public checkActive(lastDonation) {
        if (lastDonation == null) {
            return false;
        }
        if (moment().diff(lastDonation, 'days') >= 40) {
            return false;
        }
        return true;
    }

    ngOnDestroy(): void {
        if (this.subscription !== undefined) {
            this.subscription.unsubscribe();
        }
    }

    public impersonate(e, id: number) {
        e.preventDefault();
        e.stopPropagation();
        this.userService.impersonate(id).subscribe(
            result => {
                window.open(`${environment.portalUrl}/moj-ucet?impersonate=${result.token}`);
            },
            error => {
                console.log(error);
            }
        );
    }
}
