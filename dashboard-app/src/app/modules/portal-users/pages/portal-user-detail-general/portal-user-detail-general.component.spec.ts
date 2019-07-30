import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserDetailGeneralComponent } from './portal-user-detail-general.component';

describe('PortalUserDetailGeneralComponent', () => {
  let component: PortalUserDetailGeneralComponent;
  let fixture: ComponentFixture<PortalUserDetailGeneralComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserDetailGeneralComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserDetailGeneralComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
