import {ImageUploadService} from './image-upload.service';

let httpClientSpy: { get: jasmine.Spy };
let imageUploadService: ImageUploadService;

describe('ImageUploadService', () => {
    beforeEach(() => {
        httpClientSpy = jasmine.createSpyObj('HttpClient', ['get']);
        imageUploadService = new ImageUploadService(<any> httpClientSpy)
    });

    it('should be created', () => {
        expect(imageUploadService).toBeTruthy();
    });
});
