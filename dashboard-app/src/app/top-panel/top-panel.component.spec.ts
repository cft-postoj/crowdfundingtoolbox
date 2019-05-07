import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from '../_services';
import { TopPanelComponent } from './top-panel.component';
describe('TopPanelComponent', () => {
  let component: TopPanelComponent;
  let fixture: ComponentFixture<TopPanelComponent>;
  beforeEach(() => {
    const routerStub = { navigate: () => ({}), navigateByUrl: () => ({}) };
    const authenticationServiceStub = { logout: () => ({}) };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [TopPanelComponent],
      providers: [
        { provide: Router, useValue: routerStub },
        { provide: AuthenticationService, useValue: authenticationServiceStub }
      ]
    });
    fixture = TestBed.createComponent(TopPanelComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  describe('logout', () => {
    it('makes expected calls', () => {
      const routerStub: Router = fixture.debugElement.injector.get(Router);
      const authenticationServiceStub: AuthenticationService = fixture.debugElement.injector.get(
        AuthenticationService
      );
      spyOn(routerStub, 'navigate');
      spyOn(routerStub, 'navigateByUrl');
      spyOn(authenticationServiceStub, 'logout');
      component.logout();
      expect(routerStub.navigate).toHaveBeenCalled();
      expect(routerStub.navigateByUrl).toHaveBeenCalled();
      expect(authenticationServiceStub.logout).toHaveBeenCalled();
    });
  });
});
