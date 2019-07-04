import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';

import {PaymentRoutingModule} from './payment-routing.module';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {CoreModule} from '../core/core.module';
import {HttpClientModule} from '@angular/common/http';
import { PaymentOptionsComponent } from './pages/payment-options/payment-options.component';
import { PaymentMethodsListComponent } from './components/payment-methods-list/payment-methods-list.component';
import { PaymentMethodsListItemComponent } from './components/payment-methods-list-item/payment-methods-list-item.component';

@NgModule({
    declarations: [PaymentOptionsComponent, PaymentMethodsListComponent, PaymentMethodsListItemComponent],
    imports: [
        CommonModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,

        CoreModule,
        PaymentRoutingModule
    ]
})
export class PaymentModule {
}
