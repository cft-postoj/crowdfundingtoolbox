import {Injectable} from '@angular/core';
import {environment} from '../../../../environments/environment';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class DonationService {

    constructor(private http: HttpClient) {
    }

    public getDonations(from: { year: number; month: number; day: number },
                        to: { year: number; month: number; day: number },
                        interval: 'hour' | 'day' | 'week' | 'month'
    ) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', this.writeDateAsString(from))
            .append('to', this.writeDateAsString(to))
            .append('interval', interval);

        return this.http.get<{ donations: { date, value } }>(`${environment.backOfficeUrl}${environment.donationUrl}`, {
            headers: headers,
            params: params
        });
    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }
}
