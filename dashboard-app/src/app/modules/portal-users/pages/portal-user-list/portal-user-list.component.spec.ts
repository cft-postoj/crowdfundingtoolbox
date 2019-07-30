import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserListComponent } from './portal-user-list.component';

describe('PortalUserListComponent', () => {
  let component: PortalUserListComponent;
  let fixture: ComponentFixture<PortalUserListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
