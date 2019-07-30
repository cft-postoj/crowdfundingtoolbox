import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserFilterComponent } from './portal-user-filter.component';

describe('PortalUserFilterComponent', () => {
  let component: PortalUserFilterComponent;
  let fixture: ComponentFixture<PortalUserFilterComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserFilterComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserFilterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
