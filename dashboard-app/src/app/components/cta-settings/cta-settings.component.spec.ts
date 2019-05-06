import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CtaSettingsComponent } from './cta-settings.component';

describe('CtaSettingsComponent', () => {
  let component: CtaSettingsComponent;
  let fixture: ComponentFixture<CtaSettingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CtaSettingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CtaSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
