import {Component, Input, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {Column} from '../../../core/models/column';
import {TableModel} from '../../../core/models/table-model';
import moment from 'moment/src/moment';
import {TableService} from '../../../core/services/table.service';
import {StatisticsService} from '../../services/statistics.service';
import {Filter} from '../../../core/models/filter';
import {Router} from '@angular/router';
import {Routing} from '../../../../constants/config.constants';
import {Paginator} from 'primeng/primeng';
import {Subscription} from 'rxjs';

@Component({
    selector: 'app-table-stats',
    templateUrl: './table-stats.component.html',
    styleUrls: ['./table-stats.component.scss']
})
export class TableStatsComponent implements OnInit, OnDestroy {

    @Input()
    public showDate: boolean = true;
    @Input()
    public dataType;
    @Input()
    public limit;

    public statsDateSelected = {
        start: moment(),
        end: moment()
    };
    public from;
    public to;
    public loading: boolean = false;
    public statistics: any = [];
    public sortedStats: any = [];

    config = {
        height: '500px',
        search: true,
        placeholder: 'Choose columns to show'
    };

    public model: TableModel = new TableModel();
    public availableColumns: Column[];

    private timerTriggerFilterLazy;
    private timeToTriggerFilterLazy = 1000;

    // primeng paginator paginate from 0, laravel paginator first page is 1, therefore add +1 before sending request to backend
    public paginatorData: { page: number, rows: number, first: number, pageCount: number };

    @ViewChild('paginator') paginator: Paginator;
    private statsCount: number;
    private subscription: Subscription;

    constructor(public tableService: TableService, private router: Router, private statisticsService: StatisticsService) {
    }

    ngOnInit() {
        this.paginatorData = {page: 0, rows: this.limit || 10, first: 10, pageCount: 0};
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
        this.model.columns.push(new Column('order', '#', 'none'));
        this.model.columns.push(new Column('title', 'Title', 'text'));
        this.model.columns.push(new Column('url', 'URL', 'text'));
        this.model.columns.push(new Column('visits', 'Visits', 'number'));
        this.model.columns.push(new Column('amount_sum', 'Amount sum', 'number'));
        this.model.columns.push(new Column('new_users', 'Count of new users', 'number'));
        this.availableColumns = this.model.columns.slice();
    }

    campaignsColumns() {
        this.model.columns.push(new Column('order', '#', 'none'));
        this.model.columns.push(new Column('title', 'Title', 'text'));
        this.model.columns.push(new Column('duration', 'Created at', 'text'));
        this.model.columns.push(new Column('visits', 'Visits', 'number'));
        this.model.columns.push(new Column('amount_direct_sum', 'Direct donations', 'number'));
        this.model.columns.push(new Column('amount_referral_sum', 'Referral donations', 'number'));
        this.model.columns.push(new Column('landing_page_visits', 'Landing page visits', 'number'));
        this.model.columns.push(new Column('landing_page_amount', 'Landing page amount', 'number'));
        this.model.columns.push(new Column('leaderboard_visits', 'Leaderboard visits', 'number'));
        this.model.columns.push(new Column('leaderboard_amount', 'Leaderboard amount', 'number'));
        this.availableColumns = this.model.columns.slice();
        this.availableColumns.push(new Column('sidebar_visits', 'Sidebar visits', 'number'));
        this.availableColumns.push(new Column('sidebar_amount', 'Sidebar amount', 'number'));
        this.availableColumns.push(new Column('article_widget_visits', 'Article widget visits', 'number'));
        this.availableColumns.push(new Column('article_widget_amount', 'Article widget amount', 'number'));
        this.availableColumns.push(new Column('locked_visits', 'Locked article visits', 'number'));
        this.availableColumns.push(new Column('locked_amount', 'Locked article amount', 'number'));
        this.availableColumns.push(new Column('popup_visits', 'Popup widget visits', 'number'));
        this.availableColumns.push(new Column('popup_amount', 'Popup widget amount', 'number'));
        this.availableColumns.push(new Column('fixed_visits', 'Fixed widget visits', 'number'));
        this.availableColumns.push(new Column('fixed_amount', 'Fixed widget amount', 'number'));
        this.availableColumns.push(new Column('custom_visits', 'Custom widget visits', 'number'));
        this.availableColumns.push(new Column('custom_amount', 'Custom widget amount', 'number'));
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
        this.loading = true;
        if (this.subscription !== undefined) {
            this.subscription.unsubscribe();
        }
        this.subscription = this.statisticsService.getArticles(this.from, this.to,
            this.paginatorData.page + 1, this.tableService.getOnlyChangedColumns(this.model), {
                sort_by: this.model.sortBy,
                asc: this.model.asc
            }, this.paginatorData.rows)
            .subscribe((result) => {
                this.statistics = result.data;
                this.statsCount = result.total;
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

    public lazyFilterArticles() {
        clearTimeout(this.timerTriggerFilterLazy);
        // suspend sort for 1000 ms and wait to prevent multiple selects when user is writing string
        this.timerTriggerFilterLazy = setTimeout(() => {
            this.paginatorData.page = 0;
            // changePage triggers update
            if (this.paginator) {
                this.paginator.changePage(this.paginatorData.page);
            } else {
                this.articlesData();
            }

        }, this.timeToTriggerFilterLazy);
    }

    public instantFilterArticles() {
        this.paginatorData.page = 0;
        // changePage triggers update
        if (this.paginator) {
            this.paginator.changePage(this.paginatorData.page);
        } else {
            this.articlesData();
        }
    }

    public changePage(event) {
        this.paginatorData = event;
        this.articlesData();
    }

    ngOnDestroy(): void {
        if (this.subscription !== undefined) {
            this.subscription.unsubscribe();
        }
    }
}
