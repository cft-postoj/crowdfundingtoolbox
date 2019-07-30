import {Component, ElementRef, HostListener, OnInit} from '@angular/core';
import {environment} from '../../../../../environments/environment';
import {AuthenticationService} from '../../../user-management/services';
import {Router} from '@angular/router';
import {CampaignService} from '../../../campaigns/services';
import {Routing} from '../../../../constants/config.constants';
import {Campaign} from '../../../campaigns/models';

@Component({
    selector: 'app-responsive',
    templateUrl: './responsive.component.html',
    styleUrls: ['../../components/dashboard/dashboard.component.scss',
        '../../components/top-panel/top-panel.component.scss', './responsive.component.scss']
})
export class ResponsiveComponent implements OnInit {
    public firstName: string;
    public lastName: string;
    public signature: string;
    public role: string;
    public adminPanelActive: boolean = false;
    public showWarning: boolean = true;
    private campaigns: Campaign[];
    public campaignsData: any = [];
    public noCampaigns: boolean = false;
    public loading: boolean = true;
    public alertOpen: boolean = false;
    public alertMessage: string;
    public alertType: string;

    constructor(private eRef: ElementRef, private authService: AuthenticationService, private router: Router,
                private campaignService: CampaignService) {
    }

    ngOnInit() {
        if (localStorage.getItem('token')) {
            this.firstName = localStorage.getItem('user_firstName');
            this.lastName = localStorage.getItem('user_lastName');
            this.signature = this.firstName.slice(0, 1).toUpperCase() +
                this.lastName.slice(0, 1).toUpperCase();
            this.role = localStorage.getItem('user_role');
            this.getCampaigns();
        }
    }

    @HostListener('document:click', ['$event'])
    clickOut(event) {
        if (!this.eRef.nativeElement.contains(event.target)) {
            this.adminPanelActive = false;
        }
    }

    clickPanel() {
        this.adminPanelActive = !this.adminPanelActive;
    }

    closeWarning() {
        this.showWarning = false;
    }

    private getCampaigns() {
        this.campaignService.getAll().subscribe((campaigns: any) => {
            this.campaigns = campaigns.data;
            if (campaigns == null || campaigns.data == null || campaigns.data.length === 0) {
                this.noCampaigns = true;
            } else {
                this.campaigns.forEach(
                    campaign => {
                        console.log(campaign)
                        this.campaignsData.push({
                            id: campaign.id,
                            title: campaign.name,
                            description: campaign.description,
                            active: campaign.active
                        });
                    }
                );
            }
            this.loading = false;
        }, (error) => {
            console.error(error);
            this.loading = false;
        });
    }

    changeActiveCampaign(event, id) {
        this.campaignService.smartActive(id, 'active', event).subscribe(result => {
            this.alertOpen = true;
            this.alertMessage = `Campaign status changed to  ${event ? 'active' : 'disabled'}`;
            this.alertType = 'success';
        });
    }

    logout() {
        this.adminPanelActive = false;
        this.authService.logout(() =>
            this.router.navigate([this.router.navigateByUrl(environment.login)])
        );
    }

}
