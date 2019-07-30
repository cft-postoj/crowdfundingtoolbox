import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {AboutComponent} from './about.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";

describe('AboutComponent', () => {
    let component: AboutComponent;
    let fixture: ComponentFixture<AboutComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule
            ],
            declarations: [AboutComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(AboutComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
