import { Component, OnInit } from '@angular/core';
import moment from 'moment/src/moment';

@Component({
  selector: 'app-donations',
  templateUrl: './donations.component.html',
  styleUrls: ['./donations.component.scss']
})
export class DonationsComponent implements OnInit {

  public from: string;
  public to: string;

  constructor() { }

  ngOnInit() {
    this.from = moment().format('YYYY-MM-DD');
    this.to = moment().format('YYYY-MM-DD');
  }

}
