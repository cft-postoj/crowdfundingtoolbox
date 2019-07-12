import {Component, Input, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {Routing} from '../../../../constants/config.constants';
import {Donation} from '../../models/donation';
import {TableModel} from '../../../core/models/table-model';
import {Filter} from '../../../core/models/filter';
import {TableService} from '../../../core/services/table.service';
import {Router} from '@angular/router';
import {PaymentMethodsService} from '../../../payment/services/payment-methods.service';

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
    @Input() public disabledDate: boolean = true;
    @Input() donationsFromParent = false;
    @Input() public donations: Donation[] = [];
    @Input() public showDates = true;
    public routing = Routing;
    public loading = true;

    public paymentMethods: any = [];

    public sortedDonations: Donation[];

    public model: TableModel = new TableModel();


    constructor(private donationService: DonationService,
                private paymentMethodsService: PaymentMethodsService,
                private tableService: TableService, private router: Router) {
    }

    ngOnInit() {
        if (this.donationsFromParent) {
            this.loading = false;
            this.sortedDonations = this.donations;
        }
        this.getPaymentMethods();
        this.refreshTable();
        this.model.columns.push({
            value_name: 'created_at',
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
            value_name: 'payment_method',
            description: 'Payment method',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'portal_user.user.user_detail.last_name',
            description: 'Donor name',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'is_monthly_donation',
            description: 'Frequency',
            type: 'none',
            filter: new Filter()
        });

        this.model.columns.push({
            value_name: 'widget.widget_type.name',
            description: 'Widget type',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'widget.campaign.name',
            description: 'Campaign',
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
        if (!this.donationsFromParent) {
            this.loading = true;
            this.donationService.getDonations(this.from, this.to, this.monthly).subscribe(
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
