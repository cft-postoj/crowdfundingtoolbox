import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {Observable} from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class StatisticsService {

    constructor(private http: HttpClient) {
    }

    public articlesStats(from: string, to: string): Observable<any> {
        return this.http.post<any>(environment.backOfficeUrl + environment.articlesStatistics, {
            from: from,
            to: to
        });
    }

    public campaignsStats(from: string, to: string): Observable<any> {
        return this.http.post<any>(environment.backOfficeUrl + environment.campagignsStatistics, {
            from: from,
            to: to
        });
    }
}
