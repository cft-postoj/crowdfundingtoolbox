import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {StatisticsRoutingModule} from './statistics-routing.module';
import {OverallComponent} from './pages/overall/overall.component';
import {ChartModule} from 'primeng/chart';
import {HttpClientModule} from '@angular/common/http';
import {CoreModule} from '../core/core.module';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {DonorsAndDonationsPipe} from './pipes/donors-and-donations.pipe';
import {ForceSignPipe} from './pipes/force-sign.pipe';
import {TotalCurrentAndPreviousComponent} from './components/total-current-and-previous/total-current-and-previous.component';

@NgModule({
    declarations: [OverallComponent, DonorsAndDonationsPipe, ForceSignPipe, TotalCurrentAndPreviousComponent],
    imports: [
        CommonModule,
        FormsModule,
        HttpClientModule,
        ReactiveFormsModule,

        StatisticsRoutingModule,
        CoreModule,
        ChartModule,
    ]
})
export class StatisticsModule {
}
