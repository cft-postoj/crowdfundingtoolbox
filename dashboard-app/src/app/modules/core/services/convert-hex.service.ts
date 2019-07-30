import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ConvertHexService {

  constructor() { }

  public convert(hex) {
    hex = hex.replace('#', '');
    if (hex.length == 3) {
      hex = hex + hex;
    }
    let r = parseInt(hex.substring(0, 2), 16);
    let g = parseInt(hex.substring(2, 4), 16);
    let b = parseInt(hex.substring(4, 6), 16);
    return 'rgba(' + r + ',' + g + ',' + b + ')';
  }
}
