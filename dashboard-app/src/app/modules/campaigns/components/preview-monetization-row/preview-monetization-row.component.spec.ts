import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviewMonetizationRowComponent } from './preview-monetization-row.component';

describe('PreviewMonetizationRowComponent', () => {
  let component: PreviewMonetizationRowComponent;
  let fixture: ComponentFixture<PreviewMonetizationRowComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviewMonetizationRowComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviewMonetizationRowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
