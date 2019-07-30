import {async, ComponentFixture, TestBed} from '@angular/core/testing';
import {SidebarFooterComponent} from './sidebar-footer.component';
import {InlineSVGModule} from "ng-inline-svg";
import {HttpClientModule} from "@angular/common/http";


describe('SidebarFooterComponent', () => {
    let component: SidebarFooterComponent;
    let fixture: ComponentFixture<SidebarFooterComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            imports: [
                InlineSVGModule.forRoot({baseUrl: 'http://localhost:4200'}),
                HttpClientModule
            ],
            declarations: [SidebarFooterComponent,]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(SidebarFooterComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
