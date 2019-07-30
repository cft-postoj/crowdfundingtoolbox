import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'environments/environment';
import {User} from "../models";
import {Observable} from 'rxjs';
import {UserDetail} from '../models/userDetail';


@Injectable({ providedIn: 'root' })
export class UserService {
    constructor(private http: HttpClient) { }

    public getUserDetail(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.userDetail}`);
    }

    public updateUserDetail(userDetail: UserDetail): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.userDetail}`, userDetail);
    }

    public createBackOfficeUser(userDetail: UserDetail): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.userDetail}`, userDetail);
    }

    public checkGeneratedResetToken(generatedToken: string): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.checkGeneratedResetToken}`, {
            'generatedToken': generatedToken
        });
    }

    getAll() {
        return this.http.get<User[]>(`${environment.backOfficeUrl}/all`);
    }

    getById(id: number) {
        return this.http.get(`${environment.apiUrl}${environment.userUrl}/${id}`);
    }

    register(user: User) {
        return this.http.post(`${environment.apiUrl}${environment.userRegisterUrl}`, user);
    }

    update(user: User) {
        return this.http.put(`${environment.apiUrl}${environment.userUrl}/${user.id}`, user);
    }

    delete(id: number) {
        return this.http.delete(`${environment.backOfficeUrl}/user/${id}`);
    }
}
