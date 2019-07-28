import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {Observable} from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class PortalConnectonService {

    constructor(private http: HttpClient) {
    }

    public getPortalUrl(): Observable<string> {
        return this.http.get<string>(environment.backOfficeUrl + environment.portalConnections + 'portal-url');
    }

    public setPortalUrl(url: string): Observable<any> {
        return this.http.post(environment.backOfficeUrl + environment.portalConnections + 'portal-url', {
            url: url
        });
    }

    public getBackendUrl(): Observable<string> {
        return this.http.get<string>(environment.backOfficeUrl + environment.portalConnections + 'backend-url');
    }

}
