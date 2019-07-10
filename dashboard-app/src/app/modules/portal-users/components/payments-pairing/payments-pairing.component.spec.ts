import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PaymentsPairingComponent } from './payments-pairing.component';

describe('PaymentsPairingComponent', () => {
  let component: PaymentsPairingComponent;
  let fixture: ComponentFixture<PaymentsPairingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PaymentsPairingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PaymentsPairingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
