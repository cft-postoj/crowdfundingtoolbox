import {Component, OnInit} from '@angular/core';
import moment from 'moment/src/moment';
import {NavbarItem} from '../../../core/models/navbar-item';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-donors',
    templateUrl: './donors.component.html',
    styleUrls: ['./donors.component.scss']
})
export class DonorsComponent implements OnInit {

    public navItems: NavbarItem[];
    public from: string;
    public to: string;
    public tableTitle: string;
    public tables = {
        tablePayments: false,
        tableDonors: true
    };
    public statsDateSelected: any;

    constructor() {
    }

    ngOnInit() {
        this.from = '2015-01-01'; // statically defined list of donors from this date
        this.to = moment().format('YYYY-MM-DD');
        this.tableTitle = 'All donors';
        this.navItems = [
            {
                title: 'All donors',
                url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.DONORS + '/' + Routing.ALL,
                active: true
            },
            {
                title: 'New donors',
                url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.DONORS + '/' + Routing.NEW,
                active: false
            }
        ];
        this.statsDateSelected = {
            start: moment(this.from),
            end: moment(this.to)
        };
    }

}
