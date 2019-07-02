import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditPortalUserComponent } from './edit-portal-user.component';

describe('EditPortalUserComponent', () => {
  let component: EditPortalUserComponent;
  let fixture: ComponentFixture<EditPortalUserComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditPortalUserComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditPortalUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
