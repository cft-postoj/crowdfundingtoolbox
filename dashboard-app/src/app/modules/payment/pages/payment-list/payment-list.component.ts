import { Component, OnInit } from '@angular/core';
import moment from 'moment/src/moment';

@Component({
  selector: 'app-payment-list',
  templateUrl: './payment-list.component.html',
  styleUrls: ['./payment-list.component.scss']
})
export class PaymentListComponent implements OnInit {

  public from: string;
  public to: string;

  constructor() { }

  ngOnInit() {
    this.from = moment().subtract(1, 'months').format('YYYY-MM-DD');
    this.to = moment().format('YYYY-MM-DD');
  }

}
