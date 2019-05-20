import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviewMonetizationComponent } from './preview-monetization.component';

describe('PreviewMonetizationComponent', () => {
  let component: PreviewMonetizationComponent;
  let fixture: ComponentFixture<PreviewMonetizationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviewMonetizationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviewMonetizationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
