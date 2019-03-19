import {HttpClient} from "@angular/common/http";

import { Translations } from '../_models';
import {environment} from "environments/environment";
import {Injectable} from "@angular/core";

@Injectable({ providedIn: 'root' })
export class TranslationsService {
    constructor(private http: HttpClient) {}

    getAll() {
        return this.http.get<Translations[]>(`${environment.backOfficeUrl}${environment.translationsAllUrl}`);
    }

    getTranslationsById(id) {
        return this.http.get<Translations[]>(`${environment.backOfficeUrl}${environment.translationsUrl}/${id}`);
    }
}
