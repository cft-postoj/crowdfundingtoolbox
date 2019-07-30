import {Injectable} from '@angular/core';
import {environment} from '../../../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {BankButton} from '../models/bank-button';

@Injectable({
    providedIn: 'root'
})
export class BankButtonService {

    constructor(private http: HttpClient) {
    }

    public getBankButtons() {
        return this.http.get<BankButton[]>(`${environment.backOfficeUrl}${environment.bankButton}`);
    }

    public updateBankButtons(bankButtons: BankButton[])  {
        this.updateOrderValueBasedOnPositionInArray(bankButtons);
        return this.http.put<BankButton[]>(`${environment.backOfficeUrl}${environment.bankButton}`, bankButtons
        );
    }

    // update value of property order based on their current position in array
    private updateOrderValueBasedOnPositionInArray(bankButtons: BankButton[]) {
        bankButtons.forEach((bankButton, index) => {
            bankButton.order = index;
        });
    }
}
