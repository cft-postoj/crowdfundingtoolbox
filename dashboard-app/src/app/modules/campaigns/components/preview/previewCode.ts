export const iframeCode = `
  <div class="content"></div>
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
    div {
    box-sizing: border-box;
    }
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
</style>
`