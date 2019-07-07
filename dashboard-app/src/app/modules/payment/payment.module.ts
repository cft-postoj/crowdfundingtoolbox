import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {PaymentRoutingModule} from './payment-routing.module';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {CoreModule} from '../core/core.module';
import {HttpClientModule} from '@angular/common/http';
import { PaymentOptionsComponent } from './pages/payment-options/payment-options.component';
import { PaymentMethodsListComponent } from './components/payment-methods-list/payment-methods-list.component';
import { PaymentMethodsListItemComponent } from './components/payment-methods-list-item/payment-methods-list-item.component';
import { PaymentComponent } from './pages/payment/payment.component';
import { DonationsComponent } from './pages/donations/donations.component';
import { UnpairedPaymentsComponent } from './pages/unpaired-payments/unpaired-payments.component';
import { ImportPaymentsComponent } from './pages/import-payments/import-payments.component';
import {StatisticsModule} from '../statistics/statistics.module';
import { BankTransferComponent } from './components/bank-transfer/bank-transfer.component';
import { DisableControlDirective } from './disable-control.directive';
import { PayBySquareComponent } from './components/pay-by-square/pay-by-square.component';
import { DonationDetailComponent } from './pages/donation-detail/donation-detail.component';

@NgModule({
    declarations: [PaymentOptionsComponent, PaymentMethodsListComponent, PaymentMethodsListItemComponent, PaymentComponent, DonationsComponent, UnpairedPaymentsComponent, ImportPaymentsComponent, BankTransferComponent, DisableControlDirective, PayBySquareComponent, DonationDetailComponent],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,

        CoreModule,
        PaymentRoutingModule,
        StatisticsModule
    ]
})
export class PaymentModule {
}
