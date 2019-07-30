import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { Router } from '@angular/router';
import {CampaignService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {CampaignListItemComponent} from "./campaign-list-item.component";
describe('CampaignListItemComponent', () => {
  let component: CampaignListItemComponent;
  let fixture: ComponentFixture<CampaignListItemComponent>;
  beforeEach(() => {
    const ngbModalStub = {
      open: () => ({
        componentInstance: {
          title: {},
          text: {},
          textPrimary: {},
          duplicate: {}
        },
        result: { then: () => ({}) }
      })
    };
    const campaignServiceStub = { clone: () => ({ subscribe: () => ({}) }) };
    const routerStub = { navigateByUrl: () => ({}) };
    const componentCommunicationServiceStub = { setAlertMessage: () => ({}) };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [CampaignListItemComponent],
      providers: [
        { provide: NgbModal, useValue: ngbModalStub },
        { provide: CampaignService, useValue: campaignServiceStub },
        { provide: Router, useValue: routerStub },
        {
          provide: ComponentCommunicationService,
          useValue: componentCommunicationServiceStub
        }
      ]
    });
    fixture = TestBed.createComponent(CampaignListItemComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
});
