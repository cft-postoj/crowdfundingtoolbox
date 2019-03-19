import {Component, Input} from '@angular/core';
import {Campaign} from "../../../../_models/campaign";
import {DropdownItem} from "../../../../_models/dropdown-item";
import {RadioButton} from "../../../../_parts/atoms/radio-button/radio-button";
import {backgroundTypes} from "../../../../_models/enums";
import {CampaignService} from "../../../../_services/campaign.service";
import {GoogleFontsService} from "../../../../_services/google-fonts.service";
import {ImageUploadService} from "../../../../_services/image-upload.service";
import {environment} from 'environments/environment';

@Component({
    selector: 'app-widget-settings',
    templateUrl: './widgetSettings.component.html',
    styleUrls: ['../../../../../sass/classes.scss', './widgetSettings.component.scss']
})

export class WidgetSettingsComponent {

    @Input()
    public campaign: Campaign;
    public opened = 1;
    public fontFamily: DropdownItem[] = [];
    public fontWeight: DropdownItem[] = [];
    public radioButtons: RadioButton[] = [];
    public backgroundTypesButtons: RadioButton[];
    public paddingButtons: RadioButton[] = [];
    public marginButtons: RadioButton[] = [];
    public shadowButtons: RadioButton[] = [];
    public radiusButtons: RadioButton[] = [];
    public allRadiusesButton: RadioButton[] = [];
    public specificRadiusButtons: RadioButton[] = [];
    public hoverTypes: DropdownItem[] = [];
    public allRadiuses = 0;
    backgroundTypes = backgroundTypes;
    public specificRadius;

    public addText:boolean;
    public cta:string="Default";




    constructor(private campaignService: CampaignService, private googleFontsService: GoogleFontsService, private imageUpload: ImageUploadService){

    }

    ngOnInit(){
        this.fonts();
        let assetsUrl = (environment.production) ? 'public/app/assets/' : '../../../../assets/';
        this.fontWeight.push({title:"Bold",value:"bold"});
        this.fontWeight.push({title: "Light", value: 100});
        this.fontWeight.push({title: "Medium", value: 400});
        this.radioButtons.push( new RadioButton("left","left",assetsUrl + "images/icons/left.svg"))
        this.radioButtons.push( new RadioButton("center","center",assetsUrl + "images/icons/center.svg"))
        this.radioButtons.push( new RadioButton("right","right",assetsUrl + "images/icons/right.svg"))

        this.backgroundTypesButtons = [];
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.color.name,backgroundTypes.color.value))
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.image.name,backgroundTypes.image.value))
        this.backgroundTypesButtons.push( new RadioButton (backgroundTypes.imageOverlay.name,backgroundTypes.imageOverlay.value))

        this.paddingButtons.push( new RadioButton("top",this.campaign.widget_settings.call_to_action.default.padding.top,assetsUrl + "images/icons/padding_top.svg"))
        this.paddingButtons.push( new RadioButton("right",this.campaign.widget_settings.call_to_action.default.padding.right,assetsUrl + "images/icons/padding_right.svg"))
        this.paddingButtons.push( new RadioButton("bottom",this.campaign.widget_settings.call_to_action.default.padding.bottom,assetsUrl + "images/icons/padding_bottom.svg"))
        this.paddingButtons.push( new RadioButton("left",this.campaign.widget_settings.call_to_action.default.padding.left,assetsUrl + "images/icons/padding_left.svg"))


        this.marginButtons.push( new RadioButton("top",this.campaign.widget_settings.call_to_action.default.margin.top,assetsUrl + "images/icons/margin_top.svg"))
        this.marginButtons.push( new RadioButton("right",this.campaign.widget_settings.call_to_action.default.margin.right,assetsUrl + "images/icons/margin_right.svg"))
        this.marginButtons.push( new RadioButton("bottom",this.campaign.widget_settings.call_to_action.default.margin.bottom,assetsUrl + "images/icons/margin_bot.svg"))
        this.marginButtons.push( new RadioButton("left",this.campaign.widget_settings.call_to_action.default.margin.left,assetsUrl + "images/icons/margin_left.svg"))

        this.shadowButtons.push( new RadioButton("x",this.campaign.widget_settings.call_to_action.default.design.shadow.x,'',"X:"))
        this.shadowButtons.push( new RadioButton("y",this.campaign.widget_settings.call_to_action.default.design.shadow.y,'',"Y:"))
        this.shadowButtons.push( new RadioButton("b",this.campaign.widget_settings.call_to_action.default.design.shadow.b,'',"B:"))

        this.radiusButtons.push( new RadioButton("active",false,assetsUrl + "images/icons/radius_disable.svg"));
        this.radiusButtons.push( new RadioButton("disabled",true,assetsUrl + "images/icons/radius_enable.svg"));

        this.allRadiusesButton.push( new RadioButton("all", this.allRadiuses,assetsUrl + "images/icons/radius_AllTogether.svg"))

        this.specificRadiusButtons.push( new RadioButton("tl", this.campaign.widget_settings.call_to_action.default.design.radius.tl,assetsUrl + "images/icons/radius_LeftTop.svg"))
        this.specificRadiusButtons.push( new RadioButton("tr", this.campaign.widget_settings.call_to_action.default.design.radius.tl,assetsUrl + "images/icons/radius_RightTop.svg"))
        this.specificRadiusButtons.push( new RadioButton("br", this.campaign.widget_settings.call_to_action.default.design.radius.br,assetsUrl + "images/icons/radius_LeftBottom.svg"))
        this.specificRadiusButtons.push( new RadioButton("bl", this.campaign.widget_settings.call_to_action.default.design.radius.bl,assetsUrl + "images/icons/radius_LeftBottom.svg"))

        this.hoverTypes.push({title: "Fade", value: "fade"});
        this.hoverTypes.push({title: "Idk", value: "idk"});


    }

    private fonts() {
        this.googleFontsService.getFonts().subscribe(
            data => {
                if (data.items.length > 0) {
                    this.fontFamily = data.items.map((d) => {
                        return ({title: d.family, value: d.family});
                    })
                }
            }
        );
    }


    public openTab(tabNumber: number) {
        this.opened = this.opened == tabNumber ? 0 : tabNumber;
    }

    public isOpened(tabNumber: number) {
        return this.opened === tabNumber;
    }

    private showCampaign(){
        this.campaignService.createCampaign(this.campaign).subscribe(
            ok =>console.log(ok),
            error1 => console.log(error1)
        )
    }

    setSpecificRadius(value:boolean){
        this.specificRadius=value;
    }

    writeRadiusValue(value) {
        let variables = ['tl', 'tr', 'br', 'bl']
        variables.forEach(variable => {
            this.campaign.widget_settings.call_to_action.default.design.radius[variable] = value;
        })
        this.specificRadiusButtons.forEach(button=>{
            button.value=value;
        })
    }
}
