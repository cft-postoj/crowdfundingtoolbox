import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {DonationService} from '../../services/donation.service';
import {DonorsAndDonations} from '../../models/donors-and-donations';
import {DropdownItem, RadioButton} from '../../../core/models';
import {DonorService} from '../../services/donor.service';
import moment from 'moment/src/moment';
import {Moment} from 'moment';

@Component({
    selector: 'app-overall',
    templateUrl: './overall.component.html',
    styleUrls: ['./overall.component.scss']
})
export class OverallComponent implements OnInit {

    data: any;
    options: any;

    intervalRadioButtons: RadioButton[];
    typeDropdownButtons: DropdownItem[];
    interval: 'hour' | 'day' | 'week' | 'month' = 'day';
    type: 'payments' | 'donors' = 'payments';
    donorsAndDonations: DonorsAndDonations;
    graphLoading: boolean = true;
    donorsAndDonationsLoading: boolean = true;
    modalOpened: boolean = false;
    public monthly: boolean;
    public tableTitle: string;

    // all tables used ina app-modal-full-size component in this componetn
    public tables: {
        tableDonors: boolean;
        tablePayments: boolean;
    } = {
        tableDonors: false,
        tablePayments: false
    };
    private dataType: string;

    public statsDateSelected: any = {
        start: moment().subtract(1, 'months'),
        end: moment()
    };

    public from: string;
    public to: string;
    public nowMoment: Moment = moment();

    constructor(private donationService: DonationService,
                private donorService: DonorService) {
    }

    public ngOnInit(): void {
        this.intervalRadioButtons = [];
        this.intervalRadioButtons.push(new RadioButton('Hour', 'hour', '', 'hour'));
        this.intervalRadioButtons.push(new RadioButton('Day', 'day', '', 'day'));
        this.intervalRadioButtons.push(new RadioButton('Week', 'week', '', 'week'));
        this.intervalRadioButtons.push(new RadioButton('Month', 'month', '', 'month'));
        this.typeDropdownButtons = [];
        this.typeDropdownButtons.push(new DropdownItem('payments', 'payments'));
        this.typeDropdownButtons.push(new DropdownItem('donors', 'donors'));

        setTimeout(() => {
            this.statsDateSelected = {
                start: moment().subtract(1, 'months'),
                end: moment()
            };
            this.nowMoment = moment();
            this.from = this.statsDateSelected.start.format('YYYY-MM-DD');
            this.to = this.statsDateSelected.end.format('YYYY-MM-DD');
            this.getDataForGraph();
            this.getOverallData();
        }, 200);
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
            this.donorService.getDonorsGroup(this.from, this.to, this.interval).subscribe(response => {
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

    // tableToOpen -> name of table from this.tables that will be open after called
    // data -> string representation of data type passed into table
    public openModal(title: string, monthly: boolean, tableToOpen: string, dataType: string) {
        this.tableTitle = title;
        this.monthly = monthly;
        this.modalOpened = true;
        for (const tableKey of Object.keys(this.tables)) {
            this.tables[tableKey] = false;
        }
        this.tables[tableToOpen] = true;
        this.dataType = dataType;
    }

    public momentDateChange(event) {
        this.from = event.start;
        this.to = event.end;
        this.getDataForGraph();
        this.getOverallData();
    }
}
