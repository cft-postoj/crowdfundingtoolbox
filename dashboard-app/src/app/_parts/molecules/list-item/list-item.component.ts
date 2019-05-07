import {Component, EventEmitter, Input, Output} from "@angular/core";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {ModalComponent} from "../../atoms/modal/modal.component";
import {Routing} from "../../../constants/config.constants";
import {Campaign} from "../../../_models/campaign";
import {CampaignService} from "../../../_services/campaign.service";
import {Subscription} from "rxjs";
import {Router} from "@angular/router";
import {ComponentCommunicationService} from "../../../_services/component-communication.service";

@Component({
    selector: '[app-list-item]',
    templateUrl: './list-item.component.html',
    styleUrls: ['./list-item.component.scss']
})

export class ListItemComponent {
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

    constructor(private _modalService: NgbModal,
                private campaignService: CampaignService,
                private router: Router,
                private componentComService: ComponentCommunicationService) {}

    editCampaign(id) {
        this.emitter.emit(id);
    }

    emitActive(campaign){
        this.activeEmitter.emit(campaign);
    }

    openPreview(id) {
        this.previewEmitter.emit(id);
    }

    openDetail(id){
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



}
