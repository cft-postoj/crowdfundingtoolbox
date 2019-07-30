import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'monthly'
})
export class MonthlyPipe implements PipeTransform {

    transform(value: any): 'monthly' | 'one time' {
        return value ? 'monthly' : 'one time';
    }

}
