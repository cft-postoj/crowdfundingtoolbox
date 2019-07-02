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

    public isMonthlyDonor(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.isMonthlyDonor}`);
    }
}
