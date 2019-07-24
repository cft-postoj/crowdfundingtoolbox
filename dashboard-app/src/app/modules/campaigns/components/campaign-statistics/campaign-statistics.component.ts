import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
  selector: 'app-campaign-statistics',
  templateUrl: './campaign-statistics.component.html',
  styleUrls: ['./campaign-statistics.component.scss']
})
export class CampaignStatisticsComponent implements OnInit {

  @Input()
  campaignStats: any;

  @Input()
  actualValue: string = 'total';

  @Output()
  filterEmit = new EventEmitter();

  constructor() { }

  ngOnInit() {
  }

  filterChange(value) {
    this.actualValue = value;
    this.filterEmit.emit(value);
  }

}
