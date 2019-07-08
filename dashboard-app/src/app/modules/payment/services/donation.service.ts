import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {environment} from '../../../../environments/environment';
import {Donation} from '../models/donation';

@Injectable({
    providedIn: 'root'
})
export class DonationService {

    constructor(private http: HttpClient) {
    }

    public getDetail(id: number): Observable<Donation> {
        return this.http.get<Donation>(`${environment.backOfficeUrl}${environment.donations}/${id}`);
    }
}
