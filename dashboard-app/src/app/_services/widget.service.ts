import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from 'environments/environment'
import {Observable, of} from "rxjs";
import {Widget} from "../_models/widget";
import {Campaign} from "../_models/campaign";


@Injectable({
  providedIn: 'root'
})
export class WidgetService {

    constructor(private http: HttpClient) {
    }

    public getListByCampaignId(campaignId): Observable<any> {
        return this.http.get<Widget>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.widgetsUrl}`);
    }

    public getById(widgetId): Observable<any> {
        return this.http.get<Widget>(`${environment.backOfficeUrl}${environment.widgetsUrl}/${widgetId}`);
    }

    updateWidget(widget: Widget) {
        return this.http.put(environment.backOfficeUrl + environment.widgetsUrl + "/" + widget.id, widget);
    }

    updateWidgetsHTML(widgetId: number, htmlsWrapper: any) {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.widgetsUrl}/${widgetId}${environment.result}`, htmlsWrapper.widgets[0]);
    }

    smartActive(widgetId: number, active: boolean) {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.widgetsUrl}/${widgetId}${environment.smart}`, {active: active});
    }
}
