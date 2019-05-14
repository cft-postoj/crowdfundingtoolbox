import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {SidebarItemComponent} from './sidebar-item.component';
import {RouterTestingModule} from "@angular/router/testing";
import {ButtonComponent} from "../modules/core/_parts/atoms/button/button.component";

describe('SidebarItemComponent', () => {
    let component: SidebarItemComponent;
    let fixture: ComponentFixture<SidebarItemComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                RouterTestingModule
            ],
            declarations: [SidebarItemComponent, ButtonComponent]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(SidebarItemComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
