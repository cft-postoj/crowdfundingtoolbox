import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BackToListComponent } from './back-to-list.component';

describe('BackToListComponent', () => {
  let component: BackToListComponent;
  let fixture: ComponentFixture<BackToListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BackToListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BackToListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
