import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Router} from '@angular/router';
import {Campaign, Widget} from "../../models";
import {Routing} from "../../../../constants/config.constants";
import {WidgetCardData} from '../../models/widget-card-data';

@Component({
    selector: 'app-widget-card',
    templateUrl: './widget-card.component.html',
    styleUrls: ['./widget-card.component.scss']
})
export class WidgetCardComponent implements OnInit {

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

    getCurrentCampaignStats(): WidgetCardData {
        return Array.isArray(this.campaignStats) ?
            this.campaignStats.find(stat => {
                return stat.referral_widget_id === this.widget.id || stat.widget_id === this.widget.id;
            })
            : new WidgetCardData();
    }


}
