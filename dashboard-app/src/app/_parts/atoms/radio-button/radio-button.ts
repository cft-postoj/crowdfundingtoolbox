export class RadioButton {

    name: string;
    value: any;
    icon: string;
    displayName: string;



    constructor(name: string, value: any, icon?:string,displayName?:string) {
        this.name = name;
        this.value = value;
        this.icon = icon;
        this.displayName = displayName;
    }
}

