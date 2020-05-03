import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserTableComponent } from './portal-user-table.component';

describe('TablePortalUsersComponent', () => {
  let component: PortalUserTableComponent;
  let fixture: ComponentFixture<PortalUserTableComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserTableComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserTableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
