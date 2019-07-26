export const iframeCode = `
  <div class="content" id="cr0wdfundingToolbox-test" data-show-id="0"></div>
  <script type="text/javascript">
    if (dataFromParent) {
      // Subscribe to the Subject so you can trigger changes from Angular
      dataFromParent.subscribe(res => {
        document.querySelector('.content').innerHTML = res;
      })
    }
  </script>
`;
export const globalStyles = `
    <style>
    [id^=cr0wdfundingToolbox] body {height: 100%; background: #FFFFFF;}
    [id^=cr0wdfundingToolbox] *{
        box-sizing: border-box;
    }
    [id^=cr0wdfundingToolbox] .content {width: 100%;}
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:before {
        content: "";
        position: absolute;
        left: 0;
        width: 34px;
        height: 34px;
        background-color: #fff;
        border: 1px solid #bdc2c6;
        border-radius: 50%;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
     [id^=cr0wdfundingToolbox] .cft--monatization--membership-checkbox.active:after{
        content: "";
        position: absolute;
        transition: all .3s ease;
        left: 14px;
        top: 10px;
        width: 6px;
        height: 10px;
        border-width: 0 2px 2px 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    [id^=cr0wdfundingToolbox].cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
     [id^=cr0wdfundingToolbox] .submitted input:invalid ~ label.error {
        display: none;
    }    
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-table{
        width: 100%;
        margin-bottom: 32px;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
     }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 select {
        position: relative;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        padding: 12px;
        height: calc(100% - 2px);
        width: calc(100% - 2px);
        border: none;
        margin: 1px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .bank-button__select:before{
        content: "";
        position: absolute;
        top: 50%;
        bottom: 10px;
        right: 15px;
        display: block;
        width: 0;
        height: 0;
        border-color: #5b6b78 transparent transparent;
        border-style: solid;
        border-width: 5px 5px 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        z-index: 1;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
    }
   [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .head{
        height: 40px;
        font-family: Georgia, Arial, Verdana, sans-serif;
        font-size: 14px;
        color: #5b6b78;
        line-height: 20px;
        padding: 10px 0;
        background-color: #f6f7f8;
        border-bottom: 1px solid #e7e9eb;
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
        }
        
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: '\\25C0';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .step-back:before{
        content: '\\25C0';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    [id^=cr0wdfundingToolbox] .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-inner-spin-button, 
   [id^=cr0wdfundingToolbox] input[type=number].hide-arrows::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
       margin: 0; 
   }
    
</style>
`