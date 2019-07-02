import { TestBed } from '@angular/core/testing';

import { DonorService } from './donor.service';

describe('DonorService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: DonorService = TestBed.get(DonorService);
    expect(service).toBeTruthy();
  });
});
