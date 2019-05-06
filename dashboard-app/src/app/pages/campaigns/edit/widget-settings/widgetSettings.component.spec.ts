import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { CampaignService } from '../../../../_services/campaign.service';
import { GoogleFontsService } from '../../../../_services/google-fonts.service';
import { ImageUploadService } from '../../../../_services/image-upload.service';
import { backgroundTypes } from '../../../../_models/enums';
import { WidgetSettingsComponent } from './widgetSettings.component';
describe('WidgetSettingsComponent', () => {
  let component: WidgetSettingsComponent;
  let fixture: ComponentFixture<WidgetSettingsComponent>;
  beforeEach(() => {
    const campaignServiceStub = {
      createCampaign: () => ({ subscribe: () => ({}) })
    };
    const googleFontsServiceStub = {
      getFonts: () => ({ subscribe: () => ({}) })
    };
    const imageUploadServiceStub = {};
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [WidgetSettingsComponent],
      providers: [
        { provide: CampaignService, useValue: campaignServiceStub },
        { provide: GoogleFontsService, useValue: googleFontsServiceStub },
        { provide: ImageUploadService, useValue: imageUploadServiceStub }
      ]
    });
    fixture = TestBed.createComponent(WidgetSettingsComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('opened defaults to: 1', () => {
    expect(component.opened).toEqual(1);
  });
  it('fontFamily defaults to: []', () => {
    expect(component.fontFamily).toEqual([]);
  });
  it('fontWeight defaults to: []', () => {
    expect(component.fontWeight).toEqual([]);
  });
  it('radioButtons defaults to: []', () => {
    expect(component.radioButtons).toEqual([]);
  });
  it('paddingButtons defaults to: []', () => {
    expect(component.paddingButtons).toEqual([]);
  });
  it('marginButtons defaults to: []', () => {
    expect(component.marginButtons).toEqual([]);
  });
  it('shadowButtons defaults to: []', () => {
    expect(component.shadowButtons).toEqual([]);
  });
  it('radiusButtons defaults to: []', () => {
    expect(component.radiusButtons).toEqual([]);
  });
  it('allRadiusesButton defaults to: []', () => {
    expect(component.allRadiusesButton).toEqual([]);
  });
  it('specificRadiusButtons defaults to: []', () => {
    expect(component.specificRadiusButtons).toEqual([]);
  });
  it('hoverTypes defaults to: []', () => {
    expect(component.hoverTypes).toEqual([]);
  });
  it('allRadiuses defaults to: 0', () => {
    expect(component.allRadiuses).toEqual(0);
  });
  it('backgroundTypes defaults to: backgroundTypes', () => {
    expect(component.backgroundTypes).toEqual(backgroundTypes);
  });
  it('cta defaults to: Default', () => {
    expect(component.cta).toEqual('Default');
  });
});
