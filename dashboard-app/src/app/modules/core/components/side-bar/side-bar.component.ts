import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {environment} from 'environments/environment';
import {DropdownItem} from "../../models";
import {Campaign} from "../../../campaigns/models/campaign";
import {Routing} from "../../../../constants/config.constants";
import {CampaignService} from "../../../campaigns/services/campaign.service";
import {PreviewService} from "../../../campaigns/services/preview.service";
import {ComponentCommunicationService} from "../../services";
import {AuthenticationService} from "../../../user-management/services";

@Component({
    selector: 'app-side-bar',
    templateUrl: './side-bar.component.html',
    styleUrls: ['./side-bar.component.scss']
})
export class SideBarComponent implements OnInit {

    public toggleTranslations = false;
    public toggleWidgets = false;
    public readonly noActiveItem = 'NO_ACTIVE_ITEM';
    public readonly statisticsItemName = 'STATISTICS';
    public readonly connectionsItemName = 'CONNECTIONS';
    public readonly campaignsItemName = 'CAMPAIGNS';
    public readonly usersItemName = 'USERS';
    public readonly paymentsItemName = 'PAYMENTS';
    public readonly translationsItemName = 'TRANSLATIONS';
    public isActive: boolean;
    public activeItem = this.noActiveItem;

    public sidebarItems: DropdownItem[];
    public campaigns: Campaign[];
    public routing = Routing;

    public previewOpen: boolean = false;
    public environment = environment;

    constructor(private router: Router,
                private authService: AuthenticationService,
                private campaignService: CampaignService,
                private previewService: PreviewService,
                private componentComService: ComponentCommunicationService) {
    }

    ngOnInit() {
        this.getCampaigns();
        this.componentComService.alert.subscribe(message=>{
            this.getCampaignsAndCreateSidebar();
        }, (error) => {
            console.error(error);
        });

        this.previewService.change.subscribe(isOpen => {
            this.previewOpen = isOpen;
        });
    }

    getCampaigns(){
        this.campaignService.getAll().subscribe((campaigns: any) => {
            this.campaigns = campaigns.data;
        }, (error) => {
            console.error(error);
        });
    }

    getCampaignsAndCreateSidebar(){
        this.campaignService.getAll().subscribe((campaigns: any) => {
            if (campaigns.data && campaigns.data.length){
                this.campaigns = campaigns.data;
                this.showItem(this.campaignsItemName)
            }
        }, (error) => {
            console.error(error);
        });
    }

    public showTranslations() {
        this.toggleTranslations = !this.toggleTranslations;
    }

    public showWidgets() {
        this.toggleWidgets = !this.toggleWidgets;
    }

    showItem(itemName: string) {
        if (itemName === this.campaignsItemName) {
            this.sidebarItems = [];
            if (this.campaigns) {
                this.campaigns.forEach(
                    campaign => {
                        this.sidebarItems.push({
                            title: campaign.name,
                            value: "/" + Routing.CAMPAIGNS_FULL_PATH + "/" + campaign.id
                        });
                    }
                );
            }
            this.sidebarItems.push({
                title: "All campaigns",
                value: "/"+Routing.CAMPAIGNS_ALL_FULL_PATH
            });
        }
        this.activeItem = itemName;
        this.isActive = this.activeItem !== this.noActiveItem;
    }
}
