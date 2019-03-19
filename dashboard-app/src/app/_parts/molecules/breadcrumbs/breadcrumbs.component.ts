import {Component, Input, OnInit} from '@angular/core';
import {Router} from '@angular/router';

@Component({
  selector: 'app-breadcrumbs',
  templateUrl: './breadcrumbs.component.html',
  styleUrls: ['./breadcrumbs.component.scss']
})

export class BreadcrumbsComponent implements OnInit {
  @Input() pages: any;
  @Input() pageTitle: string;
  public parentPage: any = {};

  constructor(private router: Router) {
    const actualUrl = this.router.url;


    this.router.config.map((route) => {
      if (route.path === 'dashboard') {
        route.children.map((ch) => {
          if (ch.path.indexOf('/') > -1) {
            let splitter = ch.path.split('/');
            if (actualUrl.indexOf(splitter[0]) > -1 && splitter[1] != ':id') {
                this.parentPage = {
                    title: ch.data.title,
                    path: '/dashboard/' + ch.path
                };
            }
          }
        });
      }
    });
  }

  ngOnInit() {
  }
}
