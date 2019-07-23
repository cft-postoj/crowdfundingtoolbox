import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {OverallComponent} from './pages/overall/overall.component';
import {Routing} from '../../constants/config.constants';
import {PopupStatisticsComponent} from './components/popup-statistics/popup-statistics.component';
import {ArticlesComponent} from './pages/articles/articles.component';
import {CampaignsComponent} from './pages/campaigns/campaigns.component';

const routes: Routes = [
    {
        path: 'all',
        component: OverallComponent,
        children: [
            {
                path: Routing.DONORS + '/:modalOpened/:tableDonors/:tablePayments/' +
                    ':from/:to/:monthly/:tableTitle/:dataType',
                component: PopupStatisticsComponent,
                outlet: 'popup'
            }
        ]
    },
    {
        path: 'articles',
        component: ArticlesComponent
    },
    {
        path: 'campaigns',
        component: CampaignsComponent
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class StatisticsRoutingModule {

}
