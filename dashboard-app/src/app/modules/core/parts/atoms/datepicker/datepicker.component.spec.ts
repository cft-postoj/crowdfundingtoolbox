import {ComponentFixture, TestBed} from '@angular/core/testing';
import {environment} from 'environments/environment';
import {DatepickerComponent} from './datepicker.component';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {FormsModule} from "@angular/forms";

describe('DatepickerComponent', () => {
    let component: DatepickerComponent;
    let fixture: ComponentFixture<DatepickerComponent>;
    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                NgbModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule],
            declarations: [DatepickerComponent]
        });
        fixture = TestBed.createComponent(DatepickerComponent);
        component = fixture.componentInstance;
    });
    it('can load instance', () => {
        expect(component).toBeTruthy();
    });
    it('displayMonths defaults to: 1', () => {
        expect(component.displayMonths).toEqual(1);
    });
    it('navigation defaults to: select', () => {
        expect(component.navigation).toEqual('select');
    });
    it('showWeekNumbers defaults to: false', () => {
        expect(component.showWeekNumbers).toEqual(false);
    });
    it('outsideDays defaults to: visible', () => {
        expect(component.outsideDays).toEqual('visible');
    });
    it('environment defaults to: environment', () => {
        expect(component.environment).toEqual(environment);
    });
});
