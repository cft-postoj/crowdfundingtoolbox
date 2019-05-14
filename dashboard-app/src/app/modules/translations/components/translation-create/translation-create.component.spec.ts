import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { LanguageService } from '../../_services';
import { TranslationCreateComponent } from './new-translation.component';
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
