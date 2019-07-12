import {Component, Input, OnInit} from '@angular/core';
import {Routing} from '../../../../constants/config.constants';
import {TableModel} from '../../../core/models/table-model';
import {PaymentMethodsService} from '../../../payment/services/payment-methods.service';
import {TableService} from '../../../core/services/table.service';
import {Router} from '@angular/router';
import {Filter} from '../../../core/models/filter';
import {PaymentService} from '../../../payment/services/payment.service';
import {Payment} from '../../../payment/models/payment';
import {Column} from '../../../core/models/column';

@Component({
    selector: 'app-table-payments',
    templateUrl: './table-payments.component.html',
    styleUrls: ['./table-payments.component.scss']
})
export class TablePaymentsComponent implements OnInit {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public disabledDate: boolean = true;
    @Input() public showDates: boolean = true;
    public routing = Routing;
    public loading = true;

    public paymentMethods: any = [];

    public payments: Payment[];
    public sortedPayments: Payment[];

    public model: TableModel = new TableModel();
    public availableColumns: Column[];

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };

    constructor(private paymentService: PaymentService,
                private paymentMethodsService: PaymentMethodsService,
                private tableService: TableService,
                private router: Router) {
    }

    ngOnInit() {
        this.getPaymentMethods();
        this.refreshTable();
        this.model.columns.push({
            value_name: 'order',
            description: '#',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'transaction_date',
            description: 'Date',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'amount',
            description: 'Amount',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'iban',
            description: 'IBAN',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'variable_symbol',
            description: 'Variable symbol',
            type: 'number',
            filter: new Filter()
        });

        this.model.columns.push({
            value_name: 'donation.widget.campaign.name',
            description: 'campaign name',
            type: 'text',
            filter: new Filter()
        });

        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push({
            value_name: 'transaction_id',
            description: 'Transaction id',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'donation.portal_user.user.user_detail.last_name',
            description: 'Donor name',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'donation.portal_user.user.email',
            description: 'User email',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'donation.portal_user.id',
            description: 'Donor id',
            type: 'number',
            filter: new Filter()
        });

        this.availableColumns.push({
            value_name: 'payment_method.method_name',
            description: 'Payment method',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'created_by',
            description: 'Created by',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'donation.is_monthly_donation',
            description: 'Frequency',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'donation',
            description: 'Paired',
            type: 'none',
            filter: new Filter()
        });
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

    refreshTable() {
        this.loading = true;
        this.paymentService.getPayments(this.from, this.to, this.monthly).subscribe(
            result => {
                this.payments = result;
                this.sortedPayments = this.payments;
                this.loading = false;
            }
        );
    }

    public showDonationDetail(id) {
        return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.PAYMENT}/${id}`);
    }

}
