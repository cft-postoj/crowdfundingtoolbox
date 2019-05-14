import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {WidgetEditComponent} from './widget-edit.component';
import {AppModule} from "../../../app.module";

describe('WidgetEditComponent', () => {
    let component: WidgetEditComponent;
    let fixture: ComponentFixture<WidgetEditComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                AppModule
            ],
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(WidgetEditComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
