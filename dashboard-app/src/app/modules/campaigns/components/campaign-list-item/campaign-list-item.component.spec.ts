import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { CampaignService } from '../../../_services/campaign.service';
import { Router } from '@angular/router';
import { ComponentCommunicationService } from '../../../_services/component-communication.service';
import { CampaignsListItemComponent } from './list-item.component';
describe('CampaignListItemComponent', () => {
  let component: CampaignsListItemComponent;
  let fixture: ComponentFixture<CampaignsListItemComponent>;
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
      declarations: [CampaignsListItemComponent],
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
    fixture = TestBed.createComponent(CampaignsListItemComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
});
