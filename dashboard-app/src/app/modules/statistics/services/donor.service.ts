import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {Column} from '../../core/models/column';
import {Observable} from 'rxjs';

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


    public deleteUser(id: number): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${id}/delete`);
    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }
}
