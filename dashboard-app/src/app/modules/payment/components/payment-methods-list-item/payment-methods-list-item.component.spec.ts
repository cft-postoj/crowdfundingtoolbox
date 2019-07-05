import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PaymentMethodsListItemComponent } from './payment-methods-list-item.component';

describe('PaymentMethodsListItemComponent', () => {
  let component: PaymentMethodsListItemComponent;
  let fixture: ComponentFixture<PaymentMethodsListItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PaymentMethodsListItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PaymentMethodsListItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
