import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {PreviewComponent} from './preview.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {FormsModule} from "@angular/forms";
import {LoadingComponent, RadioButtonGroupComponent} from "../../../core/parts/atoms";
import {SafePipe} from "../../../core/pipes/safe.pipe";

describe('PreviewComponent', () => {
    let component: PreviewComponent;
    let fixture: ComponentFixture<PreviewComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule,
            ],
            declarations: [PreviewComponent, RadioButtonGroupComponent, LoadingComponent, SafePipe]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(PreviewComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
