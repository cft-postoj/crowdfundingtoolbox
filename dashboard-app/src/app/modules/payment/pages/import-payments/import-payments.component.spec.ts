import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ImportPaymentsComponent } from './import-payments.component';

describe('ImportPaymentsComponent', () => {
  let component: ImportPaymentsComponent;
  let fixture: ComponentFixture<ImportPaymentsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ImportPaymentsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ImportPaymentsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
