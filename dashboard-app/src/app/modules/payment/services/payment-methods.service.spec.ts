import { TestBed } from '@angular/core/testing';

import { PaymentMethodsService } from './payment-methods.service';

describe('PaymentMethodsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PaymentMethodsService = TestBed.get(PaymentMethodsService);
    expect(service).toBeTruthy();
  });
});
