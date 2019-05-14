import { TestBed } from '@angular/core/testing';
import { HttpHandler } from '@angular/common/http';
import { HttpRequest } from '@angular/common/http';
import { Router } from '@angular/router';
import { TokenInterceptor } from './token.interceptor';
import {AuthenticationService} from "../services/authentication.service";
describe('TokenInterceptor', () => {
  let service: TokenInterceptor;
  beforeEach(() => {
    const httpHandlerStub = { handle: () => ({}) };
    const httpRequestStub = { clone: () => ({}) };
    const authenticationServiceStub = { getToken: () => ({}) };
    const routerStub = { url: {} };
    TestBed.configureTestingModule({
      providers: [
        TokenInterceptor,
        { provide: HttpHandler, useValue: httpHandlerStub },
        { provide: HttpRequest, useValue: httpRequestStub },
        { provide: AuthenticationService, useValue: authenticationServiceStub },
        { provide: Router, useValue: routerStub }
      ]
    });
    service = TestBed.get(TokenInterceptor);
  });
  it('can load instance', () => {
    expect(service).toBeTruthy();
  });
  describe('intercept', () => {
    it('makes expected calls', () => {
      const httpHandlerStub: HttpHandler = TestBed.get(HttpHandler);
      const httpRequestStub = TestBed.get(HttpRequest);
      spyOn(httpHandlerStub, 'handle');
      service.intercept(httpRequestStub, httpHandlerStub);
      expect(httpHandlerStub.handle).toHaveBeenCalled();
    });
  });
});
