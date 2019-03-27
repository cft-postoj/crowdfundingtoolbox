import {TestBed} from '@angular/core/testing';
import {HttpHandler, HttpRequest} from '@angular/common/http';
import {AuthenticationService} from '../_services';
import {Router} from '@angular/router';
import {HttpErrorInterceptor} from './httpError.interceptor';
import {of} from "rxjs";

describe('HttpErrorInterceptor', () => {
    let service: HttpErrorInterceptor;
    beforeEach(() => {
        var httpHandlerStub = {
            handle(a){
                return of("HttpHandlerR");
            }}
        const httpRequestStub = {};
        const authenticationServiceStub = {};
        const routerStub = {};
        TestBed.configureTestingModule({
            providers: [
                HttpErrorInterceptor,
                {provide: HttpHandler, useValue: httpHandlerStub},
                {provide: HttpRequest, useValue: httpRequestStub},
                {provide: AuthenticationService, useValue: authenticationServiceStub},
                {provide: Router, useValue: routerStub}
            ]
        });
        service = TestBed.get(HttpErrorInterceptor);
    });
    it('can load instance', () => {
        expect(service).toBeTruthy();
    });
});
