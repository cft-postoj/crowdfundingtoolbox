import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { UserService } from '../_services';
import { AuthenticationService } from '../_services';
import { HomeComponent } from './home.component';
describe('HomeComponent', () => {
  let component: HomeComponent;
  let fixture: ComponentFixture<HomeComponent>;
  beforeEach(() => {
    const userServiceStub = {
      delete: () => ({ pipe: () => ({ subscribe: () => ({}) }) }),
      getAll: () => ({ subscribe: () => ({}) })
    };
    const authenticationServiceStub = {
      currentUser: { subscribe: () => ({}) }
    };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [HomeComponent],
      providers: [
        { provide: UserService, useValue: userServiceStub },
        { provide: AuthenticationService, useValue: authenticationServiceStub }
      ]
    });
    fixture = TestBed.createComponent(HomeComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('users defaults to: []', () => {
    expect(component.users).toEqual([]);
  });
});
