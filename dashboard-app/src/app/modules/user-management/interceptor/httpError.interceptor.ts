import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import 'rxjs/add/operator/do';
import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import {BehaviorSubject, Observable, throwError} from 'rxjs';
import 'rxjs-compat/add/operator/catch';
import 'rxjs-compat/add/operator/switchMap';
import {AuthenticationService} from "../services/authentication.service";
import {TokenModel} from "../models/token.model";

@Injectable()
export class HttpErrorInterceptor implements HttpInterceptor {

    private tokenSubject: BehaviorSubject<TokenModel>;

    constructor(private authenticationService: AuthenticationService, private router: Router) {
        this.tokenSubject = new BehaviorSubject<TokenModel>(null);
    }

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        return next.handle(request).catch((err: HttpErrorResponse) => {
            return throwError(err);
        });
    }

}
