import {GoogleFontsService} from './google-fonts.service';
import {HttpClient} from "@angular/common/http";

let httpClientSpy: { get: jasmine.Spy };
let fontService: GoogleFontsService;

describe('GoogleFontsService', () => {
    beforeEach(() => {
        httpClientSpy = jasmine.createSpyObj('HttpClient', ['get']);
        fontService = new GoogleFontsService(<any> httpClientSpy)
    });

    it('should be created', () => {
        expect(fontService).toBeTruthy();
    });
});
