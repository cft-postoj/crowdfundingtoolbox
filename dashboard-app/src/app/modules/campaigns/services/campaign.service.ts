import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from 'environments/environment';
import {Observable} from 'rxjs';
import {Campaign, Targeting} from '../models';


@Injectable({providedIn: 'root'})
export class CampaignService {
    constructor(private http: HttpClient) {
    }

    public createCampaign(campaign: Campaign): Observable<any> {
        return this.http.post(environment.backOfficeUrl + environment.campaignUrl, campaign);
    }

    public getCampaignById(campaignId): Observable<any> {
        return this.http.get<Campaign>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}`);
    }

    public getAll(): Observable<Campaign[]> {
        return this.http.get<Campaign[]>(`${environment.backOfficeUrl}${environment.campaignAllUrl}`);
    }

    updateCampaign(campaign: Campaign): Observable<any> {
        return this.http.put(environment.backOfficeUrl + environment.campaignUrl + '/' + campaign.id, campaign);
    }

    deleteCampaign(campaignId) {
        return this.http.delete(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}`);
    }

    private smart(campaignId, smartObject): Observable<any> {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.smart}`, smartObject);
    }

    updateWidgetsHTML(campaignId, htmlsWrapper: any) {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.campaignUrl}/
        ${campaignId}${environment.result}`, htmlsWrapper);
    }

    smartActive(campaignId, variable, value) {
        const smartObject = {};
        smartObject[variable] = value;
        return this.smart(campaignId, smartObject);
    }

    smartDate(campaign) {
        const smartObject = {};
        smartObject['start_date_value'] = campaign.promote_settings.start_date_value;
        smartObject['end_date_value'] = campaign.promote_settings.end_date_value;
        return this.smart(campaign.id, smartObject);
    }


    private writeDatesAsStrings(campaign: Campaign): Campaign {
        const result: Campaign = {...campaign}
        result.promote_settings.start_date_value = this.writeDateAsString(campaign.promote_settings.start_date_json);
        result.promote_settings.end_date_value = this.writeDateAsString(campaign.promote_settings.end_date_json);
        result.targeting.registration.after.date = this.writeDateAsString(result.targeting.registration.after.date);
        result.targeting.registration.before.date = this.writeDateAsString(result.targeting.registration.before.date);
        return result;
    }

    public writeDateAsString(date: any) {
        return `${date.year}-${date.month}-${date.day}`;
    }

    writeDatesAsJson(campaign: Campaign) {
        campaign.promote_settings.start_date_json = this.writeDateAsJson(campaign.promote_settings.start_date_value);
        campaign.promote_settings.end_date_json = this.writeDateAsJson(campaign.promote_settings.end_date_value);
        campaign.targeting.registration.after.date = this.writeDateAsJson(campaign.targeting.registration.after.date);
        campaign.targeting.registration.before.date = this.writeDateAsJson(campaign.targeting.registration.before.date);
    }

    writeDateAsJson(date) {
        const resultArray = date.split('-');
        return {year: +resultArray[0], month: +resultArray[1], day: +resultArray[2]};
    }

    clone(campaignId) {
        return this.http.get(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.clone}`);
    }

    getUsersTargetingCount(targeting: Targeting): Observable<any> {
        return this.http.post(`${environment.backOfficeUrl}${environment.campaignTargeting}/users`, targeting);
    }

    public getCampaignByWidgetId(id: number): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.campaignUrl}/widget/${id}`);
    }

    getTargetingArticlesData(): Observable<any> {
        return this.http.get(`${environment.backOfficeUrl}${environment.campaignTargeting}/articles-data`);
    }
}
