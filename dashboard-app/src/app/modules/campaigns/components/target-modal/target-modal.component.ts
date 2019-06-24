import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'app-target-modal',
  templateUrl: './target-modal.component.html',
  styleUrls: ['./target-modal.component.scss']
})
export class TargetModalComponent implements OnInit {

  @Input()
  public usersCount: number;

  @Input()
  public visitorsCount: number;

  constructor() { }

  ngOnInit() {
    this.usersCount = 0;
  }

}
