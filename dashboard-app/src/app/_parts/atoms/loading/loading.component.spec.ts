import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { environment } from 'environments/environment';
import { LoadingComponent } from './loading.component';
describe('LoadingComponent', () => {
  let component: LoadingComponent;
  let fixture: ComponentFixture<LoadingComponent>;
  beforeEach(() => {
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [LoadingComponent]
    });
    fixture = TestBed.createComponent(LoadingComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('environment defaults to: environment', () => {
    expect(component.environment).toEqual(environment);
  });
});
