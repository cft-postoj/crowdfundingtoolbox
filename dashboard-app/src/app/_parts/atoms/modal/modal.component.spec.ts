import {async, ComponentFixture, TestBed} from '@angular/core/testing';
import {ModalComponent} from './modal.component';
import {NgbActiveModal} from "@ng-bootstrap/ng-bootstrap";

describe('ModalComponent', () => {
    let component: ModalComponent;
    let fixture: ComponentFixture<ModalComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            declarations: [ModalComponent],
            providers: [NgbActiveModal]
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(ModalComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
