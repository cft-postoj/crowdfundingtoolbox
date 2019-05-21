import {Component, OnDestroy, OnInit} from '@angular/core';
import {Router} from "@angular/router";
import {Routing} from "../../../../constants/config.constants";
import {DropdownItem} from "../../../core/models";

@Component({
  selector: 'app-campaign-not-found',
  templateUrl: './campaign-not-found.component.html',
  styleUrls: ['./campaign-not-found.component.scss']
})
export class CampaignNotFoundComponent implements OnInit {

  public pageTitle = 'All campaigns';
  public routing = Routing;
  public dropdownItems: DropdownItem[];
  public loading: boolean = true;

  constructor(public router: Router){}

  ngOnInit(): void {
  }


}
