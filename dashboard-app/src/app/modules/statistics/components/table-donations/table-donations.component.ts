import {Component, Input, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {Routing} from '../../../../constants/config.constants';
import {Donation} from '../../models/donation';
import {TableModel} from '../../../core/models/table-model';
import {Filter} from '../../../core/models/filter';
import {TableService} from '../../../core/services/table.service';

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
    public routing = Routing;
    public loading = true;

    public donations: Donation[];
    private sortedDonations: Donation[];

    private model: TableModel = new TableModel();


    constructor(private donationService: DonationService,
                private tableService: TableService) {
    }

    ngOnInit() {
        this.donationService.getDonations(this.from, this.to, this.monthly).subscribe(
            result => {
                this.donations = result;
                this.sortedDonations = this.donations;
                this.loading = false;
            }
        );
        this.model.columns.push({
            value_name: 'portal_user.user.user_detail.last_name',
            description: 'Donor name',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'donation',
            description: 'Donation',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'is_monthly_donation',
            description: 'Frequency',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'created_at',
            description: 'Date',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'payment_method',
            description: 'Payment method',
            type: 'text',
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

}
