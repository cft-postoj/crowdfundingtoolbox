import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Payment} from '../models/payment';
import {environment} from '../../../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class PaymentService {

    constructor(private http: HttpClient) {
    }

    public getUnpairedPayments(): Observable<Payment[]> {
        console.log(`${environment.backOfficeUrl}${environment.unpairedPayments}`)
        return this.http.get<Payment[]>(`${environment.backOfficeUrl}${environment.unpairedPayments}`);
    }

    public pairPaymentToUser(paymentId: number, userId: number, iban: string): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.unpairedPayments}/pair-to-user`, {
            payment_id: paymentId,
            user_id: userId,
            iban: iban
        });
    }

    public pairViaIban(paymentIds: Number[]): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.unpairedPayments}/pair-via-iban`, {
            payment_ids: paymentIds
        });
    }
}
