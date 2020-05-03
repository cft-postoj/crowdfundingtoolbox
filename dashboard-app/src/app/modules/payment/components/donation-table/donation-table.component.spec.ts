import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DonationTableComponent } from './donation-table.component';

describe('TableDonationsComponent', () => {
  let component: DonationTableComponent;
  let fixture: ComponentFixture<DonationTableComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DonationTableComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DonationTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
