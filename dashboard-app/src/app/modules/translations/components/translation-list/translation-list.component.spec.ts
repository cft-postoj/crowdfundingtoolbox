import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import {LanguageService} from "../../services/language.service";
import {TranslationsService} from "../../services/translations.service";
import {TranslationListComponent} from "./translation-list.component";
describe('TranslationListComponent', () => {
  let component: TranslationListComponent;
  let fixture: ComponentFixture<TranslationListComponent>;
  beforeEach(() => {
    const languageServiceStub = { getAll: () => ({ subscribe: () => ({}) }) };
    const translationsServiceStub = {
      getTranslationsById: () => ({ subscribe: () => ({}) })
    };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [TranslationListComponent],
      providers: [
        { provide: LanguageService, useValue: languageServiceStub },
        { provide: TranslationsService, useValue: translationsServiceStub }
      ]
    });
    fixture = TestBed.createComponent(TranslationListComponent);
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
