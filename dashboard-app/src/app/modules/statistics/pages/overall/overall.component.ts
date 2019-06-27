import {Component, OnInit} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {DonorsAndDonations} from '../../models/donors-and-donations';
import {DropdownItem, RadioButton} from '../../../core/models';

@Component({
    selector: 'app-overall',
    templateUrl: './overall.component.html',
    styleUrls: ['./overall.component.scss']
})
export class OverallComponent implements OnInit {

    data: any;
    options: any;
    from = {year: new Date().getFullYear(), month: new Date().getMonth(), day: new Date().getDate()};
    to = {year: new Date().getFullYear(), month: new Date().getMonth() + 1, day: new Date().getDate()};

    intervalRadioButtons: RadioButton[];
    typeDropdownButtons: DropdownItem[];
    interval: 'hour' | 'day' | 'week' | 'month' = 'day';
    type: 'payments' | 'donors' = 'payments';
    donorsAndDonations: DonorsAndDonations;
    graphLoading: boolean = true;
    donorsAndDonationsLoading: boolean = true;

    constructor(private donationService: DonationService) {
    }

    public ngOnInit(): void {
        this.getDataForGraph();
        this.getOverallData();
        this.intervalRadioButtons = [];
        this.intervalRadioButtons.push(new RadioButton('Hour', 'hour', '', 'hour'));
        this.intervalRadioButtons.push(new RadioButton('Day', 'day', '', 'day'));
        this.intervalRadioButtons.push(new RadioButton('Week', 'week', '', 'week'));
        this.intervalRadioButtons.push(new RadioButton('Month', 'month', '', 'month'));
        this.typeDropdownButtons = [];
        this.typeDropdownButtons.push(new DropdownItem('payments', 'payments'));
        this.typeDropdownButtons.push(new DropdownItem('donors', 'donors'));

    }

    getDataForGraph() {
        this.graphLoading = true;
        if (this.type === 'payments') {
            this.donationService.getDonationsGroup(this.from, this.to, this.interval).subscribe(response => {
                    this.graphLoading = false;
                    this.data = this.handleRequest(response.donations);
                    this.options = {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: this.interval
                                }
                            }]
                        }
                    };
                }
            );
        }
        if (this.type === 'donors') {
            this.donationService.getDonorsGroup(this.from, this.to, this.interval).subscribe(response => {
                    this.graphLoading = false;
                    this.data = this.handleRequest(response.donors);
                    this.options = {
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: this.interval
                                }
                            }]
                        }
                    };
                }
            );
        }
    }

    handleRequest(dateValuePair) {
        let datasets = [];
        let monthly: any = {};
        monthly.label = 'monthly';
        monthly.borderColor = '#0f0';
        monthly.fill = false;
        monthly.data = dateValuePair.monthly.map(donation => {
            return {x: donation.date, y: donation.value};
        });
        datasets.push(monthly);

        let oneTime: any = {};
        oneTime.label = 'one time';
        oneTime.borderColor = '#00f';
        oneTime.fill = false;
        oneTime.data = dateValuePair.oneTime.map(donation => {
            return {x: donation.date, y: donation.value};
        });
        datasets.push(oneTime);

        return {
            datasets: datasets
        };
    }

    getOverallData() {
        this.donorsAndDonationsLoading = true;
        this.donationService.getDonorsAndDonationsTotal(this.from, this.to).subscribe(
            result => {
                this.donorsAndDonations = result;
                this.donorsAndDonationsLoading = false;
            }
        );
    }
}
