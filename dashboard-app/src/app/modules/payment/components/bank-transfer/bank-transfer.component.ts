import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {init} from 'protractor/built/launcher';
import {BankTransfer} from '../../models/bank-transfer';
import {PaymentMethodsService} from '../../services/payment-methods.service';

@Component({
    selector: 'app-bank-transfer',
    templateUrl: './bank-transfer.component.html',
    styleUrls: ['./bank-transfer.component.scss']
})
export class BankTransferComponent implements OnInit {

    public checkedOneTime: boolean = true;
    public checkedMonthly: boolean = true;
    public copyFromMonthlySubscription: boolean = false;
    public loading: boolean = true;
    public paymentForm: FormGroup;
    public alertOpen: boolean = false;
    public alertType: string = 'success';
    public alertMessage: string = '';

    public bankTransferData = new BankTransfer();

    constructor(private paymentMethodsService: PaymentMethodsService, public formBuilder: FormBuilder) {
    }

    ngOnInit() {
        this.getBankTransferData();
        this.initForm();
    }


    initForm() {
        this.paymentForm = this.formBuilder.group({
            'accountNumberMonthly': [this.bankTransferData.monthlyPayment.accountNumber, Validators.required],
            'specificSymbolMonthly': [this.bankTransferData.monthlyPayment.specificSymbol],
            'constantSymbolMonthly': [this.bankTransferData.monthlyPayment.constantSymbol],
            'swiftMonthly': [this.bankTransferData.monthlyPayment.swift],
            'bankNameMonthly': [this.bankTransferData.monthlyPayment.bankName],
            'bankAccountOwnerMonthly': [this.bankTransferData.monthlyPayment.accountOwner],
            'paymentNoteMonthly': [this.bankTransferData.monthlyPayment.paymentNote],
            'accountNumberOneTime': [this.bankTransferData.oneTimePayment.accountNumber, Validators.required],
            'specificSymbolOneTime': [this.bankTransferData.oneTimePayment.specificSymbol],
            'constantSymbolOneTime': [this.bankTransferData.oneTimePayment.constantSymbol],
            'swiftOneTime': [this.bankTransferData.oneTimePayment.swift],
            'bankNameOneTime': [this.bankTransferData.oneTimePayment.bankName],
            'bankAccountOwnerOneTime': [this.bankTransferData.oneTimePayment.accountOwner],
            'paymentNoteOneTime': [this.bankTransferData.oneTimePayment.paymentNote],
        });
    }

    changeCheckedOneTime(checked) {
        this.checkedOneTime = checked;
    }

    changeCheckedMonthly(checked) {
        this.checkedMonthly = checked;
    }


    copyInputsFromMonthlySubscription(event) {
        this.copyFromMonthlySubscription = !this.copyFromMonthlySubscription;
        if (this.copyFromMonthlySubscription) {
            this.paymentForm.get('accountNumberOneTime').setValue(this.paymentForm.get('accountNumberMonthly').value);
            this.paymentForm.get('specificSymbolOneTime').setValue(this.paymentForm.get('specificSymbolMonthly').value);
            this.paymentForm.get('constantSymbolOneTime').setValue(this.paymentForm.get('constantSymbolMonthly').value);
            this.paymentForm.get('swiftOneTime').setValue(this.paymentForm.get('swiftMonthly').value);
            this.paymentForm.get('bankNameOneTime').setValue(this.paymentForm.get('bankNameMonthly').value);
            this.paymentForm.get('bankAccountOwnerOneTime').setValue(this.paymentForm.get('bankAccountOwnerMonthly').value);
            this.paymentForm.get('paymentNoteOneTime').setValue(this.paymentForm.get('paymentNoteMonthly').value);
        } else {
            this.paymentForm.get('accountNumberOneTime').setValue(this.bankTransferData.oneTimePayment.accountNumber);
            this.paymentForm.get('specificSymbolOneTime').setValue(this.bankTransferData.oneTimePayment.specificSymbol);
            this.paymentForm.get('constantSymbolOneTime').setValue(this.bankTransferData.oneTimePayment.constantSymbol);
            this.paymentForm.get('swiftOneTime').setValue(this.bankTransferData.oneTimePayment.swift);
            this.paymentForm.get('bankNameOneTime').setValue(this.bankTransferData.oneTimePayment.bankName);
            this.paymentForm.get('bankAccountOwnerOneTime').setValue(this.bankTransferData.oneTimePayment.accountOwner);
            this.paymentForm.get('paymentNoteOneTime').setValue(this.bankTransferData.oneTimePayment.paymentNote);
        }
    }

    public storeBankTransferData() {
        this.bankTransferData.monthlyPayment = {
            accountNumber: this.paymentForm.get('accountNumberMonthly').value,
            specificSymbol: this.paymentForm.get('specificSymbolMonthly').value,
            constantSymbol: this.paymentForm.get('constantSymbolMonthly').value,
            swift: this.paymentForm.get('swiftMonthly').value,
            bankName: this.paymentForm.get('bankNameMonthly').value,
            accountOwner: this.paymentForm.get('bankAccountOwnerMonthly').value,
            paymentNote: this.paymentForm.get('paymentNoteMonthly').value,
            available: this.checkedMonthly
        };
        this.bankTransferData.oneTimePayment = {
            accountNumber: this.paymentForm.get('accountNumberOneTime').value,
            specificSymbol: this.paymentForm.get('specificSymbolOneTime').value,
            constantSymbol: this.paymentForm.get('constantSymbolOneTime').value,
            swift: this.paymentForm.get('swiftOneTime').value,
            bankName: this.paymentForm.get('bankNameOneTime').value,
            accountOwner: this.paymentForm.get('bankAccountOwnerOneTime').value,
            paymentNote: this.paymentForm.get('paymentNoteOneTime').value,
            available: this.checkedOneTime
        };
        if (this.bankTransferData.monthlyPayment.available && this.bankTransferData.monthlyPayment.accountNumber.length < 5) {
            this.alertMessage = 'Bank account number in monthly subscription is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else if (this.bankTransferData.oneTimePayment.available && this.bankTransferData.oneTimePayment.accountNumber.length < 5) {
            this.alertMessage = 'Bank account number in one-time payment is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else {
            this.loading = true;
            this.paymentMethodsService.setBankTransferData(this.bankTransferData).subscribe((data) => {
                this.alertMessage = 'Successfully updated bank transfer details.';
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

    private getBankTransferData() {
        this.paymentMethodsService.getBankTransferData().subscribe((data: BankTransfer) => {
            if (data !== null && data !== undefined) {
                this.bankTransferData = data;
            }
            this.initForm();
            this.loading = false;
        });
    }

}
