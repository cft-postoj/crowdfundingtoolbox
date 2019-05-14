import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {DashboardComponent} from './dashboard.component';
import {RouterTestingModule} from "@angular/router/testing";
import {TokenExpirationService} from "../../../user-management/services";
import {AppModule} from "../../../../app.module";

class MockTokenExpirationService extends TokenExpirationService {

    constructor() {
        super(null);
    }

    expiration() {
        this.expirationEmitter.emit(true);
    }
}

describe('DashboardComponent', () => {
    let component: DashboardComponent;
    let fixture: ComponentFixture<DashboardComponent>;
    let service;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                RouterTestingModule, AppModule
            ],
            providers: [{provide: TokenExpirationService, useClass: MockTokenExpirationService}]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(DashboardComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
