import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {InputGroupComponent} from './input-group.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {FormsModule} from "@angular/forms";

describe('InputGroupComponent', () => {
    let component: InputGroupComponent;
    let fixture: ComponentFixture<InputGroupComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule
            ],
            declarations: [InputGroupComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(InputGroupComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
