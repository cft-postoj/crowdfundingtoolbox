import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviewMonetizationColumnComponent } from './preview-monetization-column.component';

describe('PreviewMonetizationColumnComponent', () => {
  let component: PreviewMonetizationColumnComponent;
  let fixture: ComponentFixture<PreviewMonetizationColumnComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviewMonetizationColumnComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviewMonetizationColumnComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
