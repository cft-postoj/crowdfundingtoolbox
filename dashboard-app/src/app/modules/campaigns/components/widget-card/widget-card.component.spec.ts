import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {CircleProgressComponent} from "ng-circle-progress";
import {FormsModule} from "@angular/forms";
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RouterTestingModule} from "@angular/router/testing";
import {SwitcherComponent} from "../../../core/parts/atoms";
import {SlovakNumberFormatter} from "../../../core/pipes/SlovakNumberFormatter";
import {WidgetCardComponent} from './widget-card.component';

describe('WidgetCardComponent', () => {
    let component: WidgetCardComponent;
    let fixture: ComponentFixture<WidgetCardComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule,
                RouterTestingModule],
            declarations: [WidgetCardComponent, SwitcherComponent, CircleProgressComponent, SlovakNumberFormatter]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(WidgetCardComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
