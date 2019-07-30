import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { DropdownComponent } from './dropdown.component';
import {DropdownItem} from "../../../models";
describe('DropdownComponent', () => {
  let component: DropdownComponent;
  let fixture: ComponentFixture<DropdownComponent>;
  beforeEach(() => {
    const dropdownItemStub = { title: {} };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [DropdownComponent],
      providers: [{ provide: DropdownItem, useValue: dropdownItemStub }]
    });
    fixture = TestBed.createComponent(DropdownComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
});
