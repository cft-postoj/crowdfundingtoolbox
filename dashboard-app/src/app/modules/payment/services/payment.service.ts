import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Payment} from '../models/payment';
import {environment} from '../../../../environments/environment';
import {Column} from '../../core/models/column';
import {HelpersService} from '../../core/services/helpers.service';

@Injectable({
    providedIn: 'root'
})
export class PaymentService {

    constructor(private http: HttpClient, private helpersService: HelpersService) {
    }

    public getUnpairedPayments(): Observable<Payment[]> {
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

    public getPayments(from: string, to: string, monthly, page: number = 1, filterColumns?: Column[], sort?,
                       pageSize: number = 10): Observable<any> {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('page', page + '')
            .append('page_size', pageSize + '');
        if (from != null) {
            params = params.append('from', from);
        }
        if (to != null) {
            params = params.append('to', to);
        }
        if (monthly != null) {
            params = params.append('monthly', monthly);
        }
        if (filterColumns !== undefined) {
            params = this.helpersService.transformFilterColumnsToParams(params, filterColumns);
        }
        if (sort && sort.sort_by !== null && sort.asc !== null) {
            params = params.append('order_' + sort.sort_by.value_name, sort.asc ? 'ASC' : 'DESC');
        }

        return this.http.get<Payment[]>(
            `${environment.backOfficeUrl}${environment.payment}${environment.list}`,
            {
                headers: headers,
                params: params
            });
    }

    public getPaymentById(id: number) {
        return this.http.get(`${environment.backOfficeUrl}${environment.payment}/${id}`);
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

    public pairAccountNameToPayments(file: File): Observable<any> {
        const params = new HttpParams();
        const options = {
            params: params,
            reportProgress: true,
        };
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.importPayments}/pair-account-name-to-payments`,
            formData, options);
    }

    public bulkPairing(bulkPaymentsPairing: { paymentIds: number[]; userId: any; }): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.bulkPaymentPairing}`, bulkPaymentsPairing);
    }

    public bulkUnpairing(bulkPaymentsUnpairing:  { paymentIds: number[]}): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.bulkPaymentUnpairing}`,
            bulkPaymentsUnpairing);
    }
}
