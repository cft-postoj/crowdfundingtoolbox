import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserDetailDonationsComponent } from './portal-user-detail-donations.component';

describe('PortalUserDetailDonationsComponent', () => {
  let component: PortalUserDetailDonationsComponent;
  let fixture: ComponentFixture<PortalUserDetailDonationsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserDetailDonationsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserDetailDonationsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
