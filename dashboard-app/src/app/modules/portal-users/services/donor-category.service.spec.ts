import { TestBed } from '@angular/core/testing';

import { DonorCategoryService } from './donor-category.service';

describe('DonorCategoryService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: DonorCategoryService = TestBed.get(DonorCategoryService);
    expect(service).toBeTruthy();
  });
});
