import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DonorsNewComponent } from './donors-new.component';

describe('DonorsNewComponent', () => {
  let component: DonorsNewComponent;
  let fixture: ComponentFixture<DonorsNewComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DonorsNewComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DonorsNewComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
