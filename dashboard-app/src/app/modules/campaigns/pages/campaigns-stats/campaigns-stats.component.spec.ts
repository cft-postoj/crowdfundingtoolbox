import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CampaignsStatsComponent } from './campaigns-stats.component';

describe('CampaignsStatsComponent', () => {
  let component: CampaignsStatsComponent;
  let fixture: ComponentFixture<CampaignsStatsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CampaignsStatsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CampaignsStatsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
