import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpInterceptor,
  HttpRequest,
  HttpResponse
} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Injectable} from '@angular/core';
import {Router} from '@angular/router';
import 'rxjs/add/observable/empty';
import 'rxjs/add/operator/mergeMap';
import {AuthenticationService} from "../services/authentication.service";

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
    return next.handle(request).do((event: HttpEvent<any>) => {
      if (event instanceof HttpResponse) {
        this.sendRequestWithToken(next, request);
      }
    }, (err: any) => {
      if (err instanceof HttpErrorResponse) {
        if (err.status === 401) {
          this.router.navigate(['login']);
        }
      }
    });
  }

}
