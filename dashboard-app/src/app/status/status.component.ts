import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {Campaign} from '../_models/campaign';
import {Routing} from '../constants/config.constants';
import {Router} from '@angular/router';
import {Widget} from '../_models/widget';

@Component({
    selector: 'app-status',
    templateUrl: './status.component.html',
    styleUrls: ['./status.component.scss']
})
export class StatusComponent implements OnInit {

    @Input()
    public id: string;

    @Input()
    public percentage: boolean;

    @Input()
    public campaignModel: Campaign;

    @Input()
    public widget: Widget = new Widget();

    @Output()
    public previewEmitter = new EventEmitter();

    @Output()
    public editEmitter = new EventEmitter();

    @Output()
    public activeEmitter = new EventEmitter();

    public lastEdited: any = new Date();


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


}
