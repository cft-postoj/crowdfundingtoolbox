import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {PortalUser} from '../models/portal-user';
import {environment} from '../../../../environments/environment';

@Injectable({
    providedIn: 'root'
})
export class PortalUserService {

    constructor(private http: HttpClient) {
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

}
