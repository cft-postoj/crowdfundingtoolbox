import {Component, Input, OnDestroy, OnInit, Output, ViewChild} from "@angular/core";
import {ActivatedRoute, Router} from "@angular/router";
import {NgbModal} from "@ng-bootstrap/ng-bootstrap";
import {Subscription} from "rxjs";
import {environment} from 'environments/environment';
import {Campaign, Widget} from "../../models";
import {devices} from "../../../core/models";
import {CampaignService, WidgetService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {Routing} from "../../../../constants/config.constants";
import {ModalComponent} from "../../../core/parts/atoms";
import {CampaignListComponent} from "../campaign-list/campaign-list.component";
import {UserService} from '../../../user-management/services';
import moment from 'moment/src/moment';
import {StatisticsService} from '../../../statistics/services/statistics.service';

@Component({
    templateUrl: './campaign-detail.component.html',
    styleUrls: ['./campaign-detail.component.scss']
})

export class CampaignDetailComponent implements OnInit, OnDestroy {
    // @ContentChildren(CampaignListComponent) dropdown:
    @ViewChild(CampaignListComponent) child: CampaignListComponent;

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
    widgetForPreview: Widget;
    @Output()
    public campaignStats: any = {};
    public campaignDateSelected: any = {
        start: moment(),
        end: moment()
    };
    public environment = environment;

    public statsPeriod: string = 'total';

    constructor(private router: Router, private route: ActivatedRoute, private campaignService: CampaignService,
                private widgetService: WidgetService, private userService: UserService, private _modalService: NgbModal,
                private componentComService: ComponentCommunicationService, private statisticsService: StatisticsService) {
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
        );
        this.getCampaignStats(null);
        this.changeSubscription = this.componentComService.alert.subscribe(message => {
            if (!!message) {
                this.alertOpen = true;
                this.alertMessage = message;
                this.componentComService.setAlertMessage("");
                this.getData();
            }
            this.alertType = "success";
            this.loading = true;
        })
    }

    ngOnDestroy() {
        //this.changeSubscription.unsubscribe();
    }

    getCampaignStats(event) {
        this.loading = true;
        if (event !== null) {
            this.statsPeriod = event;
        }
        this.statisticsService.campaignStats(parseInt(this.id, 10), this.statsPeriod).subscribe((data) => {
            this.campaignStats = data;
            this.loading = false;
        });
    }

    getData() {
        this.loading = true;
        this.widgetsLoading = true;
        this.campaignService.getCampaignById(this.id).subscribe(
            campaign => {
                this.campaign = campaign.data;
                this.campaignService.writeDatesAsJson(this.campaign);
                // this.campaignService.writeDateAsString(this.campaign);
                this.pageTitle = this.campaign.name;
                setTimeout(() => {
                    this.campaignDateSelected = {
                        start: moment(this.campaign.promote_settings.start_date_value),
                        end: moment(this.campaign.promote_settings.end_date_value)
                    };
                }, 500);
                this.loading = false;
            }
        );
        this.widgetService.getListByCampaignId(this.id).subscribe(
            widgets => {
                this.widgets = widgets.data;
                this.widgetsLoading = false;
            }
        )
    }

    public edit() {
        this.router.navigateByUrl(Routing.CAMPAIGNS_FULL_PATH + "/" + this.campaign.id + "/(" + Routing.RIGHT_OUTLET + ":" + Routing.EDIT + ")");
    }

    public delete() {
        const modalRef = this._modalService.open(ModalComponent);
        this.userService.getUserDetail().subscribe((data) => {
            if (data.role.id === 1) { // if user is admin
                modalRef.componentInstance.title = 'Delete campaign'
                modalRef.componentInstance.text = 'Are you sure you want to delete campaign'
                modalRef.componentInstance.textPrimary = this.campaign.name;
                modalRef.componentInstance.loading = false;

                modalRef.result.then((data) => {
                    //delete
                    this.campaignService.deleteCampaign(this.campaign.id).subscribe(result => {
                        this.changeSubscription.unsubscribe();
                        this.componentComService.setAlertMessage(`Campaign ${this.campaign.name} deleted`)
                        this.router.navigateByUrl(`${Routing.CAMPAIGNS_ALL_FULL_PATH}`);
                    });
                }, (reason) => {
                });
            } else { // user is manager
                modalRef.componentInstance.title = 'Delete campaign'
                modalRef.componentInstance.text = null
                modalRef.componentInstance.textPrimary = 'You don\'t have permissions to make this action!';
                modalRef.componentInstance.loading = false;
            }
        }, (error) => {
            console.log(error);
        });


    }

    public toggleActive(campaign: Campaign) {
        this.campaignService.smartActive(campaign.id, "active", campaign.active).subscribe(result => {
            this.alertOpen = true;
            this.alertMessage = `Campaign status changed to  ${campaign.active ? 'active' : 'disabled'}`;
            this.alertType = "success";
        });
    }

    updateDate(campaign: Campaign) {
        console.log(campaign);
        this.campaignService.smartDate(campaign).subscribe(result => {
            this.alertOpen = true;
            this.alertMessage = `Campaign duration was successfully updated.`;
            this.alertType = 'success';
        });
    }

    openPreview(widget: Widget) {
        this.widgetForPreview = widget;
        this.previewOpen = true;
    }

    public toggleWidgetActive(widget: Widget) {
        this.widgetService.smartActive(widget.id, !widget.active).subscribe(result => {
            widget.active = !widget.active;
            this.alertOpen = true;
            this.alertMessage = `Widget status changed to ${widget.active ? 'active' : 'disabled'}`;
            this.alertType = 'success';
        });
    }

    public momentDateChange(campaign, event) {
        campaign.promote_settings.start_date_value = event.start;
        campaign.promote_settings.end_date_value = event.end;
        this.campaignDateSelected = {
            start: moment(event.start),
            end: moment(event.end)
        };
        this.updateDate(campaign);
    }
}
