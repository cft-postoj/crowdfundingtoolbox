import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalConnectionsSettingsComponent } from './portal-connnections-settings.component';

describe('PortalConnnectionsSettingsComponent', () => {
  let component: PortalConnectionsSettingsComponent;
  let fixture: ComponentFixture<PortalConnectionsSettingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalConnectionsSettingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalConnectionsSettingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
