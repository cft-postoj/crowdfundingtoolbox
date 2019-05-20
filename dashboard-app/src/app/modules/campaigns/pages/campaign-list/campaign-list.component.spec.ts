import {ComponentFixture, TestBed} from '@angular/core/testing';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {Router} from '@angular/router';
import {CampaignListComponent} from "./campaign-list.component";
import {Campaign} from "../../models";
import {CampaignService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {Routing} from "../../../../constants/config.constants";
import {devices} from "../../../core/models";

describe('CampaignListComponent', () => {
    let component: CampaignListComponent;
    let fixture: ComponentFixture<CampaignListComponent>;
    beforeEach(() => {
        const routerStub = {navigateByUrl: () => ({}), navigate: () => ({})};
        const campaignStub = {id: {}, active: {}};
        const campaignServiceStub = {
            getAll: () => ({subscribe: () => ({})}),
            smartActive: () => ({subscribe: () => ({})})
        };
        const componentCommunicationServiceStub = {
            alert: {subscribe: () => ({})},
            setAlertMessage: () => ({})
        };
        TestBed.configureTestingModule({
            schemas: [NO_ERRORS_SCHEMA],
            declarations: [CampaignListComponent],
            providers: [
                {provide: Router, useValue: routerStub},
                {provide: Campaign, useValue: campaignStub},
                {provide: CampaignService, useValue: campaignServiceStub},
                {
                    provide: ComponentCommunicationService,
                    useValue: componentCommunicationServiceStub
                }
            ]
        });
        fixture = TestBed.createComponent(CampaignListComponent);
        component = fixture.componentInstance;
    });
    it('can load instance', () => {
        expect(component).toBeTruthy();
    });
    it('loading defaults to: true', () => {
        expect(component.loading).toEqual(true);
    });
    it('pageTitle defaults to: All campaigns', () => {
        expect(component.pageTitle).toEqual('All campaigns');
    });
    it('routing defaults to: Routing', () => {
        expect(component.routing).toEqual(Routing);
    });
    it('alertOpen defaults to: false', () => {
        expect(component.alertOpen).toEqual(false);
    });
    it('previewOpen defaults to: false', () => {
        expect(component.previewOpen).toEqual(false);
    });
    it('deviceType defaults to: devices.desktop.name', () => {
        expect(component.deviceType).toEqual(devices.desktop.name);
    });
    // describe('handleActiveEmitter', () => {
    //     it('makes expected calls', () => {
    //         const campaignServiceStub: CampaignService = fixture.debugElement.injector.get(
    //             CampaignService
    //         );
    //         spyOn(campaignServiceStub, 'smartActive');
    //         component.handleActiveEmitter(campaignStub);
    //         expect(campaignServiceStub.smartActive).toHaveBeenCalled();
    //     });
    // });
    describe('ngOnInit', () => {
        it('makes expected calls', () => {
            const componentCommunicationServiceStub: ComponentCommunicationService = fixture.debugElement.injector.get(
                ComponentCommunicationService
            );
            spyOn(componentCommunicationServiceStub, 'setAlertMessage');
            component.ngOnInit();
            expect(
                componentCommunicationServiceStub.setAlertMessage
            ).toHaveBeenCalled();
        });
    });
});
