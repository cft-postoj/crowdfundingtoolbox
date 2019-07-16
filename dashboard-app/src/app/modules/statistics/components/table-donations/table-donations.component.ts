import {Component, Input, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {Routing} from '../../../../constants/config.constants';
import {Donation} from '../../models/donation';
import {TableModel} from '../../../core/models/table-model';
import {Filter} from '../../../core/models/filter';
import {TableService} from '../../../core/services/table.service';
import {Router} from '@angular/router';
import {PaymentMethodsService} from '../../../payment/services/payment-methods.service';
import {Column} from '../../../core/models/column';

@Component({
    selector: 'app-table-donations',
    templateUrl: './table-donations.component.html',
    styleUrls: ['./table-donations.component.scss']
})
export class TableDonationsComponent implements OnInit {

    @Input() public from;
    @Input() public to;
    @Input() public monthly: boolean;
    @Input() public title;
    @Input() public dataType;
    @Input() public id;
    @Input() public disabledDate: boolean = true;
    @Input() public donations: Donation[] = [];
    @Input() public showDates = true;
    public routing = Routing;
    public loading = true;

    public paymentMethods: any = [];

    public sortedDonations: Donation[];

    public model: TableModel = new TableModel();
    private availableColumns: Column[] = [];

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };


    constructor(private donationService: DonationService,
                private paymentMethodsService: PaymentMethodsService,
                private tableService: TableService, private router: Router) {
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
            value_name: 'created_at',
            description: 'Donation created at',
            type: 'none',
            filter: new Filter()
        });

        this.model.columns.push({
            value_name: 'payment.transaction_date',
            description: 'Payment date',
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
            value_name: 'payment.iban',
            description: 'IBAN',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'payment.variable_symbol',
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
            value_name: 'payment.transaction_id',
            description: 'Transaction id',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'portal_user.user.user_detail.last_name',
            description: 'Donor name',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'portal_user.user.email',
            description: 'User email',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'portal_user.user.id',
            description: 'Donor id',
            type: 'number',
            filter: new Filter()
        });

        this.availableColumns.push({
            value_name: 'payment.payment_method.method_name',
            description: 'Payment method',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'payment.created_by',
            description: 'Created by',
            type: 'text',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'is_monthly_donation',
            description: 'Frequency',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'payment',
            description: 'Paired',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'status',
            description: 'Status',
            type: 'text',
            filter: new Filter()
        });
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

    refreshTable() {
        this.loading = true;
        if (this.dataType == null) {
            this.donationService.getDonations(this.from, this.to, this.monthly).subscribe(
                result => {
                    this.donations = result;
                    this.sortedDonations = this.donations;
                    this.loading = false;
                }
            );
        } else if (this.dataType === 'portalUser') {
            this.donationService.getDonationsByUserId(this.id, this.from, this.to).subscribe(
                result => {
                    this.donations = result;
                    this.sortedDonations = this.donations;
                    this.loading = false;
                }
            );
        }
    }

    public showDonationDetail(id) {
        return this.router.navigateByUrl(`${Routing.DASHBOARD}/${Routing.DONATIONS}/${id}`);
    }

}
