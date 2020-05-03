import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {environment} from '../../../../environments/environment';
import {Observable} from 'rxjs';
import {Column} from '../../core/models/column';
import {HelpersService} from '../../core/services/helpers.service';

@Injectable({
    providedIn: 'root'
})
export class StatisticsService {

    constructor(private http: HttpClient, private helpersService: HelpersService) {
    }

    public getArticles(from: string, to: string, page: number = 1, filterColumns?: Column[], sort?, pageSize: number = 10): Observable<any> {

        const headers = new HttpHeaders().append('Content-Type', 'application/json');
        let params = new HttpParams()
            .append('date_from', from)
            .append('date_to', to)
            .append('page', page + '')
            .append('page_size', pageSize + '');

        if (filterColumns !== undefined) {
            params = this.helpersService.transformFilterColumnsToParams(params, filterColumns);
        }
        if (sort !== undefined && sort.sort_by !== undefined && sort.asc !== undefined) {
            params = params.append('order_' + sort.sort_by.value_name, sort.asc ? 'ASC' : 'DESC');
        }
        return this.http.get<any>(environment.backOfficeUrl + environment.articles + environment.list, {
            headers: headers,
            params: params
        });
    }

    public campaignsStats(from: string, to: string): Observable<any> {
        return this.http.post<any>(environment.backOfficeUrl + environment.campagignsStatistics, {
            from: from,
            to: to
        });
    }

    public campaignStats(id: number, period: string): Observable<any> {
        return this.http.get<any>(environment.backOfficeUrl + environment.campaignStats + '/' + id + '/' + period);
    }
}
