import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {CampaignsRoutingModule} from './campaigns-routing.module';
import {NgCircleProgressModule} from 'ng-circle-progress';
import {CoreModule} from '../core/core.module';
import {InlineSVGModule} from 'ng-inline-svg';
import {
    CampaignEditComponent, CampaignListItemComponent,
    CampaignSettingsComponent,
    CampaignStatisticsComponent,
    CampaignStatusComponent,
    PreviewComponent,
    WidgetEditComponent
} from './components';
import {CampaignListComponent} from './pages/campaign-list/campaign-list.component';
import {CampaignDetailComponent} from './pages/campaign-detail/campaign-detail.component';
import {BrowserModule} from '@angular/platform-browser';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { PreviewMonetizationLiteComponent } from './components/preview-monetization-lite/preview-monetization-lite.component';
import { CampaignNotFoundComponent } from './pages/campaign-not-found/campaign-not-found.component';
import { CampaignsStatsComponent } from './pages/campaigns-stats/campaigns-stats.component';
import { TargetModalComponent } from './components/target-modal/target-modal.component';
import { SignedUsersListComponent } from './components/signed-users-list/signed-users-list.component';

@NgModule({
    declarations: [
        CampaignStatusComponent,
        CampaignListComponent,
        CampaignListItemComponent,
        CampaignEditComponent,
        CampaignSettingsComponent,
        CampaignDetailComponent,
        CampaignStatisticsComponent,
        WidgetEditComponent,
        PreviewComponent,
        PreviewMonetizationLiteComponent,
        CampaignNotFoundComponent,
        CampaignsStatsComponent,
        TargetModalComponent,
        SignedUsersListComponent,
    ],

    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,

        CoreModule,
        CampaignsRoutingModule,
        InlineSVGModule.forRoot(),
        NgCircleProgressModule.forRoot({
            space: -5
        }),
    ],
    exports: [
        CampaignStatusComponent,
        CampaignListComponent,
        CampaignEditComponent,
        CampaignSettingsComponent,
        CampaignDetailComponent,
        CampaignStatisticsComponent,
        WidgetEditComponent,
        PreviewComponent
    ]
})
export class CampaignsModule {
}
