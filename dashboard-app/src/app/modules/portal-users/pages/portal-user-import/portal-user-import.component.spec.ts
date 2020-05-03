import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PortalUserImportComponent } from './portal-user-import.component';

describe('PortalUserImportComponent', () => {
  let component: PortalUserImportComponent;
  let fixture: ComponentFixture<PortalUserImportComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PortalUserImportComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PortalUserImportComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
