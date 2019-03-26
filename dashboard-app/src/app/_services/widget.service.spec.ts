import {WidgetService} from './widget.service';

let httpClientSpy: { get: jasmine.Spy };
let widgetService: WidgetService;

describe('WidgetService', () => {
    beforeEach(() => {
        httpClientSpy = jasmine.createSpyObj('HttpClient', ['get']);
        widgetService = new WidgetService(<any> httpClientSpy)
    });

    it('should be created', () => {
        expect(widgetService).toBeTruthy();
    });
});
