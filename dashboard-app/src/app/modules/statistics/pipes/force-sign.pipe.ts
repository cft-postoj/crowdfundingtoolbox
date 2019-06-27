import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'forceSign'
})
export class ForceSignPipe implements PipeTransform {

    transform(value: number): any {
        return (value < 0 ? '' : '+') + value;
    }

}
