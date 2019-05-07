import {HttpErrorResponse, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import 'rxjs/add/operator/do';
import {Injectable} from '@angular/core';
import {AuthenticationService} from '../_services';
import {Router} from '@angular/router';
import {BehaviorSubject, Observable, throwError} from 'rxjs';
import 'rxjs-compat/add/operator/catch';
import {TokenModel} from '../_models/token.model';
import 'rxjs-compat/add/operator/switchMap';

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
