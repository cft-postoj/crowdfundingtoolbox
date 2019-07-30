import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { DragAndDropComponent } from './dragAndDrop.component';
import {ImageUploadService} from "../../../services";
describe('DragAndDropComponent', () => {
  let component: DragAndDropComponent;
  let fixture: ComponentFixture<DragAndDropComponent>;
  beforeEach(() => {
    const imageUploadServiceStub = {
      upload: () => ({ subscribe: () => ({}) })
    };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [DragAndDropComponent],
      providers: [
        { provide: ImageUploadService, useValue: imageUploadServiceStub }
      ]
    });
    fixture = TestBed.createComponent(DragAndDropComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('alertOpen defaults to: false', () => {
    expect(component.alertOpen).toEqual(false);
  });
  it('loading defaults to: false', () => {
    expect(component.loading).toEqual(false);
  });
});
