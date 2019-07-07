import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {environment} from '../../../../environments/environment';
import {PaymentMethod} from '../models/payment-method';
import {BankTransfer} from '../models/bank-transfer';

@Injectable({
  providedIn: 'root'
})
export class PaymentMethodsService {

  constructor(private http: HttpClient) { }

  public getAll(): Observable<PaymentMethod[]> {
    return this.http.get<PaymentMethod[]>(`${environment.backOfficeUrl}${environment.paymentMethods}`);
  }

  public getBankTransferData(): Observable<BankTransfer> {
    return this.http.get<BankTransfer>(`${environment.backOfficeUrl}${environment.bankTransferMethod}`);
  }


  public setBankTransferData(bankTransferData: BankTransfer): Observable<any> {
    return this.http.put(`${environment.backOfficeUrl}${environment.bankTransferMethod}`, {
      payment_settings: bankTransferData
    });
  }
}
