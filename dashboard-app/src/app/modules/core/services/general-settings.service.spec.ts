import { TestBed } from '@angular/core/testing';

import { GeneralSettingsService } from './general-settings.service';

describe('GeneralSettingsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: GeneralSettingsService = TestBed.get(GeneralSettingsService);
    expect(service).toBeTruthy();
  });
});
