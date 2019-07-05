import {Component, EventEmitter, OnInit, Output} from '@angular/core';
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
    modalContent: string = '';

    @Output()
    modalContentEmit = new EventEmitter();

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

    public openPaymentMethod(id) {
        switch (id) {
            case 1:
                this.modalContent = 'bank-transfer';
                break;
            case 2:
                this.modalContent = 'card-pay';
                break;
            case 3:
                this.modalContent = 'pay-by-square';
                break;
            case 4:
                this.modalContent = 'google-pay';
                break;
            case 5:
                this.modalContent = 'apple-pay';
                break;
            default:
                break;
        }
        if (this.modalContent !== '') {
            this.modalContentEmit.emit(this.modalContent);
        }
    }

}
