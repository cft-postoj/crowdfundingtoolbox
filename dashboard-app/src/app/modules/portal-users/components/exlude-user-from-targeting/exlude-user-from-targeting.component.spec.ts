import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ExludeUserFromTargetingComponent } from './exlude-user-from-targeting.component';

describe('ExludeUserFromTargetingComponent', () => {
  let component: ExludeUserFromTargetingComponent;
  let fixture: ComponentFixture<ExludeUserFromTargetingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ExludeUserFromTargetingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ExludeUserFromTargetingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
