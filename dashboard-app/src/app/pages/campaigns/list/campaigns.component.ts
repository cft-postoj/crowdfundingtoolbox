import {Component, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {Router} from '@angular/router';
import {ListItemComponent} from '../../../_parts/molecules/list-item/list-item.component';
import {Campaign} from '../../../_models/campaign';
import {CampaignService} from "../../../_services/campaign.service";
import {DropdownItem} from "../../../_models/dropdown-item";
import {Routing} from "../../../constants/config.constants";
import {ComponentCommunicationService} from "../../../_services/component-communication.service";
import {Subscription} from "rxjs";
import {devices} from "../../../_models/enums";

@Component({
    selector: 'app-campaigns-list',
    templateUrl: './campaigns.component.html',
    styleUrls: ['./campaigns.component.scss'],

})

export class CampaignsComponent implements OnInit, OnDestroy {
    // @ContentChildren(CampaignsComponent) dropdown:
    @ViewChild(ListItemComponent) child: ListItemComponent;

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
        this.changeSubscription.unsubscribe();
    }

    handleActiveEmitter(campaign: Campaign) {
        this.campaignService.smartActive(campaign.id, 'active', campaign.active).subscribe()
    }

    showPreview(id){
        this.previewOpen = true;
        this.previewId = id;
    }

    redirectCampaignDetail(id: any) {
        this.router.navigateByUrl(Routing.CAMPAIGNS_FULL_PATH+"/"+id);

    }
}
