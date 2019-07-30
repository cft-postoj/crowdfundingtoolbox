import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {environment} from "environments/environment";
import {Language} from "../models/language";

@Injectable({ providedIn: 'root' })
export class LanguageService {
    constructor(private http: HttpClient) {}

    getAll() {
        return this.http.get<Language[]>(`${environment.backOfficeUrl}/languages`);
    }
}
