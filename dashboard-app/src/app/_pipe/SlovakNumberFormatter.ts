import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
  name: 'numbersk'
})
export class SlovakNumberFormatter implements PipeTransform {

  transform(val: number, isCurrency: boolean): string {
    const formatedValue =  val !== undefined && val !== null ? val.toLocaleString('sk') : '';
    return isCurrency ? formatedValue + ' €' : formatedValue;
  }
}
