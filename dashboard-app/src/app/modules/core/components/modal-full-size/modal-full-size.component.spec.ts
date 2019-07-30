import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ModalFullSizeComponent } from './modal-full-size.component';

describe('ModalFullSizeComponent', () => {
  let component: ModalFullSizeComponent;
  let fixture: ComponentFixture<ModalFullSizeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalFullSizeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ModalFullSizeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
