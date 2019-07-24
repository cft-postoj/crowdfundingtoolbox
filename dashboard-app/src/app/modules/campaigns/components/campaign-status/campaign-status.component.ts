import {Component, EventEmitter, Input, OnChanges, OnInit, Output} from '@angular/core';
import {Router} from '@angular/router';
import {Campaign, Widget} from "../../models";
import {Routing} from "../../../../constants/config.constants";

@Component({
    selector: 'app-campaign-status',
    templateUrl: './campaign-status.component.html',
    styleUrls: ['./campaign-status.component.scss']
})
export class CampaignStatusComponent implements OnInit, OnChanges {

    @Input()
    public id: string;

    @Input()
    public percentage: boolean;

    @Input()
    public campaignModel: Campaign;

    @Input()
    public campaignStats: any;

    @Input()
    public widget: Widget = new Widget();

    @Output()
    public previewEmitter = new EventEmitter();

    @Output()
    public editEmitter = new EventEmitter();

    @Output()
    public activeEmitter = new EventEmitter();

    public lastEdited: any = new Date();

    public amount: number;
    public views: number;
    public clicks: number;
    public engagement: number;


    constructor(private router: Router) {
    }

    ngOnInit(): void {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric'
        };
        const date = new Date(this.widget.updated_at.date);
        this.lastEdited = date.toLocaleDateString('en-US', options);

    }

    previewCampaign() {
        this.previewEmitter.emit(this.widget);
    }

    public editWidget() {
        this.router.navigateByUrl(`${Routing.CAMPAIGNS_FULL_PATH}/${this.campaignModel.id}/`
        + `(${Routing.RIGHT_OUTLET}:${Routing.EDIT}/${this.id})`);
    }

    public toggleActive(widget) {
        this.activeEmitter.emit(widget);
    }

    userInfoClick() {
    }

    ngOnChanges(): void {
        switch (this.widget.widget_type.method) {
            case 'fixed':
                this.amount = this.campaignStats.fixed.amount;
                this.views = this.campaignStats.fixed.visits;
                this.clicks = this.campaignStats.fixed.donations_count;
                this.engagement = this.campaignStats.fixed.engagement;
                break;
            case 'sidebar':
                this.amount = this.campaignStats.sidebar.amount;
                this.views = this.campaignStats.sidebar.visits;
                this.clicks = this.campaignStats.sidebar.donations_count;
                this.engagement = this.campaignStats.sidebar.engagement;
                break;
            case 'popup':
                this.amount = this.campaignStats.popup.amount;
                this.views = this.campaignStats.popup.visits;
                this.clicks = this.campaignStats.popup.donations_count;
                this.engagement = this.campaignStats.popup.engagement;
                break;
            case 'landing':
                this.amount = this.campaignStats.landing_page.amount;
                this.views = this.campaignStats.landing_page.visits;
                this.clicks = this.campaignStats.landing_page.donations_count;
                this.engagement = this.campaignStats.landing_page.engagement;
                break;
            case 'custom':
                this.amount = this.campaignStats.custom.amount;
                this.views = this.campaignStats.custom.visits;
                this.clicks = this.campaignStats.custom.donations_count;
                this.engagement = this.campaignStats.custom.engagement;
                break;
            case 'leaderboard':
                this.amount = this.campaignStats.leaderboard.amount;
                this.views = this.campaignStats.leaderboard.visits;
                this.clicks = this.campaignStats.leaderboard.donations_count;
                this.engagement = this.campaignStats.leaderboard.engagement;
                break;
            case 'locked':
                this.amount = this.campaignStats.locked.amount;
                this.views = this.campaignStats.locked.visits;
                this.clicks = this.campaignStats.locked.donations_count;
                this.engagement = this.campaignStats.locked.engagement;
                break;
            case 'article':
                this.amount = this.campaignStats.article_widget.amount;
                this.views = this.campaignStats.article_widget.visits;
                this.clicks = this.campaignStats.article_widget.donations_count;
                this.engagement = this.campaignStats.article_widget.engagement;
                break;
        }
    }


}
