import {Component, Input, OnInit} from '@angular/core';
import {Column} from '../../../core/models/column';
import {TableModel} from '../../../core/models/table-model';
import moment from 'moment/src/moment';
import {TableService} from '../../../core/services/table.service';
import {StatisticsService} from '../../services/statistics.service';
import {Filter} from '../../../core/models/filter';
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';

@Component({
    selector: 'app-table-stats',
    templateUrl: './table-stats.component.html',
    styleUrls: ['./table-stats.component.scss']
})
export class TableStatsComponent implements OnInit {

    public statsDateSelected = {
        start: moment(),
        end: moment()
    };
    public from;
    public to;
    public loading: boolean = false;
    public statistics: any = [];
    public sortedStats: any = [];
    @Input()
    public showDate: boolean = true;
    @Input() public dataType;

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };

    public model: TableModel = new TableModel();
    public availableColumns: Column[];

    constructor(public tableService: TableService, private router: Router, private statisticsService: StatisticsService) {
    }

    ngOnInit() {
        this.from = moment().subtract(1, 'months').format('YYYY-MM-DD');
        this.to = moment().format('YYYY-MM-DD');
        setTimeout(() => {
            this.statsDateSelected = {
                start: moment(this.from),
                end: moment(this.to)
            };
        }, 200);

       if (this.dataType === 'articles') {
           this.articlesColumns();
       } else {
           this.campaignsColumns();
       }

        this.refreshTable();
    }

    articlesColumns() {
        this.model.columns.push({
            value_name: 'order',
            description: '#',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'title',
            description: 'Title',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'url',
            description: 'URL',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'visits',
            description: 'Visits',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'amount_sum',
            description: 'Amount sum',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'new_users',
            description: 'Count of new users',
            type: 'none',
            filter: new Filter()
        });
        this.availableColumns = this.model.columns.slice();
    }

    campaignsColumns() {
        this.model.columns.push({
            value_name: 'order',
            description: '#',
            type: 'none',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'title',
            description: 'Title',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'duration',
            description: 'Created at',
            type: 'text',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'visits',
            description: 'Visits',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'amount_sum',
            description: 'Amount sum',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'landing_page_visits',
            description: 'Landing page visits',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'landing_page_amount',
            description: 'Landing page amount',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'leaderboard_visits',
            description: 'Leaderboard visits',
            type: 'number',
            filter: new Filter()
        });
        this.model.columns.push({
            value_name: 'leaderboard_amount',
            description: 'Leaderboard amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push({
            value_name: 'sidebar_visits',
            description: 'Sidebar visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'sidebar_amount',
            description: 'Sidebar amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'article_widget_visits',
            description: 'Article widget visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'article_widget_amount',
            description: 'Article widget amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'locked_article_visits',
            description: 'Locked article visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'locked_article_amount',
            description: 'Locked article amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'popup_visits',
            description: 'Popup widget visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'popup_amount',
            description: 'Popup widget amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'fixed_visits',
            description: 'Fixed widget visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'fixed_amount',
            description: 'Fixed widget amount',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'custom_visits',
            description: 'Custom widget visits',
            type: 'number',
            filter: new Filter()
        });
        this.availableColumns.push({
            value_name: 'custom_amount',
            description: 'Custom widget amount',
            type: 'number',
            filter: new Filter()
        });
    }

    refreshTable() {
        this.loading = true;
        if (this.dataType === 'articles') {
            this.articlesData();
        } else {
            this.campaignsData();
        }
    }

    articlesData() {
        this.statisticsService.articlesStats(this.from, this.to).subscribe((data) => {
            this.statistics = data;
            this.sortedStats = data;
            this.loading = false;
        });
    }

    campaignsData() {
        this.statisticsService.campaignsStats(this.from, this.to).subscribe((data) => {
            this.statistics = data;
            this.sortedStats = data;
            this.loading = false;
        });
    }

    sortTable() {
        this.sortedStats = this.tableService.sort(this.model, this.statistics);
    }

    momentDateChange(event) {
        this.from = event.start;
        this.to = event.end;
        this.refreshTable();
    }

    showCampaignDetail(id) {
        this.router.navigateByUrl(`${Routing.CAMPAIGNS_FULL_PATH}/${id}`);
    }

}
