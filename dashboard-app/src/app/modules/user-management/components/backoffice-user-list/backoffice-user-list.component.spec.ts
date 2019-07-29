import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BackofficeUserListComponent } from './backoffice-user-list.component';

describe('BackofficeUserListComponent', () => {
  let component: BackofficeUserListComponent;
  let fixture: ComponentFixture<BackofficeUserListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BackofficeUserListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BackofficeUserListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
