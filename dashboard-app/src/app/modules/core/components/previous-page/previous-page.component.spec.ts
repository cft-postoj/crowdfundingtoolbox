import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PreviousPageComponent } from './previous-page.component';

describe('PreviousPageComponent', () => {
  let component: PreviousPageComponent;
  let fixture: ComponentFixture<PreviousPageComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PreviousPageComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PreviousPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
