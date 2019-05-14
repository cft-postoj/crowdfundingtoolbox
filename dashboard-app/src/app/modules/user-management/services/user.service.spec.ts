import {TestBed} from '@angular/core/testing';
import {HttpClient} from '@angular/common/http';
import {UserService} from './user.service';
import {User} from "../models";

describe('UserService', () => {
    let service: UserService;
    let userStub = new User();
    beforeEach(() => {
        const httpClientStub = {
            get: () => ({}),
            post: () => ({}),
            put: () => ({}),
            delete: () => ({})
        };
        const userStub = {id: {}};
        TestBed.configureTestingModule({
            providers: [
                UserService,
                {provide: HttpClient, useValue: httpClientStub},
                {provide: User, useValue: userStub}
            ]
        });
        service = TestBed.get(UserService);
    });
    it('can load instance', () => {
        expect(service).toBeTruthy();
    });
    describe('register', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            const userStub: User = TestBed.get(User);
            spyOn(httpClientStub, 'post');
            service.register(userStub);
            expect(httpClientStub.post).toHaveBeenCalled();
        });
    });
    describe('update', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            spyOn(httpClientStub, 'put');
            service.update(userStub);
            expect(httpClientStub.put).toHaveBeenCalled();
        });
    });
    describe('getAll', () => {
        it('makes expected calls', () => {
            const httpClientStub: HttpClient = TestBed.get(HttpClient);
            spyOn(httpClientStub, 'get');
            service.getAll();
            expect(httpClientStub.get).toHaveBeenCalled();
        });
    });
});
