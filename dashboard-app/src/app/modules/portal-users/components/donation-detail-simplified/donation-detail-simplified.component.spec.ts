import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DonationDetailSimplifiedComponent } from './donation-detail-simplified.component';

describe('DonationDetailSimplifiedComponent', () => {
  let component: DonationDetailSimplifiedComponent;
  let fixture: ComponentFixture<DonationDetailSimplifiedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DonationDetailSimplifiedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DonationDetailSimplifiedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
