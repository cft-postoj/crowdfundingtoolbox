import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ConvertHexService {

  constructor() { }

  public convert(hex, opacity) {
    hex = hex.replace('#', '');
    if (hex.length == 3) {
      hex = hex + hex;
    }
    let r = parseInt(hex.substring(0, 2), 16);
    let g = parseInt(hex.substring(3, 4), 16);
    let b = parseInt(hex.substring(5, 6), 16);

    return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity/100 + ')';
  }
}
