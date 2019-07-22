import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {OverallComponent} from './pages/overall/overall.component';
import {Routing} from '../../constants/config.constants';
import {PopupStatisticsComponent} from './components/popup-statistics/popup-statistics.component';

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
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class StatisticsRoutingModule {

}
