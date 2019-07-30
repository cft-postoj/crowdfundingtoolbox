import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'transferTypeConvertToString'
})
export class TransferTypeConvertToStringPipe implements PipeTransform {

    transform(paymentMethod: number): any {
        switch (paymentMethod) {
            case 1:
                return 'Bank transfer';
            case 2:
                return 'Card pay';
            case 3:
                return 'Pay by square';
            case 4:
                return 'Google pay';
            case 5:
                return 'Apple pay';
        }
        return 'not supported transfer type';
    }

}
