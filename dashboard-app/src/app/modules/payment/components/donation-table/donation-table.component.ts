import {Component, Input, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {DonationService} from '../../../statistics/services/donation.service';
import {Routing} from '../../../../constants/config.constants';
import {Donation} from '../../../statistics/models/donation';
import {TableModel} from '../../../core/models/table-model';
import {Filter} from '../../../core/models/filter';
import {TableService} from '../../../core/services/table.service';
import {Router} from '@angular/router';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {Column} from '../../../core/models/column';
import moment from 'moment/src/moment';
import {Moment} from 'moment';
import {ModalComponent} from '../../../core/parts/atoms';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {Paginator} from 'primeng/primeng';
import {Subscription} from 'rxjs';


@Component({
    selector: 'app-donation-table',
    templateUrl: './donation-table.component.html',
    styleUrls: ['./donation-table.component.scss']
})
export class DonationTableComponent implements OnInit, OnDestroy {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public id;
    @Input() public disabledDate: boolean = true;
    @Input() public donations: Donation[] = [];
    @Input() public showDates = true;
    @Input() public isListOfAllDonations: boolean = false;
    @Input() public extraClass: string;
    @Input() limit;
    public routing = Routing;
    public loading = true;

    public nowMoment: Moment;

    public paymentMethods: any = [];

    public sortedDonations: Donation[];

    public statsDateSelected: any;

    public model: TableModel = new TableModel();
    public availableColumns: Column[] = [];

    alertOpen: boolean = false;
    alertMessage: string = '';
    alertType: string = '';

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };

    private timerTriggerFilterLazy;
    private timeToTriggerFilterLazy = 1000;
    // primeng paginator paginate from 0, laravel paginator first page is 1, therefore add +1 before sending request to backend
    public paginatorData: { page: number, rows: number, first: number, pageCount: number };
    @ViewChild('paginator') paginator: Paginator;
    public donationsCount: any;
    private subscription: Subscription;


    constructor(private donationService: DonationService,
                private paymentMethodsService: PaymentMethodsService,
                private _modalService: NgbModal,
                public tableService: TableService, private router: Router) {
    }

    ngOnInit() {
        this.paginatorData = {page: 0, rows: this.limit || 10, first: 10, pageCount: 0};

        this.model.columns.push(new Column('order', '#', 'none'));
        this.model.columns.push(new Column('created_at', 'Donation created at', 'none'));
        this.model.columns.push(new Column('transaction_date', 'Payment date', 'none'));
        this.model.columns.push(new Column('amount', 'Amount', 'number'));
        this.model.columns.push(new Column('iban', 'IBAN', 'text'));
        this.model.columns.push(new Column('variable_symbol', 'Variable symbol', 'number'));
        this.model.columns.push(new Column('campaign_name', 'campaign name', 'text'));
        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push(new Column('transaction_id', 'Transaction id', 'text'));
        this.availableColumns.push(new Column('full_name', 'Donor name', 'text'));
        this.availableColumns.push(new Column('email', 'User email', 'text'));
        this.availableColumns.push(new Column('user_id', 'Donor id', 'number'));
        this.availableColumns.push(new Column('payment_method_name', 'Payment method', 'text'));
        this.availableColumns.push(new Column('created_by', 'Created by', 'text'));
        this.availableColumns.push(new Column('is_monthly_donation', 'Frequency', 'none'));
        this.availableColumns.push(new Column('payment', 'Paired', 'none'));
        this.availableColumns.push(new Column('status', 'Status', 'text'));
        setTimeout(() => {
            this.statsDateSelected = {
                start: moment().subtract(1, 'months'),
                end: moment()
            };
            this.nowMoment = moment();
            this.from = this.statsDateSelected.start.format('YYYY-MM-DD');
            this.to = this.statsDateSelected.end.format('YYYY-MM-DD');
            this.getPaymentMethods();
            this.refreshTable();
        }, 500);
    }

    sortTable() {
        this.sortedDonations = this.tableService.sort(this.model, this.donations);
    }

    private getPaymentMethods() {
        this.paymentMethodsService.getAll().subscribe((data) => {
            data.map((d, key) => {
                this.paymentMethods.push(d.method_name);
            });
        });
    }

    refreshTable(changedColumns?: Column[], sort?) {
        this.loading = true;
        if (this.dataType == null) {
            if (this.subscription) {
                this.subscription.unsubscribe();
            }
            this.subscription = this.donationService.getDonations(this.from, this.to, this.monthly,
                this.paginatorData.page + 1, changedColumns, sort, this.paginatorData.rows).subscribe(
                result => {
                    this.donations = result.data;
                    this.donationsCount = result.total;
                    this.loading = false;
                }
            );
        } else if (this.dataType === 'portalUser') {
            if (changedColumns == null) {
                changedColumns = [];
            }
            changedColumns.push(new Column('user_id', null, 'text', new Filter(null, null, this.id)));
            this.subscription = this.donationService.getDonations(this.from, this.to, this.monthly,
                this.paginatorData.page + 1, changedColumns, sort, this.paginatorData.rows).subscribe(
                result => {
                    this.donations = result.data;
                    this.donationsCount = result.total;
                    this.loading = false;
                }
            );
        }
    }

    public showDonationDetail(id) {
        return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.DONATIONS}/${id}`);
    }

    public momentDateChange(event) {
        this.from = event.start;
        this.to = event.end;
        this.getPaymentMethods();
        this.refreshTable();
    }

    public deleteDonation(event, donationId, donorEmail) {
        event.preventDefault();
        event.stopPropagation();
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = 'Delete donation with id ' + donationId;
        modalRef.componentInstance.text = 'Are you sure you want to delete donation with id ' + donationId +
            ' from user with email ' + donorEmail;
        modalRef.componentInstance.loading = false;
        modalRef.componentInstance.duplicate = 'donation-assignment';
        modalRef.result.then((data) => {
            // change id for donation
            this.donationService.deleteDonation(donationId).subscribe((d) => {
                this.alertMessage = 'Successfully remove donation with id ' + donationId + '.';
                this.alertType = 'success';
                this.alertOpen = true;
                this.refreshTable();
            });
        });
    }

    public lazyFilterDonations() {
        clearTimeout(this.timerTriggerFilterLazy);
        // suspend sort for 1000 ms and wait to prevent multiple selects when user is writing string
        this.timerTriggerFilterLazy = setTimeout(() => {
            this.paginatorData.page = 0;
            // changePage triggers update
            if (this.paginator) {
                this.paginator.changePage(this.paginatorData.page);
            } else {
                this.filterDonations();
            }

        }, this.timeToTriggerFilterLazy);
    }

    public instantFilterDonations() {
        this.paginatorData.page = 0;
        // changePage triggers update
        if (this.paginator) {
            this.paginator.changePage(this.paginatorData.page);
        } else {
            this.filterDonations();
        }
    }

    public changePage(event) {
        this.paginatorData = event;
        this.filterDonations();
    }

    public filterDonations() {
        // get only values, where some kind of filter is applied
        const onlyChangedColumns: Column[] = this.model.columns.filter(column => {
            return column.type !== 'none' &&
                ((column.type === 'text' && column.filter.text !== '') ||
                    (column.type === 'number' && (column.filter.min != null || column.filter.max != null)));
        });
        this.refreshTable(onlyChangedColumns,
            {
                sort_by: this.model.sortBy,
                asc: this.model.asc
            });
    }

    ngOnDestroy() {
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
    }

}
