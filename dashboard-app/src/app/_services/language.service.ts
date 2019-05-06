import {HttpClient} from '@angular/common/http';
import {Language} from '../_models';
import {Injectable} from '@angular/core';
import {environment} from "environments/environment";

@Injectable({ providedIn: 'root' })
export class LanguageService {
    constructor(private http: HttpClient) {}

    getAll() {
        return this.http.get<Language[]>(`${environment.backOfficeUrl}/languages`);
    }
}
