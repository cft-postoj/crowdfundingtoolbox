import { TestBed } from '@angular/core/testing';

import { BankButtonService } from './bank-button.service';

describe('BankButtonService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: BankButtonService = TestBed.get(BankButtonService);
    expect(service).toBeTruthy();
  });
});
