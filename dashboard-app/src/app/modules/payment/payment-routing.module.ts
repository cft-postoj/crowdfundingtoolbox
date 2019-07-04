import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {PaymentOptionsComponent} from './pages/payment-options/payment-options.component';

const routes: Routes = [{
  path: '',
  component: PaymentOptionsComponent
}];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PaymentRoutingModule { }
