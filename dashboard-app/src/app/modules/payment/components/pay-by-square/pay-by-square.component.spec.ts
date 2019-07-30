import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PayBySquareComponent } from './pay-by-square.component';

describe('PayBySquareComponent', () => {
  let component: PayBySquareComponent;
  let fixture: ComponentFixture<PayBySquareComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PayBySquareComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PayBySquareComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
