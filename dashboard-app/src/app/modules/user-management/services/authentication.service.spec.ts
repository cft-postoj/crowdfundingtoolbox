import {TestBed} from '@angular/core/testing';
import {HttpClient} from '@angular/common/http';
import {AuthenticationService} from './authentication.service';
import {of} from "rxjs";


class MockHttpClient{
    get(){return of(false)}
    post(){}
}

describe('AuthenticationService', () => {
    let service: AuthenticationService;
    beforeEach(() => {
        TestBed.configureTestingModule({
            providers: [
                AuthenticationService,
                {provide: HttpClient, UserClass: MockHttpClient}
            ]
        });
        service = TestBed.get(AuthenticationService);
    });
    it('can load instance', () => {
        expect(service).toBeTruthy();
    });
    describe('stayLoggedIn', () => {
        it('makes expected calls', () => {
            spyOn(service, 'stayLoggedIn');
            service.stayLoggedIn();
            expect(service.stayLoggedIn).toHaveBeenCalled();
        });
    });
});
