import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {environment} from "../../environments/environment";
import {GeneralSettings} from "../_models/general-settings";
import {CtaSettings} from "../_models/cta-settings";
import {WidgetSettings} from "../_models/widget-settings";

@Injectable({
    providedIn: 'root'
})
export class GeneralSettingsService {

    constructor(private http: HttpClient) {
    }

    // GENERAL PAGE SETTINGS
    public updateGeneralPageSettings(settings: GeneralSettings): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.cftSettings}/general-page-settings`, settings);
    }

    // CTA SETTINGS
    public updateCtaSettings(settings: CtaSettings): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.cftSettings}/cta-settings`, settings);
    }

    // WIDGET SETTINGS
    public updateWidgetSettings(settings: WidgetSettings): Observable<any> {
        return this.http.put(`${environment.backOfficeUrl}${environment.cftSettings}/widgets-settings`, settings);
    }

    // GET GENERAL PAGE SETTINGS
    public getGeneralPageSettings(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/general-page-settings`);
    }

    // GET CTA SETTINGS
    public getCtaSettings(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/cta-settings`);
    }

    // GET WIDGET SETTINGS
    public getWidgetSettings(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/widgets-settings`);
    }

    // GET ALL GENERAL SETTINGS
    public getSettings(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/all`);
    }

    // GET DEFAULT COLORS
    public getColors(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/colors`);
    }

    // GET DEFAULT FONTS
    public getFonts(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.cftSettings}/fonts`);
    }
}
