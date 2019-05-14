import { TestBed } from '@angular/core/testing';

import { ConvertHexService } from './convert-hex.service';

describe('ConvertHexService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ConvertHexService = TestBed.get(ConvertHexService);
    expect(service).toBeTruthy();
  });
});
