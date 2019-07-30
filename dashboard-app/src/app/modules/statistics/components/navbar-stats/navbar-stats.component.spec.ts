import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NavbarStatsComponent } from './navbar-stats.component';

describe('NavbarStatsComponent', () => {
  let component: NavbarStatsComponent;
  let fixture: ComponentFixture<NavbarStatsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NavbarStatsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NavbarStatsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
