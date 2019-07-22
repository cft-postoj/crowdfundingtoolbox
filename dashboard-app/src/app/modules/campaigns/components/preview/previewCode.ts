export const iframeCode = `
  <div class="content" id="cr0wdFundingToolbox-test" data-show-id="0"></div>
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
    body {height: 100%; background: #FFFFFF;}
    .content {width: 100%;}
    
    .cft--monatization--membership-checkbox {
        position: relative;
        float: left
    }
    
    .cft--monatization--membership-checkbox:before {
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
    
    .cft--monatization--membership-checkbox:after {
        content: "";
        position: absolute;
        top: 18px;
        left: 13px;
        width: 10px;
        height: 8px;
        transition: all .3s ease
    }
    
    .cft--monatization--membership-checkbox.active:after{
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

    .cft--monatization--donation-button input[type=number]::-webkit-inner-spin-button, 
    .cft--monatization--donation-button input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    
    .submitted input:invalid ~ label.error {
        display: block!important;
    }
    
    .submitted input:invalid ~ label.error {
        display: none;
    }    
    .cft--monetization--container-step-2 .payment-table{
    width: 100%;
    }
    .cft--monetization--container-step-2 .payment-title{
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
        padding: 18px 0;
    }
    
    .cft--monetization--container-step-2 .bank-button-container{
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
    }
    
    .cft--monetization--container-step-2 .bank-button__wrapper{
          position: relative;
          display: flex;
          display: -ms-flexbox;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          width:100%;
          border: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container-step-2 .payment-value{
        font-weight: 700;
        padding: 18px 10px;
        color: #2b2b2b;
        text-align: left;
        border-bottom: 1px solid #e6e9eb;
    }
    
    .cft--monetization--container-step-2 .bank-button__container{
        text-align: center;
        flex: 0 0 33.33333334%;
        max-width: 33.333334%;
        position: relative;
        height: 48px;
        }
    .cft--monetization--container-step-2 .bank-button{
        border: 1px solid #e6e9eb;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
     .cft--monetization--container-step-2 .bank-button:hover{
        border: 1px solid #0c84df;
     }
     .cft--monetization--container-step-2 .bank-button.active{
        border: 1px solid #32a300;
     }
    .cft--monetization--container-step-2 .bank-button img{
        position: absolute;      
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
     }
    .cft--monetization--container-step-2 select {
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
    .cft--monetization--container-step-2 .bank-button__select:before{
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
    .cft--monetization--container-step-2 .payment-options{
        display: flex;
        width: 100%;
        margin: 20px 0 30px;
    }
    .cft--monetization--container-step-2 .payment-options__button{
        flex: 1;
        text-align: center;
        padding: 6px 12px;
        margin-right: 2%;
        background-color: #f6f7f8;
        border: 1px solid #e7e9eb;
        border-radius: 2px;
        min-height: 32px;
    }
    .cft--monetization--container-step-2 .payment-options__button label{
       display: block;
       padding-top: 6px;
       mouse: pointer;
    }
    .cft--monetization--container .head{
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
        
    .cft--monetization--container .step-back{
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-right: 1px solid #e7e9eb;
        cursor: pointer;
    }
    .cft--monetization--container .step-back:before{
        content: '\\25C0';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .step-back:before{
        content: '\\25C0';
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -11px;
        margin-left: -6px;
    }
    .cft--monetization--container .pay-by-square__wrapper{
        text-align: center;
    }

    .cft--monetization--container .pay-by-square__wrapper svg{
        max-width: 210px;
    }
    
</style>
`