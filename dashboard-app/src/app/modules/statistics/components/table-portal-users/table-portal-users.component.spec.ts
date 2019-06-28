import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TablePortalUsersComponent } from './table-portal-users.component';

describe('TablePortalUsersComponent', () => {
  let component: TablePortalUsersComponent;
  let fixture: ComponentFixture<TablePortalUsersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TablePortalUsersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TablePortalUsersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
