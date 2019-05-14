import {ComponentFixture, TestBed} from '@angular/core/testing';
import {NO_ERRORS_SCHEMA} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {NgbModal} from '@ng-bootstrap/ng-bootstrap';
import {environment} from 'environments/environment';
import {CampaignDetailComponent} from "./campaign-detail.component";
import {Campaign, Widget} from "../../models";
import {CampaignService, WidgetService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {devices} from "../../../core/models";

describe('CampaignDetailComponent', () => {
    let component: CampaignDetailComponent;
    let fixture: ComponentFixture<CampaignDetailComponent>;
    beforeEach(() => {
        const activatedRouteStub = {params: {subscribe: () => ({})}};
        const routerStub = {navigateByUrl: () => ({})};
        const campaignStub = {id: {}, active: {}};
        const campaignServiceStub = {
            getCampaignById: () => ({subscribe: () => ({})}),
            writeDatesAsJson: () => ({}),
            deleteCampaign: () => ({subscribe: () => ({})}),
            smartActive: () => ({subscribe: () => ({})}),
            smartDate: () => ({subscribe: () => ({})})
        };
        const widgetServiceStub = {
            getListByCampaignId: () => ({subscribe: () => ({})}),
            smartActive: () => ({subscribe: () => ({})})
        };
        const widgetStub = {};
        const ngbModalStub = {
            open: () => ({
                componentInstance: {title: {}, text: {}, textPrimary: {}},
                result: {then: () => ({})}
            })
        };
        const componentCommunicationServiceStub = {
            alert: {subscribe: () => ({})},
            setAlertMessage: () => ({})
        };
        TestBed.configureTestingModule({
            schemas: [NO_ERRORS_SCHEMA],
            declarations: [CampaignDetailComponent],
            providers: [
                {provide: ActivatedRoute, useValue: activatedRouteStub},
                {provide: Router, useValue: routerStub},
                {provide: Campaign, useValue: campaignStub},
                {provide: CampaignService, useValue: campaignServiceStub},
                {provide: WidgetService, useValue: widgetServiceStub},
                {provide: Widget, useValue: widgetStub},
                {provide: NgbModal, useValue: ngbModalStub},
                {
                    provide: ComponentCommunicationService,
                    useValue: componentCommunicationServiceStub
                }
            ]
        });
        fixture = TestBed.createComponent(CampaignDetailComponent);
        component = fixture.componentInstance;
    });
    it('can load instance', () => {
        expect(component).toBeTruthy();
    });
    it('isActive defaults to: true', () => {
        expect(component.isActive).toEqual(true);
    });
    it('loading defaults to: true', () => {
        expect(component.loading).toEqual(true);
    });
    it('widgetsLoading defaults to: true', () => {
        expect(component.widgetsLoading).toEqual(true);
    });
    it('alertOpen defaults to: false', () => {
        expect(component.alertOpen).toEqual(false);
    });
    it('deviceType defaults to: devices.desktop.name', () => {
        expect(component.deviceType).toEqual(devices.desktop.name);
    });
    it('environment defaults to: environment', () => {
        expect(component.environment).toEqual(environment);
    });
    describe('toggleWidgetActive', () => {
        it('makes expected calls', () => {
            const widgetServiceStub: WidgetService = fixture.debugElement.injector.get(
                WidgetService
            );
            const widgetStub: Widget = fixture.debugElement.injector.get(Widget);
            spyOn(widgetServiceStub, 'smartActive');
            component.toggleWidgetActive(widgetStub);
            expect(widgetServiceStub.smartActive).toHaveBeenCalled();
        });
    });
    describe('ngOnInit', () => {
        it('makes expected calls', () => {
            const componentCommunicationServiceStub: ComponentCommunicationService = fixture.debugElement.injector.get(
                ComponentCommunicationService
            );
            spyOn(component, 'getData');
            spyOn(componentCommunicationServiceStub, 'setAlertMessage');
            component.ngOnInit();
            expect(component.getData).toHaveBeenCalled();
            expect(
                componentCommunicationServiceStub.setAlertMessage
            ).toHaveBeenCalled();
        });
    });
    describe('getData', () => {
        it('makes expected calls', () => {
            const campaignServiceStub: CampaignService = fixture.debugElement.injector.get(
                CampaignService
            );
            const widgetServiceStub: WidgetService = fixture.debugElement.injector.get(
                WidgetService
            );
            spyOn(campaignServiceStub, 'getCampaignById');
            spyOn(campaignServiceStub, 'writeDatesAsJson');
            spyOn(widgetServiceStub, 'getListByCampaignId');
            component.getData();
            expect(campaignServiceStub.getCampaignById).toHaveBeenCalled();
            expect(campaignServiceStub.writeDatesAsJson).toHaveBeenCalled();
            expect(widgetServiceStub.getListByCampaignId).toHaveBeenCalled();
        });
    });
    describe('edit', () => {
        it('makes expected calls', () => {
            const routerStub: Router = fixture.debugElement.injector.get(Router);
            spyOn(routerStub, 'navigateByUrl');
            component.edit();
            expect(routerStub.navigateByUrl).toHaveBeenCalled();
        });
    });
    describe('delete', () => {
        it('makes expected calls', () => {
            const routerStub: Router = fixture.debugElement.injector.get(Router);
            const campaignServiceStub: CampaignService = fixture.debugElement.injector.get(
                CampaignService
            );
            const ngbModalStub: NgbModal = fixture.debugElement.injector.get(
                NgbModal
            );
            const componentCommunicationServiceStub: ComponentCommunicationService = fixture.debugElement.injector.get(
                ComponentCommunicationService
            );
            spyOn(routerStub, 'navigateByUrl');
            spyOn(campaignServiceStub, 'deleteCampaign');
            spyOn(ngbModalStub, 'open');
            spyOn(componentCommunicationServiceStub, 'setAlertMessage');
            component.delete();
            expect(routerStub.navigateByUrl).toHaveBeenCalled();
            expect(campaignServiceStub.deleteCampaign).toHaveBeenCalled();
            expect(ngbModalStub.open).toHaveBeenCalled();
            expect(
                componentCommunicationServiceStub.setAlertMessage
            ).toHaveBeenCalled();
        });
    });
});
