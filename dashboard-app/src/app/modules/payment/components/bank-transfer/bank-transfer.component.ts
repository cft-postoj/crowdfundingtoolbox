import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {BankTransfer} from '../../models/bank-transfer';
import {PaymentMethodsService} from '../../services/payment-methods.service';
import {BankButtonService} from '../../services/bank-button.service';
import {forkJoin} from 'rxjs';
import {BankButton} from '../../models/bank-button';
import {Image} from '../../../core/models/image';


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
    bankButtons: BankButton[] = [];

    constructor(private paymentMethodsService: PaymentMethodsService,
                private bankButtonService: BankButtonService, public formBuilder: FormBuilder) {
    }

    ngOnInit() {
        this.getBanksButtons();
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
        if (this.bankTransferData.monthlyPayment.available &&
            this.bankTransferData.monthlyPayment.accountNumber &&
            this.bankTransferData.monthlyPayment.accountNumber.length < 5) {
            this.alertMessage = 'Bank account number in monthly subscription is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else if (this.bankTransferData.oneTimePayment.available &&
            this.bankTransferData.oneTimePayment.accountNumber &&
            this.bankTransferData.oneTimePayment.accountNumber.length < 5) {
            this.alertMessage = 'Bank account number in one-time payment is required in correct shape.';
            this.alertOpen = true;
            this.alertType = 'danger';
        } else {
            this.loading = true;
            const values = forkJoin(
                this.paymentMethodsService.setBankTransferData(this.bankTransferData),
                this.bankButtonService.updateBankButtons(this.bankButtons)
            );
            values.subscribe(data => {
                // handle bank result data from bankButtonService.updateBankButtons
                this.updateBanksButtonsByResult(data[1]);
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
            if (data != null && Object.keys(data).length !== 0) {
                this.bankTransferData = data;
            }
            this.initForm();
            this.loading = false;
        });
    }


    public addNewBankButton() {
        this.bankButtons.push({id: 0, title:'', order: 0, redirect_link: '', image: new Image()});
    }

    private getBanksButtons() {
        this.bankButtonService.getBankButtons().subscribe((result) => {
            this.updateBanksButtonsByResult(result);
        });
    }

    public deleteBankButton(bankButton) {
        this.bankButtons = this.bankButtons.filter(singleItem => {
                return bankButton !== singleItem;
            }
        );
    }

    private updateBanksButtonsByResult(result: BankButton[]) {
        this.bankButtons = result.map(single => {
            if (single.image == null) {
                single.image = new Image();
            }
            return single;
        });
    }
}
