import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DonorStatusComponent } from './donor-status.component';

describe('DonorStatusComponent', () => {
  let component: DonorStatusComponent;
  let fixture: ComponentFixture<DonorStatusComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DonorStatusComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DonorStatusComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
