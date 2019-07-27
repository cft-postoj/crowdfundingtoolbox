import {Component, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {Router} from '@angular/router';
import {Subscription} from "rxjs";
import {Campaign} from "../../models";
import {devices, DropdownItem} from "../../../core/models";
import {Routing} from "../../../../constants/config.constants";
import {CampaignService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";

@Component({
    selector: 'app-campaigns-list',
    templateUrl: './campaign-list.component.html',
    styleUrls: ['./campaign-list.component.scss'],

})

export class CampaignListComponent implements OnInit, OnDestroy {
    // @ContentChildren(CampaignListComponent) dropdown:
    @ViewChild(CampaignListComponent) child: CampaignListComponent;

    public campaigns: Campaign[];
    public breadcrumbsPages: any;
    public isActiveOverlay: boolean;
    public loading: boolean = true;
    public pageTitle = 'All campaigns';
    public dropdownItems: DropdownItem[];
    public routing = Routing;
    public noCampaigns: boolean;
    public changeSubscription: Subscription;
    alertOpen = false;
    alertType;
    alertMessage;
    public previewOpen: boolean = false;
    public previewId: any;
    deviceType = devices.desktop.name;


    constructor(public router: Router, private campaignService: CampaignService, private componentComService: ComponentCommunicationService) {
        this.isActiveOverlay = false;
    }

    public receiveDataFromChild(id) {
        this.router.navigateByUrl(`${Routing.CAMPAIGNS_ALL_FULL_PATH}/(${Routing.RIGHT_OUTLET}:${Routing.EDIT}/${id})`);
    }

    public receiveCloseAction() {
        this.isActiveOverlay = false;
    }

    ngOnInit(): void {
        this.getData()
        this.changeSubscription = this.componentComService.alert.subscribe(message => {
            if (!!message){
                this.alertOpen = true;
                this.alertMessage = message;
                this.componentComService.setAlertMessage("");
                this.getData()
            }
            this.alertType = "success";
            this.loading = true;
        })
    }

    private getData() {
        this.dropdownItems = [];
        this.campaignService.getAll().subscribe((campaigns: any) => {
            this.campaigns = campaigns.data;
            if (campaigns == null || campaigns.data == null || campaigns.data.length === 0) {
                this.noCampaigns = true;
            } else {
                this.campaigns.forEach(
                    campaign => {
                        this.dropdownItems.push({
                            title: campaign.name,
                            value: `${Routing.CAMPAIGNS_FULL_PATH}/${campaign.id}`
                        });
                    }
                )
            }
            this.loading = false;
        }, (error) => {
            console.error(error);
            this.loading = false;
        });
    }

    public redirectToCampaign(event) {
        this.router.navigate([event]);
        return false;
    }

    ngOnDestroy() {
        if (this.changeSubscription !== undefined) {
            this.changeSubscription.unsubscribe();
        }
    }

    handleActiveEmitter(campaign: Campaign) {
        this.campaignService.smartActive(campaign.id, 'active', campaign.active).subscribe()
    }

    showPreview(id){
        this.previewOpen = true;
        this.previewId = id;
    }

    redirectCampaignDetail(id: any) {
        this.router.navigateByUrl(Routing.CAMPAIGNS_FULL_PATH + '/' + id);

    }
}
