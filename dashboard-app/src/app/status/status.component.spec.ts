import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {StatusComponent} from './status.component';
import {SwitcherComponent} from "../_parts/atoms/switcher/switcher.component";
import {CircleProgressComponent} from "ng-circle-progress";
import {SlovakNumberFormatter} from "../_pipe/SlovakNumberFormatter";
import {FormsModule} from "@angular/forms";
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RouterTestingModule} from "@angular/router/testing";

describe('StatusComponent', () => {
    let component: StatusComponent;
    let fixture: ComponentFixture<StatusComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule,
                RouterTestingModule],
            declarations: [StatusComponent, SwitcherComponent, CircleProgressComponent, SlovakNumberFormatter]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(StatusComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
