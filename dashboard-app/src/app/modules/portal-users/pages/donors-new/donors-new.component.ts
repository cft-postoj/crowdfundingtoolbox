import { Component, OnInit } from '@angular/core';
import {NavbarItem} from '../../../core/models/navbar-item';
import {Routing} from '../../../../constants/config.constants';
import moment from 'moment/src/moment';

@Component({
  selector: 'app-donors-new',
  templateUrl: './donors-new.component.html',
  styleUrls: ['./donors-new.component.scss']
})
export class DonorsNewComponent implements OnInit {

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
    this.from = moment().subtract(1, 'months').format('YYYY-MM-DD'); // new donors -- last 30 days
    this.to = moment().format('YYYY-MM-DD');
    this.tableTitle = 'New donors in the last month';
    this.navItems = [
      {
        title: 'All donors',
        url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.DONORS + '/' + Routing.ALL,
        active: false
      },
      {
        title: 'New donors',
        url: Routing.DASHBOARD + '/' + Routing.PORTAL_USERS + '/' + Routing.DONORS + '/' + Routing.NEW,
        active: true
      }
    ];
    this.statsDateSelected = {
      start: moment(this.from),
      end: moment(this.to)
    };
  }
}
