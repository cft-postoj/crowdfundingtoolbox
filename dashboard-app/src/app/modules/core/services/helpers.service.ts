import {Injectable} from '@angular/core';
import moment from 'moment/src/moment';

@Injectable({
    providedIn: 'root'
})
export class HelpersService {

    constructor() {
    }

    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }

    public getPaymentType(id: number): string {
        let result = '';
        switch (id) {
            case 1:
                result = 'Bank transfer';
                break;
            case 2:
                result = 'Credit card';
                break;
            case 3:
                result = 'Pay by square';
                break;
            case 4:
                result = 'Google pay';
                break;
            case 5:
                result = 'Apple pay';
                break;
        }
        return result;
    }

    public formatDate(input, format) {
        return moment(input).format(format);
    }
}
