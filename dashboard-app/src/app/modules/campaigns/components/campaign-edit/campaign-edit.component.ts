import {ChangeDetectorRef, Component, EventEmitter, OnDestroy, OnInit, Output, ViewChild} from '@angular/core';
import {AngularEditorConfig} from '@kolkov/angular-editor';
import {ActivatedRoute, Router} from '@angular/router';
import {Routing} from 'app/constants/config.constants';
import {Subscription} from 'rxjs';
import {environment} from 'environments/environment';
import {Campaign, Targeting, Widget} from '../../models';
import {devices, backgroundTypes} from '../../../core/models';
import {CampaignService, PreviewService, WidgetService} from '../../services';
import {ComponentCommunicationService} from '../../../core/services';
import {Target} from '@angular/compiler';


@Component({
    selector: 'app-campaign-edit',
    templateUrl: './campaign-edit.component.html',
    styleUrls: ['../../../core/components/settings/settings.component.scss', './campaign-edit.component.scss']
})

export class CampaignEditComponent implements OnInit {
    @Output() closeEdit: EventEmitter<any> = new EventEmitter();
    campaign: Campaign = new Campaign();
    public widgets: Widget[] = [];

    // property with purpose to detect changes before submitting edited campaign
    id: string;
    public routing = Routing;
    public newCampaign: boolean;
    public loading = true;
    submitted = false;
    public saving: boolean = false;
    public previewOpen;
    deviceType = devices.desktop.name;
    creatingHTMLs = false;
    public createdCampaign;
    public campaignId: any;
    @ViewChild('previewGenerate') previewGenerate;
    public environment = environment;

    public targetedUsersCount: number;
    public targetedVisitorsCount: number;
    public targetedUsers: any = [];

    public targetingLoading: boolean = true;
    public targetingData: Targeting;

    public showUsersList: boolean = false;

    public subscription: Subscription;
    backgroundTypes = backgroundTypes;
    alertType: string = 'danger';
    alertOpen = false;
    alertMessage;

    editorConfig: AngularEditorConfig = {
        editable: true,
        spellcheck: true,
        height: '25rem',
        minHeight: '5rem',
        placeholder: 'Enter text here...',
        translate: 'no',
        uploadUrl: environment.backOfficeUrl + '/upload-wysiwyg', // if needed
        customClasses: [ // optional
            {
                name: 'quote',
                class: 'quote',
            },
            {
                name: 'redText',
                class: 'redText'
            },
            {
                name: 'titleText',
                class: 'titleText',
                tag: 'h1',
            },
        ]
    };


    constructor(private router: Router, private route: ActivatedRoute, private campaignService: CampaignService,
                private componentComService: ComponentCommunicationService,
                private previewService: PreviewService, private widgetService: WidgetService, private ref: ChangeDetectorRef) {
        this.campaign = new Campaign();

    }

    ngOnInit() {
        this.newCampaign = this.route.snapshot.data['new'];
        if (!this.newCampaign) {
            // get id from param map or when param map doesn't contains param id, try to get id from its parent's param map
            this.id = this.route.snapshot.paramMap.get('id') ?
                this.route.snapshot.paramMap.get('id')
                : this.route.parent.snapshot.paramMap.get('id');
            this.getCampaign(this.id);
        } else {
            this.loading = false;
        }
    }

    public getCampaign(id) {
        this.campaignService.getCampaignById(this.id).subscribe((campaign: any) => {
            this.campaign = campaign.data;
            this.loading = false;
            this.widgetService.getListByCampaignId(this.id).subscribe(widgets => {
                this.widgets = widgets.data;
                this.loading = false;
            });
        }, (error) => {
            console.error(error);
        });
    }


    closeEditWindow() {
        const targetUrl = this.router.url.split('/(' + this.routing.RIGHT_OUTLET)[0];
        this.router.navigateByUrl(targetUrl);
    }

    handleSubmit(close) {
        this.submitted = true;
        if (this.validInput()) {
            this.saving = true;
            this.loading = true;
            if (this.newCampaign) {
                this.campaignService.createCampaign(this.campaign).subscribe(
                    campaignResult => {
                        this.campaignId = campaignResult.campaign.id;
                        this.createdCampaign = campaignResult;
                        this.creatingHTMLs = true;
                        this.ref.detectChanges();
                        this.previewGenerate.generateHTMLFromWidgets().subscribe(
                            htmlReadyToSend => {
                                this.campaignService.updateWidgetsHTML(this.campaignId, htmlReadyToSend).subscribe(result => {
                                    if (close) {
                                        const targetUrl = Routing.CAMPAIGNS_FULL_PATH + '/' + this.campaignId;
                                        // let targetUrl = this.router.url.split('/(' + this.routing.RIGHT_OUTLET)[0];
                                        this.router.navigateByUrl(targetUrl);
                                        this.componentComService.setAlertMessage(`Campaign ${this.campaign.name} created.
                                         Please set widgets for this campaign.`);
                                        this.creatingHTMLs = false;
                                    } else {
                                        this.alertType = 'success';
                                        this.alertOpen = true;
                                        this.alertMessage = 'Campaign saved.';
                                        this.saving = false;
                                        this.loading = false;
                                    }
                                });
                            });
                    });
            } else {
                this.campaignService.updateCampaign(this.campaign).subscribe(
                    campaignResult => {
                        this.campaignId = campaignResult.campaign_id;
                        this.createdCampaign = campaignResult;
                        this.creatingHTMLs = true;
                        this.ref.detectChanges();
                        this.previewGenerate.generateHTMLFromWidgets().subscribe(
                            htmlReadyToSend => {
                                this.campaignService.updateWidgetsHTML(this.campaignId, htmlReadyToSend).subscribe(result => {
                                    if (close) {
                                        this.componentComService.setAlertMessage(`Campaign ${this.campaign.name} updated`);
                                        const targetUrl = this.router.url.split('/(' + this.routing.RIGHT_OUTLET)[0];
                                        this.router.navigateByUrl(targetUrl);
                                    } else {
                                        this.alertType = 'success';
                                        this.alertOpen = true;
                                        this.alertMessage = 'Campaign updated.';
                                        this.saving = false;
                                        this.loading = false;
                                    }
                                    this.creatingHTMLs = false;
                                });
                            });
                    }
                );
            }
        }
    }

    validInput() {
        if (!this.campaign.name) {
            this.alertType = 'danger';
            this.alertMessage = 'Campaign name is required';
            this.alertOpen = true;
            return false;
        }
        if (!this.campaign.description) {
            this.alertType = 'danger';
            this.alertMessage = 'Campaign description is required';
            this.alertOpen = true;
            return false;
        }
        if (!this.campaign.promote_settings.is_end_date && !this.campaign.promote_settings.donation_goal_value) {
            this.alertType = 'danger';
            this.alertMessage = 'End date of campaign is required';
            this.alertOpen = true;
            return false;
        }
        // if (!this.campaign.widget_settings.general.background.image.url && (
        //     this.campaign.widget_settings.general.background.type == this.backgroundTypes.image.value ||
        //     this.campaign.widget_settings.general.background.type == this.backgroundTypes.imageOverlay.value)) {
        //     this.errorMessage = 'Please upload image or change background type';
        //     this.error = true;
        //     return false;
        // }
        return true;
    }

    setTargetUsers(data) {
        this.targetedUsersCount = data.count_users;
        this.targetedVisitorsCount = data.count_visitors;
        this.targetedUsers = data.users;
    }

    campaignEmit($event) {
        this.campaign = $event;
        console.log(this.campaign);
    }


}


