import {Component, EventEmitter, Input, Output} from '@angular/core';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {Subscription} from 'rxjs';
import {Router} from '@angular/router';
import {Campaign} from '../../models';
import {CampaignService} from '../../services';
import {ComponentCommunicationService} from '../../../core/services';
import {ModalComponent} from '../../../core/parts/atoms';
import {Routing} from '../../../../constants/config.constants';
import {HelpersService} from '../../../core/services/helpers.service';

@Component({
    /* tslint:disable */ // selector must be defined in this shape (because encapsulated template in tbody)
    selector: '[app-tbody-component]',
    templateUrl: './campaign-list-item.component.html',
    styleUrls: ['./campaign-list-item.component.scss']
})

export class CampaignListItemComponent {
    @Input() items: any;
    @Output() emitter: EventEmitter<any[]> = new EventEmitter();

    @Output() activeEmitter = new EventEmitter();

    @Output() public previewEmitter = new EventEmitter();

    @Output()
    public itemDetailEmitter = new EventEmitter();

    @Output()
    public loadingEmitter = new EventEmitter();

    public campaign: Campaign = new Campaign();
    public changeSubscription: Subscription;

    public targetedUsers: number = 0;
    public targetedVisitors: number = 0;

    public campaignTargeting: any = [];

    constructor(private _modalService: NgbModal,
                private campaignService: CampaignService,
                private router: Router,
                public helperService: HelpersService,
                private componentComService: ComponentCommunicationService) {
    }

    editCampaign(id) {
        this.emitter.emit(id);
    }

    emitActive(campaign) {
        this.activeEmitter.emit(campaign);
    }

    openPreview(id) {
        this.previewEmitter.emit(id);
    }

    openDetail(id) {
        this.itemDetailEmitter.emit(id);
    }

    duplicateCampaign(id) {
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = 'Duplicate campaign';
        modalRef.componentInstance.text = 'Are you sure you want to clone this campaign';
        modalRef.componentInstance.textPrimary = '';
        modalRef.componentInstance.duplicate = true;

        modalRef.result.then((data) => {
            this.loadingEmitter.emit(true);
            //make clone
            this.campaignService.clone(id).subscribe(result => {
                this.componentComService.setAlertMessage(`Campaign was successfully duplicated.`)
                this.router.navigateByUrl(`${Routing.CAMPAIGNS_ALL_FULL_PATH}`);
            });
        }, (reason) => {
        });
    }

    getCampaignsVisits(widgets) {
        let result = 0;
        widgets.map((widget, key) => {
            if (widget.show !== null) {
                result += widget.show.length;
            }
        });
        return result;
    }

    getCampaignFunds(widgets) {
        let amount = 0;
        widgets.map((widget, key) => {
           if (widget.donation !== null) {
               widget.donation.map((don, k) => {
                   if (don.payment_id !== null) {
                       amount += don.amount;
                   }
               });
           }
        });
        return amount;
    }
}