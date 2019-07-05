import {Component, OnInit} from '@angular/core';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {PaymentMethod} from '../../models/payment-method';

@Component({
    selector: 'app-payment-methods-list',
    templateUrl: './payment-methods-list.component.html',
    styleUrls: ['./payment-methods-list.component.scss']
})
export class PaymentMethodsListComponent implements OnInit {

    paymentMethods: PaymentMethod[];
    loading: boolean = true;

    constructor(private paymentMethodsService: PaymentMethodsService) {
    }

    ngOnInit() {
        this.getPaymentMethods();
    }

    private getPaymentMethods() {
        this.paymentMethodsService.getAll().subscribe((data: PaymentMethod[]) => {
            this.paymentMethods = data;
            this.loading = false;
        });
    }

}
