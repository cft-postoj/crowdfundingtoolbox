import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DonationDetailComponent } from './donation-detail.component';

describe('DonationDetailComponent', () => {
  let component: DonationDetailComponent;
  let fixture: ComponentFixture<DonationDetailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DonationDetailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DonationDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
