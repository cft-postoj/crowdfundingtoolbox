import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BankTransferComponent } from './bank-transfer.component';

describe('BankTransferComponent', () => {
  let component: BankTransferComponent;
  let fixture: ComponentFixture<BankTransferComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BankTransferComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BankTransferComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
