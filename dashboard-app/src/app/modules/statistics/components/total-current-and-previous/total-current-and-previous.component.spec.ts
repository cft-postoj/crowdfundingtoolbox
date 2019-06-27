import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TotalCurrentAndPreviousComponent } from './total-current-and-previous.component';

describe('TotalCurrentAndPreviousComponent', () => {
  let component: TotalCurrentAndPreviousComponent;
  let fixture: ComponentFixture<TotalCurrentAndPreviousComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TotalCurrentAndPreviousComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TotalCurrentAndPreviousComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
