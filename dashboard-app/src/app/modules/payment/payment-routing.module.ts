import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {PaymentOptionsComponent} from './pages/payment-options/payment-options.component';
import {DonationsComponent} from './pages/donations/donations.component';
import {UnpairedPaymentsComponent} from './pages/unpaired-payments/unpaired-payments.component';
import {ImportPaymentsComponent} from './pages/import-payments/import-payments.component';
import {DonationDetailComponent} from './pages/donation-detail/donation-detail.component';

const routes: Routes = [
    {
        path: '',
        component: PaymentOptionsComponent
    },
    {
        path: 'payment-options',
        component: PaymentOptionsComponent
    },
    {
        path: 'donations',
        component: DonationsComponent
    },
    {
        path: 'donations/:id',
        component: DonationDetailComponent
    },
    {
        path: 'unpaired-payments',
        component: UnpairedPaymentsComponent
    },
    {
        path: 'import-payments',
        component: ImportPaymentsComponent
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class PaymentRoutingModule {
}
