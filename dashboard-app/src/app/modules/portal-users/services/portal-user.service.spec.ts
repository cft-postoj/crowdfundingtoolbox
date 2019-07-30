import { TestBed } from '@angular/core/testing';

import { PortalUserService } from './portal-user.service';

describe('PortalUserService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PortalUserService = TestBed.get(PortalUserService);
    expect(service).toBeTruthy();
  });
});
