export class BankTransfer {
    title: string = 'Bank Transfer';
    imgSrc: string = '';
    oneTimePayment: any = {
        accountNumber: '',
        specificSymbol: '',
        constantSymbol: '',
        accountOwner: '',
        additionalText: '',
        available: true
    };
    monthlyPayment: any = {
        accountNumber: '',
        specificSymbol: '',
        constantSymbol: '',
        accountOwner: '',
        additionalText: '',
        available: true
    };
}
