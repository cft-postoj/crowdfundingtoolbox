import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
    name: 'safariDate'
})
export class SafariDatePipe implements PipeTransform {

    transform(string: any): Date | '' {
        if (string == null) {
            return '';
        }
        var a = string.split(/[^0-9]/);
        return new Date(a[0], a[1] - 1 || 0, a[2] || 1, a[3] || 0,
            a[4] || 0, a[5] || 0, a[6] || 0);
    }

}
