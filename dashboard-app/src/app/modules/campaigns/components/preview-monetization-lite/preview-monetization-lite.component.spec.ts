import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviewMonetizationLiteComponent } from './preview-monetization-lite.component';

describe('PreviewMonetizationLiteComponent', () => {
  let component: PreviewMonetizationLiteComponent;
  let fixture: ComponentFixture<PreviewMonetizationLiteComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviewMonetizationLiteComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviewMonetizationLiteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
