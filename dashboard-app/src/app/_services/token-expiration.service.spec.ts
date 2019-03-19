import { TestBed } from '@angular/core/testing';

import { TokenExpirationService } from './token-expiration.service';

describe('TokenExpirationService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: TokenExpirationService = TestBed.get(TokenExpirationService);
    expect(service).toBeTruthy();
  });
});
