import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';
import { Routing } from 'app/constants/config.constants';
import { environment } from 'environments/environment';
import {CampaignEditComponent} from "./campaign-edit.component";
import {CampaignService, PreviewService, WidgetService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {backgroundTypes, devices} from "../../../core/models";

describe('CampaignEditComponent', () => {
  let component: CampaignEditComponent;
  let fixture: ComponentFixture<CampaignEditComponent>;
  beforeEach(() => {
    const changeDetectorRefStub = { detectChanges: () => ({}) };
    const activatedRouteStub = {
      snapshot: { data: {}, paramMap: { get: () => ({}) } },
      parent: { snapshot: { paramMap: { get: () => ({}) } } }
    };
    const routerStub = {
      url: { split: () => ({}) },
      navigateByUrl: () => ({})
    };
    const campaignServiceStub = {
      getCampaignById: () => ({ subscribe: () => ({}) }),
      writeDatesAsJson: () => ({}),
      createCampaign: () => ({ subscribe: () => ({}) }),
      updateWidgetsHTML: () => ({ subscribe: () => ({}) }),
      updateCampaign: () => ({ subscribe: () => ({}) })
    };
    const componentCommunicationServiceStub = { setAlertMessage: () => ({}) };
    const previewServiceStub = {};
    const widgetServiceStub = {
      getListByCampaignId: () => ({ subscribe: () => ({}) })
    };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [CampaignEditComponent],
      providers: [
        { provide: ChangeDetectorRef, useValue: changeDetectorRefStub },
        { provide: ActivatedRoute, useValue: activatedRouteStub },
        { provide: Router, useValue: routerStub },
        { provide: CampaignService, useValue: campaignServiceStub },
        {
          provide: ComponentCommunicationService,
          useValue: componentCommunicationServiceStub
        },
        { provide: PreviewService, useValue: previewServiceStub },
        { provide: WidgetService, useValue: widgetServiceStub }
      ]
    });
    fixture = TestBed.createComponent(CampaignEditComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('widgets defaults to: []', () => {
    expect(component.widgets).toEqual([]);
  });
  it('routing defaults to: Routing', () => {
    expect(component.routing).toEqual(Routing);
  });
  it('loading defaults to: true', () => {
    expect(component.loading).toEqual(true);
  });
  it('error defaults to: false', () => {
    expect(component.error).toEqual(false);
  });
  it('submitted defaults to: false', () => {
    expect(component.submitted).toEqual(false);
  });
  it('saving defaults to: false', () => {
    expect(component.saving).toEqual(false);
  });
  it('deviceType defaults to: devices.desktop.name', () => {
    expect(component.deviceType).toEqual(devices.desktop.name);
  });
  it('creatingHTMLs defaults to: false', () => {
    expect(component.creatingHTMLs).toEqual(false);
  });
  it('environment defaults to: environment', () => {
    expect(component.environment).toEqual(environment);
  });
  it('backgroundTypes defaults to: backgroundTypes', () => {
    expect(component.backgroundTypes).toEqual(backgroundTypes);
  });
  describe('ngOnInit', () => {
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
      component.ngOnInit();
      expect(campaignServiceStub.getCampaignById).toHaveBeenCalled();
      expect(campaignServiceStub.writeDatesAsJson).toHaveBeenCalled();
      expect(widgetServiceStub.getListByCampaignId).toHaveBeenCalled();
    });
  });
  describe('closeEditWindow', () => {
    it('makes expected calls', () => {
      const routerStub: Router = fixture.debugElement.injector.get(Router);
      spyOn(routerStub, 'navigateByUrl');
      component.closeEditWindow();
      expect(routerStub.navigateByUrl).toHaveBeenCalled();
    });
  });
  describe('handleSubmit', () => {
    it('makes expected calls', () => {
      const changeDetectorRefStub: ChangeDetectorRef = fixture.debugElement.injector.get(
        ChangeDetectorRef
      );
      const routerStub: Router = fixture.debugElement.injector.get(Router);
      const campaignServiceStub: CampaignService = fixture.debugElement.injector.get(
        CampaignService
      );
      const componentCommunicationServiceStub: ComponentCommunicationService = fixture.debugElement.injector.get(
        ComponentCommunicationService
      );
      spyOn(component, 'validInput');
      spyOn(changeDetectorRefStub, 'detectChanges');
      spyOn(routerStub, 'navigateByUrl');
      spyOn(campaignServiceStub, 'createCampaign');
      spyOn(campaignServiceStub, 'updateWidgetsHTML');
      spyOn(campaignServiceStub, 'updateCampaign');
      spyOn(componentCommunicationServiceStub, 'setAlertMessage');
      component.handleSubmit();
      expect(component.validInput).toHaveBeenCalled();
      expect(changeDetectorRefStub.detectChanges).toHaveBeenCalled();
      expect(routerStub.navigateByUrl).toHaveBeenCalled();
      expect(campaignServiceStub.createCampaign).toHaveBeenCalled();
      expect(campaignServiceStub.updateWidgetsHTML).toHaveBeenCalled();
      expect(campaignServiceStub.updateCampaign).toHaveBeenCalled();
      expect(
        componentCommunicationServiceStub.setAlertMessage
      ).toHaveBeenCalled();
    });
  });
});
