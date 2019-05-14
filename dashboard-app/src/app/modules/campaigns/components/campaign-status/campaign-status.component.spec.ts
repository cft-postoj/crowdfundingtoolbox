import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {CampaignStatusComponent} from './status.component';
import {SwitcherComponent} from "../modules/core/_parts/atoms/switcher/switcher.component";
import {CircleProgressComponent} from "ng-circle-progress";
import {SlovakNumberFormatter} from "../_pipe/SlovakNumberFormatter";
import {FormsModule} from "@angular/forms";
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {RouterTestingModule} from "@angular/router/testing";

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
