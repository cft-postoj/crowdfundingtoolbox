import {Component, OnInit} from '@angular/core';
import moment from 'moment/src/moment';
import {ActivatedRoute, Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
  selector: 'app-popup-statistics',
  templateUrl: './popup-statistics.component.html',
  styleUrls: ['./popup-statistics.component.scss']
})
export class PopupStatisticsComponent implements OnInit {

  public modalOpened: boolean = false;
  // all tables used ina app-modal-full-size component in this component
  public tables: {
    tableDonors: boolean;
    tablePayments: boolean;
  } = {
    tableDonors: false,
    tablePayments: false
  };

  public statsDateSelected: any = {
    start: moment().subtract(1, 'months'),
    end: moment()
  };

  public monthly: any;
  public tableTitle: string;

  public from: string;
  public to: string;

  private dataType: string;

  constructor(private router: Router,
              private route: ActivatedRoute) { }

  ngOnInit() {
    const urlParams = this.route.snapshot.paramMap;
    this.from = urlParams.get('from');
    this.to = urlParams.get('to');
    this.statsDateSelected = {
      start: moment(this.from),
      end: moment(this.to)
    };
    this.monthly = (urlParams.get('monthly') === 'true') ? true : ((urlParams.get('monthly') === 'false') ? false : '');
    this.tableTitle = urlParams.get('tableTitle');
    this.tables = {
      tableDonors: (urlParams.get('tableDonors') === 'true'),
      tablePayments: (urlParams.get('tablePayments') === 'true')
    };
    this.modalOpened = (urlParams.get('modalOpened') === 'true');
    this.dataType = urlParams.get('dataType');
  }

  public closeModal() {
    this.router.navigateByUrl(`${Routing.STATS_FULL_PATH}`);
  }

}
