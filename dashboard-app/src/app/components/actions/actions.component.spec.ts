import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {ActionsComponent} from './actions.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RadioButtonGroupComponent} from "../paddings/atoms/radio-button-group/radio-button-group.component";

describe('ActionsComponent', () => {
    let component: ActionsComponent;
    let fixture: ComponentFixture<ActionsComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule],
            declarations: [ActionsComponent, RadioButtonGroupComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(ActionsComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
