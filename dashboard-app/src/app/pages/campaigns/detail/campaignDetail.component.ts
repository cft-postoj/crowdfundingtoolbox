import {Component, OnDestroy, OnInit, ViewChild} from "@angular/core";
import {ActivatedRoute, Router} from "@angular/router";
import {ListItemComponent} from "../../../_parts/molecules/list-item/list-item.component";
import {Campaign} from "../../../_models/campaign";
import {CampaignService} from "../../../_services/campaign.service";
import {WidgetService} from "../../../_services/widget.service";
import {Widget} from "../../../_models/widget";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {ModalComponent} from "../../../_parts/atoms/modal/modal.component";
import {Routing} from "../../../constants/config.constants";
import {Subscription} from "rxjs";
import {ComponentCommunicationService} from "../../../_services/component-communication.service";
import {devices} from "../../../_models/enums";
import {environment} from 'environments/environment';

@Component({
    templateUrl: './campaignDetail.component.html',
    styleUrls: ['./campaignDetail.component.scss','../../../../sass/classes.scss']
})

export class CampaignDetailComponent implements OnInit, OnDestroy {
    // @ContentChildren(CampaignsComponent) dropdown:
    @ViewChild(ListItemComponent) child: ListItemComponent;

    public dropdownOptions: any;
    public campaign: Campaign = new Campaign();
    public widgets: Widget[];
    public breadcrumbsPages: any;
    public isActiveOverlay: boolean;
    public pageTitle: string;
    public id: string;
    public isActive: boolean = true;
    public loading: boolean = true;
    public widgetsLoading: boolean = true;
    public changeSubscription: Subscription;
    alertOpen = false;
    alertType;
    alertMessage;
    previewOpen;
    deviceType = devices.desktop.name;
    widgetForPreview:Widget;
    public environment = environment;

    constructor(private router: Router, private route: ActivatedRoute, private campaignService: CampaignService,
                private widgetService: WidgetService, private _modalService: NgbModal,
                private componentComService: ComponentCommunicationService) {
        this.isActiveOverlay = false;
        this.pageTitle = 'Campaign name From API';
    }

    ngOnInit(): void {
        this.route.params.subscribe(
            params => {
                this.alertOpen = false;
                this.id = params["id"];
                this.getData();
            }
        )
        this.changeSubscription = this.componentComService.alert.subscribe(message=>{
            if (!!message){
                this.alertOpen = true;
                this.alertMessage = message;
                this.componentComService.setAlertMessage("");
                this.getData();
            }
            this.alertType = "success";
            this.loading = true;
        })
    }

    ngOnDestroy(){
        this.changeSubscription.unsubscribe();
    }

    getData(){
        this.loading  = true;
        this.widgetsLoading = true;
        this.campaignService.getCampaignById(this.id).subscribe(
            campaign => {
                this.campaign = campaign.data;
                this.campaignService.writeDatesAsJson(this.campaign);
                this.pageTitle = this.campaign.name;
                this.loading = false;
            }
        )
        this.widgetService.getListByCampaignId(this.id).subscribe(
            widgets => {
                this.widgets = widgets.data;
                this.widgetsLoading = false;
            }
        )
    }

    public edit() {
         this.router.navigateByUrl(Routing.CAMPAIGNS_FULL_PATH+"/"+this.campaign.id+"/("+Routing.RIGHT_OUTLET+":"+Routing.EDIT +")");
    }

    public delete() {
        const modalRef = this._modalService.open(ModalComponent);
        modalRef.componentInstance.title = "Delete campaign"
        modalRef.componentInstance.text = "Are you sure you want to delete campaign"
        modalRef.componentInstance.textPrimary = this.campaign.name;

        modalRef.result.then((data) => {
            //delete
            this.campaignService.deleteCampaign(this.campaign.id).subscribe(result => {
                this.changeSubscription.unsubscribe();
                this.componentComService.setAlertMessage(`Campaign ${this.campaign.name} deleted`)
                this.router.navigateByUrl(`${Routing.CAMPAIGNS_ALL_FULL_PATH}`);
            });
        }, (reason) => {
        });

    }

    public toggleActive(campaign: Campaign) {
        this.campaignService.smartActive(campaign.id, "active", campaign.active).subscribe( result =>{
            this.alertOpen = true;
            this.alertMessage = `Campaign status changed to  ${campaign.active?'active': 'disabled'}`;
            this.alertType= "success";
        });
    }

    updateDate(campaign: Campaign, dateType: string, dateTypeInMessage: string) {
        this.campaignService.smartDate(campaign, dateType).subscribe(result =>{
            this.alertOpen = true;
            this.alertMessage = `${dateTypeInMessage} of campaign was successfully updated.`;
            this.alertType= "success";
        });
    }

    openPreview(widget:Widget){
        this.widgetForPreview = widget;
        this.previewOpen = true;
    }

    public toggleWidgetActive(widget: Widget) {
        this.widgetService.smartActive(widget.id, widget.active).subscribe(result => {
            this.alertOpen = true;
            this.alertMessage = `Widget status changed to  ${widget.active?'active': 'disabled'}`;
            this.alertType= "success";
        });
    }
}
