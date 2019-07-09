import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {environment} from '../../../../environments/environment';
import {Donation} from '../models/donation';
import {Payment} from '../models/payment';

@Injectable({
    providedIn: 'root'
})
export class DonationService {

    constructor(private http: HttpClient) {
    }

    public getDetail(id: number): Observable<Donation> {
        return this.http.get<Donation>(`${environment.backOfficeUrl}${environment.donations}/${id}`);
    }

    public updateAssignment(id: number, userId: number): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.donations}/${id}`, {
            user_id: userId
        });
    }

}
