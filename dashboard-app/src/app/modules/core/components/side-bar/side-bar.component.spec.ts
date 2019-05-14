import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {SideBarComponent} from './side-bar.component';
import {FormsModule} from "@angular/forms";
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";
import {SidebarItemComponent} from "../sidebar-item/sidebar-item.component";
import {SidebarFooterComponent} from "../sidebar-footer/sidebar-footer.component";
import {ButtonComponent} from "../modules/core/_parts/atoms/button/button.component";
import {RouterTestingModule} from "@angular/router/testing";

describe('SideBarComponent', () => {
    let component: SideBarComponent;
    let fixture: ComponentFixture<SideBarComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [FormsModule,
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule,
                RouterTestingModule
            ],
            declarations: [SideBarComponent, SidebarItemComponent, SidebarFooterComponent, ButtonComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(SideBarComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
