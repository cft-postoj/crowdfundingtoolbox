import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {environment} from '../../../../environments/environment';
import {PaymentMethod} from '../models/payment-method';

@Injectable({
  providedIn: 'root'
})
export class PaymentMethodsService {

  constructor(private http: HttpClient) { }

  public getAll(): Observable<PaymentMethod[]> {
    return this.http.get<PaymentMethod[]>(`${environment.backOfficeUrl}${environment.paymentMethods}`);
  }
}
