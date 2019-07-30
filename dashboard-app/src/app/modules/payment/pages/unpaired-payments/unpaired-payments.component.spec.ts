import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UnpairedPaymentsComponent } from './unpaired-payments.component';

describe('UnpairedPaymentsComponent', () => {
  let component: UnpairedPaymentsComponent;
  let fixture: ComponentFixture<UnpairedPaymentsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UnpairedPaymentsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UnpairedPaymentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
