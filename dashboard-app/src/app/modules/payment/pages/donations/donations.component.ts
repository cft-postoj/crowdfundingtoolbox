import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-donations',
  templateUrl: './donations.component.html',
  styleUrls: ['./donations.component.scss']
})
export class DonationsComponent implements OnInit {

  public from = {year: new Date().getFullYear() - 100, month: new Date().getMonth(), day: new Date().getDate()};
  public to = {year: new Date().getFullYear(), month: new Date().getMonth() + 1, day: new Date().getDate()};

  constructor() { }

  ngOnInit() {
  }

}
