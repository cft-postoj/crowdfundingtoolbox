import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {PreviewComponent} from './preview.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RadioButtonGroupComponent} from "../../_parts/atoms/radio-button-group/radio-button-group.component";
import {LoadingComponent} from "../../_parts/atoms/loading/loading.component";
import {FormsModule} from "@angular/forms";
import {SafePipe} from "../../_pipe/safe.pipe";

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
