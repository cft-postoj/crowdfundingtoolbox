import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Injectable} from '@angular/core';
import {AuthenticationService} from '../_services';
import {Router} from '@angular/router';
import 'rxjs/add/observable/empty';
import 'rxjs/add/operator/mergeMap';
import {environment} from "../../environments/environment";

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

  constructor(private authService: AuthenticationService, private router: Router) {
  }

  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    if (this.router.url === '/login') {
      return next.handle(request);
    }
    return this.sendRequestWithToken(next, request);
  }

  private sendRequestWithToken(next: HttpHandler, request: HttpRequest<any>): Observable<HttpEvent<any>> {
    request = request.clone({
      setHeaders: {
        Authorization: `Bearer ${this.authService.getToken()}`
      }
    });
    return next.handle(request);
  }

}
