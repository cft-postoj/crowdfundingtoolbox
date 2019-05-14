import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { KeyValueDiffers } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {CampaignService} from "../../services";
import {CampaignSettingsComponent} from "./campaign-settings.component";
import {paymentTypes} from "../../../core/models";
describe('CampaignSettingsComponent', () => {
  let component: CampaignSettingsComponent;
  let fixture: ComponentFixture<CampaignSettingsComponent>;
  beforeEach(() => {
    const keyValueDiffersStub = { find: () => ({ create: () => ({}) }) };
    const campaignServiceStub = {};
    const activatedRouteStub = {};
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [CampaignSettingsComponent],
      providers: [
        { provide: KeyValueDiffers, useValue: keyValueDiffersStub },
        { provide: CampaignService, useValue: campaignServiceStub },
        { provide: ActivatedRoute, useValue: activatedRouteStub }
      ]
    });
    fixture = TestBed.createComponent(CampaignSettingsComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('campaignNameLength defaults to: 0', () => {
    expect(component.campaignNameLength).toEqual(0);
  });
  it('opened defaults to: 1', () => {
    expect(component.opened[0]).toEqual(1);
  });
  it('paymentTypes defaults to: paymentTypes', () => {
    expect(component.paymentTypes).toEqual(paymentTypes);
  });
});
