import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {CampaignsRoutingModule} from './campaigns-routing.module';
import {NgCircleProgressModule} from 'ng-circle-progress';
import {CoreModule} from '../core/core.module';
import {InlineSVGModule} from 'ng-inline-svg';
import {
    CampaignEditComponent,
    CampaignListItemComponent,
    CampaignSettingsComponent,
    CampaignStatisticsComponent,
    PreviewComponent,
    WidgetEditComponent
} from './components';
import {CampaignListComponent} from './pages/campaign-list/campaign-list.component';
import {CampaignDetailComponent} from './pages/campaign-detail/campaign-detail.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {PreviewMonetizationLiteComponent} from './components/preview-monetization-lite/preview-monetization-lite.component';
import {CampaignNotFoundComponent} from './pages/campaign-not-found/campaign-not-found.component';
import {CampaignsStatsComponent} from './pages/campaigns-stats/campaigns-stats.component';
import {TargetModalComponent} from './components/target-modal/target-modal.component';
import {SignedUsersListComponent} from './components/signed-users-list/signed-users-list.component';
import {WidgetCardComponent} from './components/widget-card/widget-card.component';
import { PreviewMonetizationRowComponent } from './components/preview-monetization-row/preview-monetization-row.component';
import { PreviewMonetizationColumnComponent } from './components/preview-monetization-column/preview-monetization-column.component';
import {TranslateModule} from '@ngx-translate/core';
import { WidgetEditAdditionalTextComponent } from './components/widget-edit-components/widget-edit-additional-text/widget-edit-additional-text.component';

@NgModule({
    declarations: [
        WidgetCardComponent,
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
        PreviewMonetizationRowComponent,
        PreviewMonetizationColumnComponent,
        WidgetEditAdditionalTextComponent,
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
        TranslateModule,
    ],
    exports: [
        WidgetCardComponent,
        CampaignListComponent,
        CampaignEditComponent,
        CampaignSettingsComponent,
        CampaignDetailComponent,
        CampaignStatisticsComponent,
        WidgetEditComponent,
        PreviewComponent,
    ]
})
export class CampaignsModule {
}
