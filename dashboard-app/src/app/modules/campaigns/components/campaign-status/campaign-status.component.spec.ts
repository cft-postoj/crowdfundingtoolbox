import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {CircleProgressComponent} from "ng-circle-progress";
import {FormsModule} from "@angular/forms";
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RouterTestingModule} from "@angular/router/testing";
import {CampaignStatusComponent} from "./campaign-status.component";
import {SwitcherComponent} from "../../../core/parts/atoms";
import {SlovakNumberFormatter} from "../../../core/pipes/SlovakNumberFormatter";

describe('CampaignStatusComponent', () => {
    let component: CampaignStatusComponent;
    let fixture: ComponentFixture<CampaignStatusComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule,
                RouterTestingModule],
            declarations: [CampaignStatusComponent, SwitcherComponent, CircleProgressComponent, SlovakNumberFormatter]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(CampaignStatusComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
