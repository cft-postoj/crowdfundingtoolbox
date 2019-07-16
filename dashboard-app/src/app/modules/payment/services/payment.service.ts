import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Payment} from '../models/payment';
import {environment} from '../../../../environments/environment';
import {Donation} from '../../statistics/models/donation';

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

    public pairPaymentToUser(userId: number, iban: string): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.unpairedPayments}/pair-to-user`, {
            user_id: userId,
            iban: iban
        });
    }

    public pairViaIban(paymentIds: Number[]): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.unpairedPayments}/pair-via-iban`, {
            payment_ids: paymentIds
        });
    }

    public getPayments(from: { year: number; month: number; day: number },
                       to: { year: number; month: number; day: number },
                       monthly) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('from', this.writeDateAsString(from))
            .append('to', this.writeDateAsString(to));
        if (monthly !== undefined) {
            params = params.append('monthly', monthly);
        }
        return this.http.get<[Payment]>(
            `${environment.backOfficeUrl}${environment.payment}${environment.list}`,
            {
                headers: headers,
                params: params
            });

    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }

    public checkUploadedFileType(file: File): Observable<any> {
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.importPayments}/check-file-type`, formData);
    }

    public importPayments(file: File): Observable<any> {
        const params = new HttpParams();
        const options = {
            params: params,
            reportProgress: true,
        };
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.importPayments}/import-payments`, formData, options);
    }
}
