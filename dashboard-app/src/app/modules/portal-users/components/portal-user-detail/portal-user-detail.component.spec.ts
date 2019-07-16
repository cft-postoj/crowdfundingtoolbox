import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserDetailComponent } from './portal-user-detail.component';

describe('PortalUserDetailComponent', () => {
  let component: PortalUserDetailComponent;
  let fixture: ComponentFixture<PortalUserDetailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserDetailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
