import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SignedUsersListComponent } from './signed-users-list.component';

describe('SignedUsersListComponent', () => {
  let component: SignedUsersListComponent;
  let fixture: ComponentFixture<SignedUsersListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SignedUsersListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SignedUsersListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
