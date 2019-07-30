import { ComponentFixture, TestBed } from '@angular/core/testing';
import { NO_ERRORS_SCHEMA } from '@angular/core';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder } from '@angular/forms';
import { LoginComponent } from './login.component';
import {AuthenticationService} from "../../services";
import {ComponentCommunicationService} from "../../../core/services";
import {Routing} from "../../../../constants/config.constants";
describe('LoginComponent', () => {
  let component: LoginComponent;
  let fixture: ComponentFixture<LoginComponent>;
  beforeEach(() => {
    const routerStub = { navigate: () => ({}) };
    const activatedRouteStub = { snapshot: { queryParams: {} } };
    const formBuilderStub = { group: () => ({}) };
    const authenticationServiceStub = {
      currentUserValue: {},
      obtainNewToken: () => ({})
    };
    const componentCommunicationServiceStub = { getLogoutMessage: () => ({}) };
    TestBed.configureTestingModule({
      schemas: [NO_ERRORS_SCHEMA],
      declarations: [LoginComponent],
      providers: [
        { provide: Router, useValue: routerStub },
        { provide: ActivatedRoute, useValue: activatedRouteStub },
        { provide: FormBuilder, useValue: formBuilderStub },
        { provide: AuthenticationService, useValue: authenticationServiceStub },
        {
          provide: ComponentCommunicationService,
          useValue: componentCommunicationServiceStub
        }
      ]
    });
    fixture = TestBed.createComponent(LoginComponent);
    component = fixture.componentInstance;
  });
  it('can load instance', () => {
    expect(component).toBeTruthy();
  });
  it('loading defaults to: false', () => {
    expect(component.loading).toEqual(false);
  });
  it('forgottenPasswordForm defaults to: false', () => {
    expect(component.forgottenPasswordForm).toEqual(false);
  });
  it('submitted defaults to: false', () => {
    expect(component.submitted).toEqual(false);
  });
  it('alertOpen defaults to: false', () => {
    expect(component.alertOpen).toEqual(false);
  });
  it('alertFixed defaults to: true', () => {
    expect(component.alertFixed).toEqual(true);
  });
  it('routing defaults to: Routing', () => {
    expect(component.routing).toEqual(Routing);
  });
  describe('ngOnInit', () => {
    it('makes expected calls', () => {
      const formBuilderStub: FormBuilder = fixture.debugElement.injector.get(
        FormBuilder
      );
      const componentCommunicationServiceStub: ComponentCommunicationService = fixture.debugElement.injector.get(
        ComponentCommunicationService
      );
      spyOn(formBuilderStub, 'group');
      spyOn(componentCommunicationServiceStub, 'getLogoutMessage');
      component.ngOnInit();
      expect(formBuilderStub.group).toHaveBeenCalled();
      expect(
        componentCommunicationServiceStub.getLogoutMessage
      ).toHaveBeenCalled();
    });
  });
});
