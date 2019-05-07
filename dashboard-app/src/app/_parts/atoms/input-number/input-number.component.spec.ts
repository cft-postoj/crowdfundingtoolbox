import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { environment } from 'environments/environment';
import { InputNumberComponent } from './input-number.component';
describe('InputNumberComponent', () => {
  let component: InputNumberComponent;
  let fixture: ComponentFixture<InputNumberComponent>;
  beforeEach(() => {
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [InputNumberComponent]
    });
    fixture = TestBed.createComponent(InputNumberComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('environment defaults to: environment', () => {
    expect(component.environment).toEqual(environment);
  });
});
