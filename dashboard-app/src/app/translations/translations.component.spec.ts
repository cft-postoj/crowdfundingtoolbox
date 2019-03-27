import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { LanguageService } from '../_services';
import { TranslationsService } from '../_services';
import { TranslationsComponent } from './translations.component';
describe('TranslationsComponent', () => {
  let component: TranslationsComponent;
  let fixture: ComponentFixture<TranslationsComponent>;
  beforeEach(() => {
    const languageServiceStub = { getAll: () => ({ subscribe: () => ({}) }) };
    const translationsServiceStub = {
      getTranslationsById: () => ({ subscribe: () => ({}) })
    };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [TranslationsComponent],
      providers: [
        { provide: LanguageService, useValue: languageServiceStub },
        { provide: TranslationsService, useValue: translationsServiceStub }
      ]
    });
    fixture = TestBed.createComponent(TranslationsComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('languages defaults to: []', () => {
    expect(component.languages).toEqual([]);
  });
  it('translations defaults to: []', () => {
    expect(component.translations).toEqual([]);
  });
  it('allTranslations defaults to: []', () => {
    expect(component.allTranslations).toEqual([]);
  });
});
