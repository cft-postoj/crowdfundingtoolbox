import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-donor-list',
  templateUrl: './portal-user-list.component.html',
  styleUrls: ['./portal-user-list.component.scss']
})
export class PortalUserListComponent implements OnInit {

  alertOpen: boolean = false;
  alertType: string = '';
  alertMessage: string = '';
  loading: boolean = true;
  noDonors: boolean = true;

  constructor() { }

  ngOnInit() {
    this.getDonors();
  }

  getDonors() {
    return;
  }

}
