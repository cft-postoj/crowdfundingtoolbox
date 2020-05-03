import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {forkJoin} from 'rxjs';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {CreditCard} from '../../models/card';

@Component({
    selector: 'app-credit-card',
    templateUrl: './credit-card.component.html',
    styleUrls: ['./credit-card.component.scss']
})
export class CreditCardComponent implements OnInit {

    public alertOpen: boolean = false;
    public alertType: string;
    public alertMessage: string;
    public loading: boolean = true;
    public creditCardData: CreditCard = new CreditCard();
    public paymentForm: FormGroup;

    constructor(public formBuilder: FormBuilder, private paymentMethodService: PaymentMethodsService) {
    }

    ngOnInit() {
        this.getCreditCardDetails();
    }

    initForm() {
        this.paymentForm = this.formBuilder.group({
            'emailNotifyMonthly': [this.creditCardData.monthlyPayment.emailNotify, Validators.email],
            'emailNotifyOneTime': [this.creditCardData.oneTimePayment.emailNotify, Validators.email]
        });
    }

    getCreditCardDetails() {
        this.paymentMethodService.getCreditCardData().subscribe((data: CreditCard) => {
            this.creditCardData = data;
            console.log(data);
            this.initForm();
            this.loading = false;
        }, (err) => {
            console.log(err);
            this.loading = false;
        });
    }

    storeCreditCardDetails() {
        this.creditCardData.monthlyPayment = {
            emailNotify: this.paymentForm.get('emailNotifyMonthly').value
        };
        this.creditCardData.oneTimePayment = {
            emailNotify: this.paymentForm.get('emailNotifyOneTime').value
        };
        if (this.creditCardData.monthlyPayment.emailNotify.length < 5) {
            this.alertMessage = 'Notify email address in monthly subscription is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else if (this.creditCardData.oneTimePayment.emailNotify.length < 5) {
            this.alertMessage = 'Notify email address in one-time payment is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else {
            this.loading = true;
            this.paymentMethodService.setCreditCardData(this.creditCardData).subscribe(data => {
                if (data.original === undefined) {
                    this.alertMessage = 'Successfully updated bank transfer details.';
                    this.alertOpen = true;
                    this.alertType = 'success';
                    this.loading = false;
                } else {
                    this.alertMessage = 'One of email addresses are incorrectly typed. Check it and try once more.';
                    this.alertOpen = true;
                    this.alertType = 'danger';
                    this.loading = false;
                }

            }, (err) => {
                this.alertMessage = 'One of email addresses are incorrectly typed. Check it and try once more.';
                this.alertOpen = true;
                this.alertType = 'danger';
                this.loading = false;
            });
        }
    }


}
