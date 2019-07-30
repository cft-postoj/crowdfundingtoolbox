import { TestBed } from '@angular/core/testing';
import { HttpClient } from '@angular/common/http';
import { LanguageService } from './language.service';
describe('LanguageService', () => {
  let service: LanguageService;
  beforeEach(() => {
    const httpClientStub = { get: () => ({}) };
    TestBed.configureTestingModule({
      providers: [
        LanguageService,
        { provide: HttpClient, useValue: httpClientStub }
      ]
    });
    service = TestBed.get(LanguageService);
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
