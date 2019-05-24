import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserListItemComponent } from './portal-user-list-item.component';

describe('PortalUserListItemComponent', () => {
  let component: PortalUserListItemComponent;
  let fixture: ComponentFixture<PortalUserListItemComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserListItemComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserListItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
