import {HttpClient} from "@angular/common/http";

import {environment} from "environments/environment";
import {Injectable} from "@angular/core";
import {Translations} from "../models/translations";

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
