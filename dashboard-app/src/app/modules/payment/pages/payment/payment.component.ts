import { Component, OnInit } from '@angular/core';
import {NavbarItem} from '../../../core/models/navbar-item';
import {Router} from '@angular/router';
import {environment} from '../../../../../environments/environment';
import {Routing} from '../../../../constants/config.constants';

@Component({
  selector: 'app-payment',
  templateUrl: './payment.component.html',
  styleUrls: ['./payment.component.scss']
})
export class PaymentComponent implements OnInit {

  navItems: NavbarItem[];

  constructor() { }

  ngOnInit() {
    this.navItems = [
      {
        title: 'All donations',
        url: Routing.DASHBOARD + '/' + Routing.DONATIONS,
        active: true
      },
      {
        title: 'All payments',
        url: Routing.DASHBOARD + '/' + Routing.PAYMENTS,
        active: false
      },
      {
        title: 'Unpaired payments',
        url: Routing.DASHBOARD + '/' + Routing.UNPAIRED_PAYMENTS,
        active: false
      },
      {
        title: 'Import payments',
        url: Routing.DASHBOARD + '/' + Routing.IMPORT_PAYMENTS,
        active: false
      }
    ];
  }

}
