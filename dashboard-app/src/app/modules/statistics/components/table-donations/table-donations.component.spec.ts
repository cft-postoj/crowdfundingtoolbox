import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TableDonationsComponent } from './table-donations.component';

describe('TableDonationsComponent', () => {
  let component: TableDonationsComponent;
  let fixture: ComponentFixture<TableDonationsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TableDonationsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TableDonationsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
