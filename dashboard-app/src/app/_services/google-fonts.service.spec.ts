import { TestBed } from '@angular/core/testing';

import { GoogleFontsService } from './google-fonts.service';

describe('GoogleFontsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: GoogleFontsService = TestBed.get(GoogleFontsService);
    expect(service).toBeTruthy();
  });
});
