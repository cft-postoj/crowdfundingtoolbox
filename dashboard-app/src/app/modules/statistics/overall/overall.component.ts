import {Component, OnInit} from '@angular/core';
import {DonationService} from '../../payment/services/donation.service';
import {DropdownItem, RadioButton} from '../../core/models';

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
    type: 'payments' | 'donators' = 'payments';

    constructor(private donationService: DonationService) {
    }

    public ngOnInit(): void {
        this.data = {
            datasets: [
                {
                    label: "US Dates",
                    data: [{
                        x: "04/01/2014", y: 175
                    }, {
                        x: "10/01/2014", y: 175
                    }, {
                        x: "04/01/2015", y: 178
                    }, {
                        x: "10/01/2015", y: 178
                    }],
                    fill: false,
                    borderColor: 'red'
                },
                {
                    label: "UK Dates",
                    data: [{
                        x: "01/04/2014", y: 175
                    }, {
                        x: "01/10/2014", y: 175
                    }, {
                        x: "01/04/2015", y: 178
                    }, {
                        x: "01/10/2015", y: 178
                    }],
                    fill: false,
                    borderColor: 'blue'
                }
            ]
        };

        this.options = {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'month'
                    }
                }]
            }
        };

        this.donationService.getDonations(this.from, this.to, this.interval);
        this.intervalRadioButtons = [];
        this.intervalRadioButtons.push(new RadioButton('Hour', 'hour', '', 'hour'));
        this.intervalRadioButtons.push(new RadioButton('Day', 'day', '', 'day'));
        this.intervalRadioButtons.push(new RadioButton('Week', 'week', '', 'week'));
        this.intervalRadioButtons.push(new RadioButton('Month', 'month', '', 'month'));
        this.typeDropdownButtons = [];
        this.typeDropdownButtons.push(new DropdownItem('payments', 'payments'));
        this.typeDropdownButtons.push(new DropdownItem('donators', 'donators'));

        this.getDataForGraph();
    }

    getDataForGraph() {
        this.donationService.getDonations(this.from, this.to, this.interval).subscribe(response => {
                console.log('this data', this.data);
                this.data = this.handleRequest(response.donations);
                console.log('this data', this.data);
            }
        );
    }

    handleRequest(donations) {
        let datasets = [];
        let monthly = {};
        monthly.label = 'monthly donations';
        monthly.borderColor = '#0f0';
        monthly.fill = false;
        monthly.data = donations.monthly.map(donation => {
            return {x: donation.date, y: donation.value};
        });
        datasets.push(monthly);

        let oneTime = {};
        oneTime.label = 'one time donations';
        oneTime.borderColor = '#00f';
        oneTime.fill = false;
        oneTime.data = donations.oneTime.map(donation => {
            return {x: donation.date, y: donation.value};
        });
        datasets.push(oneTime);

        return {
            datasets: datasets
        };
    }
}
