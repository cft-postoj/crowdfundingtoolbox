import {ComponentFixture, TestBed} from '@angular/core/testing';
import {HttpClient} from '@angular/common/http';
import {CampaignService} from './campaign.service';
import {Campaign} from "../models";

describe('CampaignService', () => {

    let mockCampaignService: CampaignService;
    let fixture: ComponentFixture<CampaignService>; (1)

    let service: CampaignService;
    let httpClientStub;
    let campaignStub;
    beforeEach(() => {
        httpClientStub = {
            post: () => ({}),
            get: () => ({}),
            put: () => ({}),
            delete: () => ({})
        };
        campaignStub = {id: {}, date_from: {}, date_to: {}};
        TestBed.configureTestingModule({
            providers: [
                CampaignService,
                {provide: HttpClient, useValue: httpClientStub},
                {provide: Campaign, useValue: campaignStub}
            ]
        });
        service = TestBed.get(CampaignService);
    });
    it('can load instance', () => {
        expect(service).toBeTruthy();
    });
    describe('createCampaign', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            const campaignStub: Campaign = TestBed.get(Campaign);
            spyOn(httpClientStub, 'post');
            service.createCampaign(campaignStub);
            expect(httpClientStub.post).toHaveBeenCalled();
        });
    });
    describe('updateCampaign', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            spyOn(httpClientStub, 'put');
            service.updateCampaign(campaignStub);
            expect(httpClientStub.put).toHaveBeenCalled();
        });
    });
    describe('writeDatesAsJson', () => {
        it('makes expected calls', () => {
            spyOn(service, 'writeDateAsJson');
            service.writeDatesAsJson(campaignStub);
            expect(service.writeDateAsJson).toHaveBeenCalled();
        });
    });
    describe('getAll', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            spyOn(httpClientStub, 'get');
            service.getAll();
            expect(httpClientStub.get).toHaveBeenCalled();
        });
    });
});
