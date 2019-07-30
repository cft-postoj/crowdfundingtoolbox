import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {PayBySquare} from '../../models/pay-by-square';
import {BankTransfer} from '../../models/bank-transfer';

@Component({
    selector: 'app-pay-by-square',
    templateUrl: './pay-by-square.component.html',
    styleUrls: ['./pay-by-square.component.scss']
})
export class PayBySquareComponent implements OnInit {

    public checkedOneTime: boolean = true;
    public loading: boolean = true;
    public paymentForm: FormGroup;
    public alertOpen: boolean = false;
    public alertType: string = 'success';
    public alertMessage: string = '';
    public payBySquareData = new PayBySquare();

    constructor(private paymentMethodsService: PaymentMethodsService, public formBuilder: FormBuilder) {
    }

    ngOnInit() {
        this.getPayBySquareDetails();
        this.initForm();
    }


    initForm() {
        this.paymentForm = this.formBuilder.group({
            'accountNumberOneTime': [this.payBySquareData.oneTimePayment.accountNumber, Validators.required],
            'specificSymbolOneTime': [this.payBySquareData.oneTimePayment.specificSymbol],
            'constantSymbolOneTime': [this.payBySquareData.oneTimePayment.constantSymbol],
            'swiftOneTime': [this.payBySquareData.oneTimePayment.swift],
            'bankNameOneTime': [this.payBySquareData.oneTimePayment.bankName],
            'bankAccountOwnerOneTime': [this.payBySquareData.oneTimePayment.accountOwner],
            'paymentNoteOneTime': [this.payBySquareData.oneTimePayment.paymentNote],
        });
    }

    private getPayBySquareDetails() {
        this.paymentMethodsService.getPayBySquareData().subscribe((data: PayBySquare) => {
            if (data !== null && data !== undefined) {
                this.payBySquareData = data;
            }
            this.initForm();
            this.loading = false;
        });
    }

    public changeCheckedOneTime(checked) {
        this.checkedOneTime = checked;
    }

    public storePayBySquareData() {
        this.payBySquareData.oneTimePayment = {
            accountNumber: this.paymentForm.get('accountNumberOneTime').value,
            specificSymbol: this.paymentForm.get('specificSymbolOneTime').value,
            constantSymbol: this.paymentForm.get('constantSymbolOneTime').value,
            swift: this.paymentForm.get('swiftOneTime').value,
            bankName: this.paymentForm.get('bankNameOneTime').value,
            accountOwner: this.paymentForm.get('bankAccountOwnerOneTime').value,
            paymentNote: this.paymentForm.get('paymentNoteOneTime').value,
            available: this.checkedOneTime
        };
        if (this.payBySquareData.oneTimePayment.available && this.payBySquareData.oneTimePayment.accountNumber.length < 5) {
            this.alertMessage = 'Bank account number in one-time payment is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else {
            this.loading = true;
            this.paymentMethodsService.setPayBySquareData(this.payBySquareData).subscribe((data) => {
                this.alertMessage = 'Successfully updated pay by square details.';
                this.alertOpen = true;
                this.alertType = 'success';
                this.loading = false;
            }, (err) => {
                this.alertMessage = 'There was an error during the updating details.';
                this.alertOpen = true;
                this.alertType = 'danger';
                this.loading = false;
            });
        }
    }

}
