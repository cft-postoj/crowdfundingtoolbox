import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GoogleFontSettingsComponent } from './google-font-settings.component';

describe('GoogleFontSettingsComponent', () => {
  let component: GoogleFontSettingsComponent;
  let fixture: ComponentFixture<GoogleFontSettingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GoogleFontSettingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GoogleFontSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
