import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WidgetEditAdditionalTextComponent } from './widget-edit-additional-text.component';

describe('WidgetEditAdditionalTextComponent', () => {
  let component: WidgetEditAdditionalTextComponent;
  let fixture: ComponentFixture<WidgetEditAdditionalTextComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WidgetEditAdditionalTextComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WidgetEditAdditionalTextComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
