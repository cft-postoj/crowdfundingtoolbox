import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {RadioButtonGroupComponent} from './radio-button-group.component';
import {AppModule} from "../../../app.module";

describe('RadioButtonGroupComponent', () => {
    let component: RadioButtonGroupComponent;
    let fixture: ComponentFixture<RadioButtonGroupComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [AppModule]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(RadioButtonGroupComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
