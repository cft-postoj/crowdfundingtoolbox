import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PopupStatisticsComponent } from './popup-statistics.component';

describe('PopupStatisticsComponent', () => {
  let component: PopupStatisticsComponent;
  let fixture: ComponentFixture<PopupStatisticsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PopupStatisticsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PopupStatisticsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
