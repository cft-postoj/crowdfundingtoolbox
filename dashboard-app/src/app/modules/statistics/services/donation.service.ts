import {Injectable} from '@angular/core';
import {environment} from '../../../../environments/environment';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {DonorsAndDonations} from '../models/donors-and-donations';
import {Donation} from '../models/donation';
import {Observable} from 'rxjs';
import {Column} from '../../core/models/column';
import {HelpersService} from '../../core/services/helpers.service';


@Injectable({
    providedIn: 'root'
})
export class DonationService {

    constructor(private http: HttpClient, private helpersService: HelpersService) {
    }

    public getDonationsGroup(from: string, to: string,
                             interval: 'hour' | 'day' | 'week' | 'month') {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', from)
            .append('to', to)
            .append('interval', interval);

        return this.http.get<{ donations: { date, value } }>(
            `${environment.backOfficeUrl}${environment.donationUrl}${environment.group}`,
            {
                headers: headers,
                params: params
            });
    }

    public getDonationsTotal(from: string, to: string) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', from)
            .append('to', to);

        return this.http.get<{ donations: { date, value } }>(
            `${environment.backOfficeUrl}${environment.donationUrl}${environment.total}`,
            {
                headers: headers,
                params: params
            });
    }

    public getDonorsAndDonationsTotal(from, to) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', from)
            .append('to', to);

        return this.http.get<DonorsAndDonations>(
            `${environment.backOfficeUrl}${environment.statisticsUrl}`,
            {
                headers: headers,
                params: params
            });
    }

    public getDonations(from: string, to: string,
                        monthly, page: number = 1, filterColumns?: Column[], sort?, pageSize: number = 10): Observable<any> {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('from', from)
            .append('to', to)
            .append('page', page + '')
            .append('page_size', pageSize + '');
        if (monthly !== undefined) {
            params = params.append('monthly', monthly);
        }
        if (filterColumns !== undefined) {
            params = this.helpersService.transformFilterColumnsToParams(params, filterColumns);
        }
        if (sort && sort.sort_by !== null && sort.asc !== null) {
            params = params.append('order_' + sort.sort_by.value_name, sort.asc ? 'ASC' : 'DESC');
        }
        return this.http.get<Donation[]>(
            `${environment.backOfficeUrl}${environment.donations}${environment.list}`,
            {
                headers: headers,
                params: params
            });
    }

    // TODO: DRY (duplicate in campaing.service)
    public writeDateAsString(date: any): string {
        return `${date.year}-${date.month}-${date.day}`;
    }

    public getDonationsByUserId(userId, from: string, to: string) {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('from', from)
            .append('to', to);
        return this.http.get<Donation[]>(
            `${environment.backOfficeUrl}${environment.portalUsersUrl}/${userId}${environment.donations}`,
            {
                headers: headers,
                params: params
            });
    }

    public deleteDonation(donationId: number): Observable<any> {
        return this.http.delete<any>(`${environment.backOfficeUrl}${environment.donations}/${donationId}/delete`);
    }
}
