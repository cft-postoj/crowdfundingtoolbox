import { Component, OnInit } from '@angular/core';
import {NavbarItem} from '../../../core/models/navbar-item';
import {Routing} from '../../../../constants/config.constants';

@Component({
  selector: 'app-navbar-stats',
  templateUrl: './navbar-stats.component.html',
  styleUrls: ['./navbar-stats.component.scss']
})
export class NavbarStatsComponent implements OnInit {

  navItems: NavbarItem[];

  constructor() { }

  ngOnInit() {
    this.navItems = [
      {
        title: 'Dashboard',
        url: Routing.STATS_FULL_PATH,
        active: true
      },
      {
        title: 'Articles',
        url: Routing.ARTICLES_STATS_FULL_PATH,
        active: false
      },
      {
        title: 'Campaigns',
        url: Routing.CAMPAIGNS_STATS_FULL_PATH,
        active: false
      }
    ];

  }

}
