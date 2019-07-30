import {Component, Input} from '@angular/core';

@Component({
    selector: 'app-progress',
    templateUrl: './progress.component.html',
    styleUrls: ['./progress.component.scss']
})

export class ProgressComponent {
  @Input()
  public total: number;

  @Input()
  public actual: number;

}
