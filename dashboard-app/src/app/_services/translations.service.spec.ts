import { TestBed } from '@angular/core/testing';
import { HttpClient } from '@angular/common/http';
import { TranslationsService } from './translations.service';
describe('TranslationsService', () => {
  let service: TranslationsService;
  beforeEach(() => {
    const httpClientStub = { get: () => ({}) };
    TestBed.configureTestingModule({
      providers: [
        TranslationsService,
        { provide: HttpClient, useValue: httpClientStub }
      ]
    });
    service = TestBed.get(TranslationsService);
  });
  it('can load instance', () => {
    expect(service).toBeTruthy();
  });
  describe('getAll', () => {
    it('makes expected calls', () => {
      const httpClientStub: HttpClient = TestBed.get(HttpClient);
      spyOn(httpClientStub, 'get');
      service.getAll();
      expect(httpClientStub.get).toHaveBeenCalled();
    });
  });
});
