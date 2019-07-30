import { TestBed } from '@angular/core/testing';

import { ExportCsvService } from './export-csv.service';

describe('ExportCsvService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ExportCsvService = TestBed.get(ExportCsvService);
    expect(service).toBeTruthy();
  });
});
