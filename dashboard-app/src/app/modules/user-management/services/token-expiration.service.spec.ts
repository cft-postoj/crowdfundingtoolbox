import {TokenExpirationService} from './token-expiration.service';

let httpClientSpy: { get: jasmine.Spy };
let tokenExpirationService: TokenExpirationService;

describe('TokenExpirationService', () => {
    beforeEach(() => {
        httpClientSpy = jasmine.createSpyObj('HttpClient', ['get']);
        tokenExpirationService = new TokenExpirationService(<any> httpClientSpy)
    });

    it('should be created', () => {

        expect(tokenExpirationService).toBeTruthy();
    });
});
