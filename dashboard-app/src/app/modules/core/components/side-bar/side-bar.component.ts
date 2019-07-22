import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {environment} from 'environments/environment';
import {DropdownItem, sidebarType} from '../../models';
import {Campaign} from '../../../campaigns/models';
import {Routing} from '../../../../constants/config.constants';
import {PreviewService, CampaignService} from '../../../campaigns/services';
import {ComponentCommunicationService} from '../../services';
import {AuthenticationService} from '../../../user-management/services';

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
    public readonly settingsItemName = 'SETTINGS';
    public isActive: boolean;
    public activeItem = this.noActiveItem;

    public sidebarItems: DropdownItem[];
    public campaigns: Campaign[];
    public routing = Routing;

    public previewOpen: boolean = false;
    public environment = environment;
    private currentSidebarItemType: { title: string };

    constructor(private router: Router,
                private authService: AuthenticationService,
                private campaignService: CampaignService,
                private previewService: PreviewService,
                private componentComService: ComponentCommunicationService) {
    }

    ngOnInit() {
        if (this.router.routerState.snapshot.url.indexOf('campaigns') > -1) {
            this.getCampaigns();
            this.componentComService.alert.subscribe(message => {
                this.getCampaignsAndCreateSidebar();
            }, (error) => {
                console.error(error);
            });

            this.previewService.change.subscribe(isOpen => {
                this.previewOpen = isOpen;
            });
        } else {
            this.makeItemPublic();
        }
    }

    getCampaigns() {
        this.campaignService.getAll().subscribe((campaigns: any) => {
            this.campaigns = campaigns.data;
        }, (error) => {
            console.error(error);
        });
    }

    getCampaignsAndCreateSidebar() {
        this.campaignService.getAll().subscribe((campaigns: any) => {
            if (campaigns.data && campaigns.data.length) {
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

    private makeItemPublic() {
        const slug = this.router.routerState.snapshot.url.split('/dashboard/')[1].split('/')[0];
        let itemName = null;
        switch (slug.toUpperCase()) {
            case this.usersItemName:
                itemName = this.usersItemName;
                break;
            case this.paymentsItemName:
                itemName = this.paymentsItemName;
                break;
            case this.statisticsItemName:
                itemName = this.statisticsItemName;
                break;
            case this.connectionsItemName:
                itemName = this.connectionsItemName;
                break;
            case this.translationsItemName:
                itemName = this.translationsItemName;
                break;
            case this.settingsItemName:
                itemName = this.settingsItemName;
                break;
        }
        return this.showItem(itemName);
    }

    showItem(itemName: string) {
        if (itemName === this.campaignsItemName) {
            this.sidebarItems = [];
            if (this.campaigns) {
                this.campaigns.forEach(
                    campaign => {
                        this.sidebarItems.push({
                            title: campaign.name,
                            value: '/' + Routing.CAMPAIGNS_FULL_PATH + '/' + campaign.id
                        });
                    }
                );
            }
            this.sidebarItems.push({
                title: 'All campaigns',
                value: '/' + Routing.CAMPAIGNS_ALL_FULL_PATH
            });
            this.isActive = this.activeItem !== this.noActiveItem;
            this.currentSidebarItemType = sidebarType.campaigns;
        } else if (itemName === this.statisticsItemName) {
            this.sidebarItems = [];
            this.sidebarItems.push({
                title: 'Dashboard',
                value: '/' + Routing.DASHBOARD + '/' +  Routing.STATS
            });
            this.sidebarItems.push({
                title: 'Campaigns stats',
                value: '/' + Routing.CAMPAIGNS_FULL_PATH + '/' + Routing.STATS
            });
            this.isActive = this.activeItem !== this.noActiveItem;
            this.currentSidebarItemType = sidebarType.stats;
        } else {
            this.isActive = false;
        }
        this.activeItem = itemName;

    }
}
