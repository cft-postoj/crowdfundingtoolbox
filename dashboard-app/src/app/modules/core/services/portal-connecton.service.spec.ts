import { TestBed } from '@angular/core/testing';

import { PortalConnectonService } from './portal-connecton.service';

describe('PortalConnectonService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: PortalConnectonService = TestBed.get(PortalConnectonService);
    expect(service).toBeTruthy();
  });
});
