import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from 'environments/environment'
import {Campaign} from "../_models/campaign";
import {Observable, of} from "rxjs";


@Injectable({providedIn: 'root'})
export class CampaignService {
    constructor(private http: HttpClient) {
    }

    public createCampaign(campaign: Campaign): Observable<any> {
        let campaignToSend = this.writeDatesAsStrings(campaign);
        return this.http.post(environment.backOfficeUrl + environment.campaignUrl, campaignToSend);
    }

    public getCampaignById(campaignId): Observable<any> {
        return this.http.get<Campaign>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}`);
    }

    public getAll(): Observable<Campaign[]> {
        return this.http.get<Campaign[]>(`${environment.backOfficeUrl}${environment.campaignAllUrl}`);
    }

    updateCampaign(campaign: Campaign): Observable<any> {
        let campaignToSend = this.writeDatesAsStrings(campaign);
        return this.http.put(environment.backOfficeUrl + environment.campaignUrl + "/" + campaign.id, campaignToSend);
    }

    deleteCampaign(campaignId){
        return this.http.delete(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}`);
    }

    private smart(campaignId, smartObject): Observable<any> {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.smart}`, smartObject);
    }

    updateWidgetsHTML(campaignId,htmlsWrapper: any) {
        return this.http.put<any>(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.result}`, htmlsWrapper);
    }

    smartActive(campaignId, variable, value) {
        let smartObject = {};
        smartObject[variable] = value;
        return this.smart(campaignId, smartObject);
    }

    smartDate(campaign, variable) {
        let campaignToSend = this.writeDatesAsStrings(campaign)
        let smartObject = {};
        smartObject[variable] = campaignToSend[variable];
         return this.smart(campaign.id, smartObject);
    }


    private writeDatesAsStrings(campaign: Campaign): Campaign {
        let result:Campaign = {...campaign}
        result.date_from = this.writeDateAsString(campaign.date_from)
        result.date_to = this.writeDateAsString(campaign.date_to)
        result.targeting.registration.after.date = this.writeDateAsString(result.targeting.registration.after.date);
        result.targeting.registration.before.date = this.writeDateAsString(result.targeting.registration.before.date);
        return result;
    }

    public writeDateAsString(date: any) {
        return `${date.year}-${date.month}-${date.day}`;
    }

    writeDatesAsJson(campaign: Campaign) {
        campaign.date_from = this.writeDateAsJson(campaign.date_from)
        campaign.date_to = this.writeDateAsJson(campaign.date_to)
        campaign.targeting.registration.after.date = this.writeDateAsJson(campaign.targeting.registration.after.date)
        campaign.targeting.registration.before.date = this.writeDateAsJson(campaign.targeting.registration.before.date)
    }

    writeDateAsJson(date) {
        let resultArray = date.split("-");
        let result = {year: +resultArray[0], month: +resultArray[1], day: +resultArray[2]};
        return result;
    }

    clone(campaignId) {
        return this.http.get(`${environment.backOfficeUrl}${environment.campaignUrl}/${campaignId}${environment.clone}`);
    }
}
