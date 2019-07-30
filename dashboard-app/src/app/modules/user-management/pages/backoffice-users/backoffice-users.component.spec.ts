import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BackofficeUsersComponent } from './backoffice-users.component';

describe('BackofficeUsersComponent', () => {
  let component: BackofficeUsersComponent;
  let fixture: ComponentFixture<BackofficeUsersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BackofficeUsersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BackofficeUsersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
