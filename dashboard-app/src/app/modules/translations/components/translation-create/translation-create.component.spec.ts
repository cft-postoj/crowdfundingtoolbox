import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import {TranslationCreateComponent} from "./translation-create.component";
import {LanguageService} from "../../services/language.service";
describe('TranslationCreateComponent', () => {
  let component: TranslationCreateComponent;
  let fixture: ComponentFixture<TranslationCreateComponent>;
  beforeEach(() => {
    const languageServiceStub = { getAll: () => ({ subscribe: () => ({}) }) };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [TranslationCreateComponent],
      providers: [{ provide: LanguageService, useValue: languageServiceStub }]
    });
    fixture = TestBed.createComponent(TranslationCreateComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('languages defaults to: []', () => {
    expect(component.languages).toEqual([]);
  });
});
