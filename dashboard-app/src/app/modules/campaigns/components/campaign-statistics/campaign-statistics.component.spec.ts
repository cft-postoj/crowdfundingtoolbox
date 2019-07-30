import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import {CampaignStatisticsComponent} from "./campaign-statistics.component";


describe('CampaignStatisticsComponent', () => {
  let component: CampaignStatisticsComponent;
  let fixture: ComponentFixture<CampaignStatisticsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CampaignStatisticsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CampaignStatisticsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
