import {Component, EventEmitter, Input, OnDestroy, OnInit, Output, ViewChild} from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {TableModel} from '../../../core/models/table-model';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {TableService} from '../../../core/services/table.service';
import {Router} from '@angular/router';
import {Filter} from '../../../core/models/filter';
import {PaymentService} from '../../services/payment.service';
import {Payment} from '../../models/payment';
import {Column} from '../../../core/models/column';
import moment from 'moment/src/moment';
import {Paginator} from 'primeng/primeng';
import {Subscription} from 'rxjs';
import {DropdownItem} from '../../../core/models';
import {PortalUserService} from '../../../portal-users/services/portal-user.service';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {ModalComponent} from '../../../core/parts/atoms';

@Component({
    selector: 'app-payment-table',
    templateUrl: './payment-table.component.html',
    styleUrls: ['./payment-table.component.scss']
})
export class PaymentTableComponent implements OnInit, OnDestroy {

    @Input()
    public statsDateSelected;
    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public disabledDate: boolean = true;
    @Input() public showDates: boolean = true;
    @Input() limit;
    @Input() emitDataChanges = false;
    // array of columns value_names, that should be opened by default (except some initial columns)
    @Input() customOpenColumns = [];
    @Input() customCloseColumns = [];
    @Input() actionType: 'bulkPairing' | 'any' = 'any';
    @Output() dataChange = new EventEmitter();
    users = [];

    public routing = Routing;
    public loading = true;

    public paymentMethods: any = [];

    public payments: Payment[];
    public sortedPayments: Payment[];

    public model: TableModel;
    public availableColumns: Column[];

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
    public paymentsCount: any;
    private subscription: Subscription;
    private actionDropdownItems: DropdownItem[];
    private pickedUser;
    actionName: string;
    alertMessage: any;
    alertType: string | number;
    alertOpen: boolean;
    tableTypes: 'bulkPairing' | 'any';

    constructor(private paymentService: PaymentService,
                private paymentMethodsService: PaymentMethodsService,
                private portalUserService: PortalUserService,
                public tableService: TableService,
                private router: Router,
                private _modalService: NgbModal) {
    }

    ngOnInit() {
        this.model = new TableModel(this.title);
        this.paginatorData = {page: 0, rows: this.limit || 10, first: 10, pageCount: 0};
        this.getPaymentMethods();
        this.refreshTable();

        this.model.columns.push(new Column('order', '#', 'none', new Filter(), 'order in list',
            null, true));
        if (this.actionType === 'bulkPairing') {
            this.model.columns.push(new Column('modify', 'Modify', 'checkbox', new Filter(),
                'select all', null, true));
        }
        this.model.columns.push(new Column('transaction_date', 'Date', 'none'));
        this.model.columns.push(new Column('amount', 'Amount', 'number'));
        this.model.columns.push(new Column('iban', 'IBAN', 'text'));
        this.model.columns.push(new Column('variable_symbol', 'Variable symbol', 'number'));
        this.model.columns.push(new Column('account_name', 'Bank account Name', 'text'));

        this.model.columns.push(new Column('campaign_name', 'campaign name', 'text'));
        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push(new Column('transaction_id', 'Transaction id', 'text'));
        this.availableColumns.push(new Column('full_name', 'Donor name', 'text'));
        this.availableColumns.push(new Column('email', 'User email', 'text'));
        this.availableColumns.push(new Column('user_id', 'Donor id', 'number'));
        this.availableColumns.push(new Column('payment_method_name', 'Payment method', 'text'));
        this.availableColumns.push(new Column('created_by', 'Created by', 'text'));
        this.availableColumns.push(new Column('is_monthly_donation', 'Frequency', 'none'));
        this.availableColumns.push(new Column('donation', 'Paired', 'none'));
        this.availableColumns.push(new Column('payment_notes', 'Notes', 'text'));

        // add columns defined in customOpenColumns from availableColumns into model.columns
        this.customOpenColumns.forEach(
            (customOpenColumn) => {
                this.model.columns.push(
                    this.availableColumns.find((availableColumn) => {
                        return customOpenColumn === availableColumn.value_name;
                    })
                );
            }
        );

        // remove columns defined in customCloseColumns from model.columns
        this.model.columns = this.model.columns.filter((singleColumn) => {
            return !this.customCloseColumns.find((customCloseColumn) => {
                return customCloseColumn === singleColumn.value_name;
            });
        });

        setTimeout(() => {
            this.statsDateSelected = {
                start: moment(this.from),
                end: moment(this.to)
            };
        }, 500);
        this.actionDropdownItems = [];
        this.actionDropdownItems.push(new DropdownItem('Unpair', 'unpair'));
        this.actionDropdownItems.push(new DropdownItem('Pair', 'pair'));

    }

    sortTable() {
        this.sortedPayments = this.tableService.sort(this.model, this.payments);
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
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
        if (!this.dataType) {
            this.subscription = this.paymentService.getPayments(this.from, this.to, this.monthly,
                this.paginatorData.page + 1, changedColumns, sort, this.paginatorData.rows).subscribe(
                result => {
                    this.payments = result.data;
                    this.paymentsCount = result.total;
                    this.loading = false;
                    if (this.emitDataChanges) {
                        this.dataChange.emit(this.payments);
                    }
                }
            );
        } else if (this.dataType === 'unpaired') {
            if (changedColumns == null) {
                changedColumns = [];
            }
            changedColumns.push(new Column('donationIsNull', '', 'none'));
            this.subscription = this.paymentService.getPayments(this.from, this.to, this.monthly,
                this.paginatorData.page + 1, changedColumns, sort, this.paginatorData.rows).subscribe(
                result => {
                    this.payments = result.data;
                    this.paymentsCount = result.total;
                    this.loading = false;
                    if (this.emitDataChanges) {
                        this.dataChange.emit(this.payments);
                    }
                }
            );
        }
        const modifyMark = this.tableService.getColumnByValueName(this.model, 'modify');
        if (modifyMark) {
            modifyMark.value = false;
        }
    }

    public showDonationDetail(id) {
        return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.PAYMENTS}/${id}`);
    }

    momentDateChange(event) {
        this.from = event.start;
        this.to = event.end;
        this.refreshTable();
    }

    public lazyFilterPayments() {
        clearTimeout(this.timerTriggerFilterLazy);
        // suspend sort for 1000 ms and wait to prevent multiple selects when user is writing string
        this.timerTriggerFilterLazy = setTimeout(() => {
            this.paginatorData.page = 0;
            // changePage triggers update
            if (this.paginator) {
                this.paginator.changePage(this.paginatorData.page);
            } else {
                this.filterPayments();
            }

        }, this.timeToTriggerFilterLazy);
    }

    public instantFilterPayments() {
        this.paginatorData.page = 0;
        // changePage triggers update
        if (this.paginator) {
            this.paginator.changePage(this.paginatorData.page);
        } else {
            this.filterPayments();
        }
    }

    public changePage(event) {
        this.paginatorData = event;
        this.filterPayments();
    }

    public filterPayments() {
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

    public ngOnDestroy(): void {
        if (this.subscription) {
            this.subscription.unsubscribe();
        }
    }

    public inputChanged(event: any) {
        event.stopPropagation();
    }

    public markAllAsModify($event: any) {
        this.payments.forEach(payment => {
            payment.markAsModify = $event.checked;
        });
    }

    public updatePickedUser($event: unknown) {
        this.pickedUser = $event;
    }

    public performAction($event: any) {

        const modifingPayments = this.payments.filter(payment => {
            return payment.markAsModify === true;
        });

        if (this.actionName === 'pair') {
            const bulkPaymentsPairing = {
                userId: this.pickedUser.id,
                paymentIds: modifingPayments.map(item => item.id),
            };
            const modalRef = this._modalService.open(ModalComponent);
            modalRef.componentInstance.title = 'Are you sure you want to pair these payments?';
            modalRef.componentInstance.text = `Are you sure, that you want to pair ${modifingPayments.length} payments to user
                ${this.pickedUser.user_detail.first_name}  ${this.pickedUser.user_detail.last_name}
                 with mail ${this.pickedUser.email}`;
            modalRef.componentInstance.loading = false;
            modalRef.componentInstance.duplicate = 'pair-payments';
            modalRef.result.then((data) => {
                    this.paymentService.bulkPairing(bulkPaymentsPairing).subscribe((d) => {
                        this.instantFilterPayments();
                        this.alertMessage = d.message;
                        this.alertType = 'success';
                        this.alertOpen = true;
                    }, (error) => {
                        this.alertMessage = 'Error during pairing payments. Error message: ' + error;
                        this.alertType = 'danger';
                        this.alertOpen = true;
                    });
                }, (error) => {
                    console.log(error);
                }
            );
        } else if (this.actionName === 'unpair') {
            const bulkUnpairing = {paymentIds: modifingPayments.map(item => item.id)};
            const modalRef = this._modalService.open(ModalComponent);
            modalRef.componentInstance.title = 'Are you sure you want to unpair these payments?';
            modalRef.componentInstance.text = `Are you sure, that you want to unpair ${modifingPayments.length} payments`;
            modalRef.componentInstance.loading = false;
            modalRef.componentInstance.duplicate = 'unpair-payments';
            modalRef.result.then((data) => {
                    this.paymentService.bulkUnpairing(bulkUnpairing).subscribe((d) => {
                        this.instantFilterPayments();
                        this.alertMessage = d.message;
                        this.alertType = 'success';
                        this.alertOpen = true;
                    }, (error) => {
                        this.alertMessage = 'Error during pairing payments. Error message: ' + error;
                        this.alertType = 'danger';
                        this.alertOpen = true;
                    });
                }, (error) => {
                    console.log(error);
                }
            );

        } else if (this.actionName === undefined) {
            this.alertMessage = `Action not choosed. Please choose action`;
            this.alertType = 'danger';
            this.alertOpen = true;
        } else {
            this.alertMessage = `Uknown action. Action ${this.actionName} not found.`;
            this.alertType = 'danger';
            this.alertOpen = true;
        }
    }

    public test($event: MouseEvent) {
        console.log('test', $event);
        $event.stopPropagation();
    }
}
