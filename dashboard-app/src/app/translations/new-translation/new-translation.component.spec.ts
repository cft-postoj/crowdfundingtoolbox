import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { LanguageService } from '../../_services';
import { NewTranslationComponent } from './new-translation.component';
describe('NewTranslationComponent', () => {
  let component: NewTranslationComponent;
  let fixture: ComponentFixture<NewTranslationComponent>;
  beforeEach(() => {
    const languageServiceStub = { getAll: () => ({ subscribe: () => ({}) }) };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [NewTranslationComponent],
      providers: [{ provide: LanguageService, useValue: languageServiceStub }]
    });
    fixture = TestBed.createComponent(NewTranslationComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('languages defaults to: []', () => {
    expect(component.languages).toEqual([]);
  });
});
