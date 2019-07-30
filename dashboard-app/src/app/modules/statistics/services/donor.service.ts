import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {DonorsTotal} from '../models/DonorsTotal';

@Injectable({
    providedIn: 'root'
})
export class DonorService {

    constructor(private http: HttpClient) {
    }


    public getDonorsGroup(from, to,
                          interval: 'hour' | 'day' | 'week' | 'month') {

        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', from)
            .append('to', to)
            .append('interval', interval);

        return this.http.get<{ donors: { date, value } }>(
            `${environment.backOfficeUrl}${environment.donorUrl}${environment.group}`,
            {
                headers: headers,
                params: params
            });
    }


    public getDonors(from: string, to: string,
                     monthly,
                     dataType: string,
                     limit: string) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('from', from)
            .append('to', to);
        if (monthly !== undefined) {
            params = params.append('monthly', monthly);
        }
        if (dataType !== undefined) {
            params = params.append('dataType', dataType);
        }
        if (limit !== undefined) {
            params = params.append('limit', limit);
        }
        return this.http.get<any>(
            `${environment.backOfficeUrl}${environment.donorUrl}${environment.all}`,
            {
                headers: headers,
                params: params
            });
    }

    public deleteUser(id: number) {
        return this.http.get(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${id}/delete`);
    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }
}
