import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {Observable} from 'rxjs';
import {PortalUser} from '../models/portal-user';
import {environment} from '../../../../environments/environment';
import {Column} from '../../core/models/column';
import {HelpersService} from '../../core/services/helpers.service';

@Injectable({
    providedIn: 'root'
})
export class PortalUserService {

    constructor(private http: HttpClient, private helpersService: HelpersService) {
    }

    public getAll(): Observable<PortalUser[]> {
        return this.http.get<PortalUser[]>(`${environment.backOfficeUrl}${environment.portalUsersAllUrl}`);
    }

    public getById(id): Observable<PortalUser> {
        return this.http.get<PortalUser>(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${id}`);
    }

    public excludeFromTargeting(exclude: boolean, reason: string, portalUserId: number): Observable<any> {
        let url = environment.backOfficeUrl + environment.editPortalUser + '/' + portalUserId;
        url += environment.excludeFromTargeting;
        return this.http.post(`${url}`, {
            exclude: exclude,
            reason: reason
        });
    }

    public editPortalUser(userData: any, id: number): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.editPortalUser}/${id}`, userData);
    }

    public changePaymentsPairing(portalUserId: number, type: string): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.editPortalUser}/${portalUserId}/preferred-payments-pairing`, {
            pairing_type: type
        });
    }

    public getLastUpdated(portalUserId: number): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${portalUserId}/last-updated`);
    }

    public getDonationsDetailInfo(portalUserId: number) {
        return this.http.get(`${environment.backOfficeUrl}${environment.portalUsersUrl}/${portalUserId}/donations-detail`);
    }

    public importDonors(file: any): Observable<any> {
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.portalUsersUrl}/import/donors`, formData);
    }

    public importSubscribers(file: any): Observable<any> {
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.portalUsersUrl}/import/subscribers`, formData);
    }

    public importSubscribersSvetKrestanstva(file: any): Observable<any> {
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.portalUsersUrl}/import/subscribers-svet-krestanstva`, formData);
    }

    public getPortalUsersFilter(from: string, to: string,
                                monthly,
                                dataType: string,
                                page = '1',
                                filterColumns?: Column[],
                                sort?,
                                pageSize = '10') {

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
        if (filterColumns !== undefined) {
            params = this.helpersService.transformFilterColumnsToParams(params, filterColumns);
        }
        if (sort && sort.sort_by !== null && sort.asc !== null) {
            params = params.append('order_' + sort.sort_by.value_name, sort.asc ? 'ASC' : 'DESC');
        }
        if (pageSize !== undefined) {
            params = params.append('page_size', pageSize);
        }
        params = params.append('page', page);
        return this.http.get<any>(
            `${environment.backOfficeUrl}${environment.portalUsersUrl}${environment.list}`,
            {
                headers: headers,
                params: params
            });
    }

    public getPortalUsersEmails(findingString = '') {
        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        const params = new HttpParams()
            .append('string', findingString)
        return this.http.get<PortalUser[]>(`${environment.backOfficeUrl}${environment.portalUsersFindByStringUrl}`, {
            headers: headers,
            params: params
        } );
    }

    public importIbans(file: any): any {
        const formData: FormData = new FormData();
        formData.append('file', file);
        return this.http.post(`${environment.backOfficeUrl}${environment.portalUsersUrl}/import/users-with-iban`, formData);
    }


}


