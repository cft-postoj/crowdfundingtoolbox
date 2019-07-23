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
import {TablePortalUsersComponent} from './components/table-portal-users/table-portal-users.component';
import {MonthlyPipe} from './pipes/monthly.pipe';
import {TableDonationsComponent} from './components/table-donations/table-donations.component';
import {PortalUsersModule} from '../portal-users/portal-users.module';
import { TablePaymentsComponent } from './components/table-payments/table-payments.component';
import { PopupStatisticsComponent } from './components/popup-statistics/popup-statistics.component';

@NgModule({
    declarations: [OverallComponent, ForceSignPipe, TotalCurrentAndPreviousComponent,
        TablePortalUsersComponent, MonthlyPipe, TableDonationsComponent, TablePaymentsComponent, PopupStatisticsComponent],
    exports: [
        TableDonationsComponent,
        TablePortalUsersComponent,
        TablePaymentsComponent
    ],
    imports: [
        CommonModule,
        FormsModule,
        HttpClientModule,
        ReactiveFormsModule,

        StatisticsRoutingModule,
        CoreModule,

        ChartModule,
        InlineSVGModule.forRoot(),
    ]
})
export class StatisticsModule {
}
