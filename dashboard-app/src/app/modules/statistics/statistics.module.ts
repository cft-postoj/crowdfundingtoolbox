import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {StatisticsRoutingModule} from './statistics-routing.module';
import {OverallComponent} from './pages/overall/overall.component';
import {ChartModule} from 'primeng/chart';
import {HttpClientModule} from '@angular/common/http';
import {CoreModule} from '../core/core.module';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {ForceSignPipe} from './pipes/force-sign.pipe';
import {TotalCurrentAndPreviousComponent} from './components/total-current-and-previous/total-current-and-previous.component';
import {InlineSVGModule} from 'ng-inline-svg';
import {PopupStatisticsComponent} from './components/popup-statistics/popup-statistics.component';
import {ArticlesComponent} from './pages/articles/articles.component';
import {CampaignsComponent} from './pages/campaigns/campaigns.component';
import {NavbarStatsComponent} from './components/navbar-stats/navbar-stats.component';
import {TableStatsComponent} from './components/table-stats/table-stats.component';
import {PaymentModule} from '../payment/payment.module';
import {PortalUsersModule} from '../portal-users/portal-users.module';

@NgModule({
    declarations: [OverallComponent, ForceSignPipe, TotalCurrentAndPreviousComponent, PopupStatisticsComponent, ArticlesComponent,
        CampaignsComponent, NavbarStatsComponent, TableStatsComponent],
    imports: [
        CommonModule,
        FormsModule,
        HttpClientModule,
        ReactiveFormsModule,

        StatisticsRoutingModule,
        // our modules
        CoreModule,
        PaymentModule,
        PortalUsersModule,

        ChartModule,
        InlineSVGModule.forRoot(),
    ]
})
export class StatisticsModule {
}
