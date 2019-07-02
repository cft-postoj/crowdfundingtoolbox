import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {DonorStats} from '../models/donor-stats';

@Injectable({
    providedIn: 'root'
})
export class DonorService {

    constructor(private http: HttpClient) {
    }


    public getDonorsGroup(from: { year: number; month: number; day: number },
                          to: { year: number; month: number; day: number },
                          interval: 'hour' | 'day' | 'week' | 'month') {

        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', this.writeDateAsString(from))
            .append('to', this.writeDateAsString(to))
            .append('interval', interval);

        return this.http.get<{ donors: { date, value } }>(
            `${environment.backOfficeUrl}${environment.donorUrl}${environment.group}`,
            {
                headers: headers,
                params: params
            });
    }


    public getDonors(from: { year: number; month: number; day: number },
                     to: { year: number; month: number; day: number },
                     monthly) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('from', this.writeDateAsString(from))
            .append('to', this.writeDateAsString(to));
        if (monthly !== undefined) {
            params = params.append('monthly', monthly);
        }
        return this.http.get<[any]>(
            `${environment.backOfficeUrl}${environment.donorUrl}${environment.all}`,
            {
                headers: headers,
                params: params
            });
    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }
}
